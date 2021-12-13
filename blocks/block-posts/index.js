/**
 * BLOCK - posts
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.6.0
 */

const apiFetch = wp.apiFetch;
const { registerBlockType } = wp.blocks // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    InspectorControls
} = wp.blockEditor
const {
    PanelBody,
    SelectControl,
    TextControl,
    ToggleControl
} = wp.components
const { Component } = wp.element
const { __ } = wp.i18n

registerBlockType('idsk/posts', {
    // built-in attributes
    title: __('Články', 'idsk-toolkit'),
    description: __('Zobrazuje články na stránke podľa nastavení.', 'idsk-toolkit'),
    icon: 'feedback',
    category: 'idsk-components',
    keywords: [
        __('články', 'idsk-toolkit'),
        __('aktuality', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        title: {
            type: 'string',
            selector: 'h2.govuk-heading-l'
        },
        showIntro: {
            type: 'boolean',
            selector: 'js-posts-show-intro',
            default: true
        },
        postCount: {
            type: 'number',
            default: 4
        },
        postCategory: {
            type: 'integer',
            default: 0
        }
    },

    // The UI for the WordPress editor
    edit: class PostsComponent extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                showIntro: this.props.attributes.showIntro,
                postCount: this.props.attributes.postCount,
                posts: [],
                postsThumbnails: [],
                postsOutput: null,
                postCategory: this.props.attributes.postCategory,
                postCategories: []
            }

            this.onChange = this.onChange.bind(this)
            this.getPosts = this.getPosts.bind(this)
            this.getPostCategories = this.getPostCategories.bind(this)
            this.getPostsThumbnails = this.getPostsThumbnails.bind(this)
        }

        // Fetch posts and categories
        componentDidMount() {
            this.getPostCategories()
        }

        componentDidUpdate(prevProps, prevState) {
            if (prevState.showIntro !== this.state.showIntro) {
                this.setPostsHtml()
            }

            if (prevState.postCategory !== this.state.postCategory
                || prevState.postCount !== this.state.postCount
            ) {
                this.getPosts()
            }
        }

        // custom functions
        onChange(attribute, value, type = '') {
            return (
                this.setState({
                    [attribute]: type == 'number' ? parseInt(value) : value
                }, () => {
                    this.props.setAttributes({
                        [attribute]: type == 'number' ? parseInt(value) : value
                    })
                })
            )
        }

        getPostCategories() {
            return apiFetch({ path: '/wp/v2/categories/?per_page=-1' }).then( ( categories ) => {
                if ( categories && this.state.postCategory !== 0 ) {
                    const category = categories.find( ( item ) => item.id === this.state.postCategory )

                    this.setState({
                        postCategory: parseInt(category.id),
                        postCategories: categories
                    }, () => {
                        this.getPosts()
                    })
                } else {
                    this.setState({
                        postCategories: categories
                    }, () => {
                        this.getPosts()
                    })
                }
            })
        }

        getPosts() {
            const categoriesParam = this.state.postCategory > 0 ? '&categories=' + this.state.postCategory : ''

            return apiFetch({ path: '/wp/v2/posts/?per_page=' + this.state.postCount + categoriesParam }).then( ( posts ) => {
                this.setState({
                    posts: posts
                }, () => {
                    this.getPostsThumbnails()
                })
            })
        }

        async getPostsThumbnails() {
            const mediaData = await Promise.all(
                this.state.posts.map( ( post ) => {
                    if (post.featured_media && post.featured_media > 0) {
                        return apiFetch({ path: '/wp/v2/media/'+post.featured_media })
                            .then( ( media ) => {
                                return {
                                    post_id: post.id,
                                    link: media.source_url
                                }
                            })
                            .catch( ( error ) => {
                                return {
                                    post_id: post.id,
                                    link: pluginData.dir+'assets/images/image-placeholder.jpg'
                                }
                            })
                    }
                })
            )

            this.setState({
                postsThumbnails: mediaData
            }, () => {
                this.setPostsHtml()
            })
        }

        setPostsHtml() {
            if (this.state.posts.length > 0) {
                const posts = this.state.posts

                if (this.state.showIntro) {
                    const intro = <div class="govuk-grid-row">
                            <div class="govuk-grid-column-full">
                                {this.renderPost(posts[0], 'hero')}
                            </div>
                        </div>
                    const outro = this.renderPostGroup(posts.slice(1))

                    this.setState({
                        postsOutput: <>{intro}{outro}</>
                    })
                } else {
                    this.setState({
                        postsOutput: this.renderPostGroup(this.state.posts)
                    })
                }
            } else {
                this.setState({
                    postsOutput: __('Nenašli sa žiadne články', 'idsk-toolkit')
                })
            }
        }

        renderPostGroup(items) {
            const helper = [...items]
            let groups = []

            while (helper.length) {
                groups.push( helper.splice(0, 3) )
            }

            const output = groups.map( ( group ) => {
                const inner = <div class="govuk-grid-row">
                    {(
                        group.map( ( post ) => {
                            return <div class="govuk-grid-column-one-third">
                                {this.renderPost(post, 'secondary')}
                            </div>
                        })
                    )}
                </div>

                return inner
            })

            return output
        }

        renderPost(post, classType = 'hero') {
            const thumb = this.state.postsThumbnails.find( (thumbs) => typeof thumbs !== 'undefined' && thumbs.post_id === post.id )
            const imgLink = thumb && thumb.link ? thumb.link : pluginData.dir+'assets/images/image-placeholder.jpg'
            const postCreated = new Date( post.date_gmt.substring( 0, post.date_gmt.indexOf('T') ) ).toLocaleDateString()
            const outputCategories = post.categories.map( (category) => {
                const links = this.state.postCategories.filter( e => e.id === category )
                    .map( cat => <span class="idsk-card-meta idsk-card-meta-tag">
                            <a href={cat.link} class="govuk-link" title={cat.name}>{cat.name}</a>
                        </span>
                    )

                return links
            })

            return <div className={"idsk-card idsk-card-"+classType}>
                <a href={post.link} title={post.title.rendered}>
                    <img class={"idsk-card-img idsk-card-img-"+classType} width="100%" src={imgLink} alt={post.title.rendered} aria-hidden="true" />
                </a>

                <div class={"idsk-card-content idsk-card-content-"+classType}>
                    <div class="idsk-card-meta-container">
                        <span class="idsk-card-meta idsk-card-meta-date">
                            <a href={post.link} class="govuk-link" title={__( 'Pridané dňa:', 'idsk-toolkit' )+' '+postCreated}>{postCreated}</a>
                        </span>
                        {outputCategories}
                    </div>

                    <div class={"idsk-heading idsk-heading-"+classType}>
                        <a href={post.link} class="idsk-card-title govuk-link" title={post.title.rendered} dangerouslySetInnerHTML={{__html: post.title.rendered}}></a>
                    </div>

                    <p class={"idsk-body idsk-body-"+classType} dangerouslySetInnerHTML={{__html: post.excerpt.rendered}}></p>
                </div>
            </div>
        }

        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { title, postCount, showIntro, postCategory } = attributes

            let options = [{
                value: 0,
                label: __('Vyberte kategóriu článkov', 'idsk-toolkit')
            }]

            if (this.state.postCategories.length > 0) {
                this.state.postCategories.forEach( (category) => {
                    options = [...options, {
                        value: category.id,
                        label: category.name
                    }]
                })
            }

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Nastavenia zobrazenia článkov', 'idsk-toolkit')}>
                        <ToggleControl
                            className={"js-posts-show-intro"}
                            checked={showIntro}
                            label={__('Zobrazovať úvodný článok', 'idsk-toolkit')}
                            onChange={checked => this.onChange('showIntro', checked)}
                        />
                        <TextControl
                            value={postCount}
                            label={__('Počet zobrazených článkov', 'idsk-toolkit')}
                            type="number"
                            onChange={value => value > 0 ? this.onChange('postCount', value, 'number') : this.onChange('postCount', 1, 'number')}
                        />
                        <SelectControl
                            value={postCategory}
                            label={__('Kategória článkov', 'idsk-toolkit')}
                            options={options}
                            onChange={value => this.onChange('postCategory', value, 'number')}
                        />
                    </PanelBody>
                </InspectorControls>

                <RichText
                    className="govuk-heading-l"
                    key="editable"
                    tagName="h2"
                    placeholder={__('Nadpis', 'idsk-toolkit')}
                    value={title}
                    onChange={value => this.onChange('title', value)}
                />

                {this.state.postsOutput}
            </div>
        }
    },

    // No save, dynamic block
    save() {
        return null
    },
})