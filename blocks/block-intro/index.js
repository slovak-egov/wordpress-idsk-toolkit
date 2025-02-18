/**
 * BLOCK - intro
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    InnerBlocks,
    InspectorControls
} = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    TextControl,
    RadioControl,
    ToggleControl
} = wp.components;
const { Component, createElement } = wp.element;
const { __ } = wp.i18n;

registerBlockType('idsk/intro', {
    // built-in attributes
    title: __('Intro block', 'idsk-toolkit'),
    description: __('Shows intro block for websites. Various types of displays are available.', 'idsk-toolkit'),
    icon: 'editor-table',
    category: 'idsk-components',
    keywords: [
        __('intro', 'idsk-toolkit'),
        __('block', 'idsk-toolkit'),
        __('search', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        title: {
            type: 'string',
            selector: 'h2-main'
        },
        subTitle: {
            type: 'string',
            selector: 'idsk-intro-block__subtitle'
        },
        withSearch: {
            type: 'boolean',
            selector: 'js-intro-search',
        },
        searchTitle: {
            type: 'string',
            selector: 'idsk-intro-block__bottom-menu__li'
        },

        // search URLs attributes
        url1: {
            type: 'string',
            selector: 'js-search-link-1-href'
        },
        urlText1: {
            type: 'string',
            selector: 'js-search-link-1-text'
        },
        url2: {
            type: 'string',
            selector: 'js-search-link-2-href'
        },
        urlText2: {
            type: 'string',
            selector: 'js-search-link-2-text'
        },
        url3: {
            type: 'string',
            selector: 'js-search-link-3-href'
        },
        urlText3: {
            type: 'string',
            selector: 'js-search-link-3-text'
        },
        url4: {
            type: 'string',
            selector: 'js-search-link-4-href'
        },
        urlText4: {
            type: 'string',
            selector: 'js-search-link-4-text'
        },
        url5: {
            type: 'string',
            selector: 'js-search-link-5-href'
        },
        urlText5: {
            type: 'string',
            selector: 'js-search-link-5-text'
        },

        sideStyle: {
            option: '',
            default: 'default',
            selector: 'js-side-style'
        },
        sideTitle: {
            type: 'string',
            selector: 'h2-side'
        },
        sideContent: {
            type: 'string',
            selector: 'idsk-intro-block__side-menu__ul'
        },
    },
    
    edit: class Intro extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                withSearch: this.props.attributes.withSearch
            };

            this.onChange = this.onChange.bind(this);
        }

        onChange(attribute, value) {
            return (
                this.props.setAttributes(
                    { [attribute]: value }
                )
            )
        }
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { title, subTitle, withSearch, searchTitle, url1, urlText1, url2, urlText2, url3, urlText3, url4, urlText4, url5, urlText5, sideStyle, sideTitle, sideContent } = attributes

            const searchIcon = createElement('svg',
                {
                    width: 18,
                    height: 18,
                    viewBox: "0 0 31 30",
                    fill: "none",
                    xlmns: "http://www.w3.org/2000/svg"
                },
                createElement('path',
                {
                    fill: "white",
                    d: "M21.0115 13.103C21.0115 17.2495 17.5484 20.6238 13.2928 20.6238C9.03714 20.6238 5.57404 17.2495 5.57404 13.103C5.57404 8.95643 9.03714 5.58212 13.2928 5.58212C17.5484 5.58212 21.0115 8.95643 21.0115 13.103ZM29.833 27.0702C29.833 26.4994 29.5918 25.9455 29.1955 25.5593L23.2858 19.8012C24.6814 17.8371 25.4223 15.4868 25.4223 13.103C25.4223 6.57259 19.995 1.28451 13.2928 1.28451C6.59058 1.28451 1.16333 6.57259 1.16333 13.103C1.16333 19.6333 6.59058 24.9214 13.2928 24.9214C15.7394 24.9214 18.1515 24.1995 20.1673 22.8398L26.077 28.5811C26.4732 28.984 27.0418 29.219 27.6276 29.219C28.8337 29.219 29.833 28.2453 29.833 27.0702Z"
                }),
                createElement('path',
                {
                    fill: "white",
                    fillRule: "evenodd",
                    clipRule: "evenodd",
                    d: "M0.75708 13.103C0.75708 6.35398 6.36621 0.888672 13.2928 0.888672C20.2194 0.888672 25.8285 6.35398 25.8285 13.103C25.8285 15.4559 25.1301 17.7778 23.8094 19.7516L29.4827 25.2794C29.9551 25.7396 30.2392 26.3943 30.2392 27.0702C30.2392 28.464 29.058 29.6149 27.6276 29.6149C26.9347 29.6149 26.2611 29.3385 25.787 28.8584L20.1168 23.3497C18.0909 24.6367 15.7078 25.3172 13.2928 25.3172C6.36621 25.3172 0.75708 19.8519 0.75708 13.103ZM13.2928 1.68034C6.81494 1.68034 1.56958 6.7912 1.56958 13.103C1.56958 19.4147 6.81494 24.5256 13.2928 24.5256C15.6581 24.5256 17.9892 23.8275 19.9361 22.5143L20.2144 22.3265L26.3704 28.3071C26.6886 28.6308 27.1506 28.8232 27.6276 28.8232C28.6093 28.8232 29.4267 28.0267 29.4267 27.0702C29.4267 26.6046 29.2285 26.1513 28.9082 25.8392L22.7588 19.8475L22.9518 19.5759C24.2996 17.679 25.016 15.4076 25.016 13.103C25.016 6.7912 19.7706 1.68034 13.2928 1.68034ZM13.2928 5.97796C9.26151 5.97796 5.98029 9.17504 5.98029 13.103C5.98029 17.0309 9.26151 20.228 13.2928 20.228C17.3241 20.228 20.6053 17.0309 20.6053 13.103C20.6053 9.17504 17.3241 5.97796 13.2928 5.97796ZM5.16779 13.103C5.16779 8.73781 8.81278 5.18629 13.2928 5.18629C17.7728 5.18629 21.4178 8.73781 21.4178 13.103C21.4178 17.4681 17.7728 21.0196 13.2928 21.0196C8.81278 21.0196 5.16779 17.4681 5.16779 13.103Z"
                })
            )
            
            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Content display', 'idsk-toolkit')}>
                        <PanelRow>
                            <ToggleControl
                                className="js-intro-search"
                                checked={withSearch}
                                label={withSearch ? __('With search', 'idsk-toolkit') : __('Without search', 'idsk-toolkit')}
                                onChange={checked => setAttributes({ withSearch: checked })}
                            />
                        </PanelRow>
                        <PanelRow>
                            <RadioControl
                                className="js-side-style"
                                label={__('Sidebar display style', 'idsk-toolkit')}
                                selected={ sideStyle }
                                options={ [
                                    { 
                                        label: __('Basic display', 'idsk-toolkit'),
                                        value: 'default' 
                                    },
                                    { 
                                        label: __('Blue display', 'idsk-toolkit'),
                                        value: 'app-pane-blue' 
                                    },
                                    { 
                                        label: __('Transparent display', 'idsk-toolkit'),
                                        value: 'app-pane-transparent' 
                                    },
                                ] }
                                onChange={ ( option ) => { setAttributes( { sideStyle: option } ) } }
                            />
                        </PanelRow>
                    </PanelBody>

                    {!!withSearch &&
                    <PanelBody title={__('Search links', 'idsk-toolkit')}>
                        <h3>{__('Link 1', 'idsk-toolkit')}</h3>
                        <TextControl
                            className="js-search-link-1-text"
                            key="editable"
                            placeholder={__('Link 1', 'idsk-toolkit')}
                            label={__('Link 1 name', 'idsk-toolkit')}
                            value={urlText1}
                            onChange={value => this.onChange('urlText1', value)} 
                        />
                        <TextControl
                            className="js-search-link-1-href"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('Link 1 URL', 'idsk-toolkit')}
                            value={url1}
                            onChange={value => this.onChange('url1', value)} 
                        />
                        
                        <h3>{__('Link 2', 'idsk-toolkit')}</h3>
                        <TextControl
                            className="js-search-link-2-text"
                            key="editable"
                            placeholder={__('Link 2', 'idsk-toolkit')}
                            label={__('Link 2 name', 'idsk-toolkit')}
                            value={urlText2}
                            onChange={value => this.onChange('urlText2', value)} 
                        />
                        <TextControl
                            className="js-search-link-2-href"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('Link 2 URL', 'idsk-toolkit')}
                            value={url2}
                            onChange={value => this.onChange('url2', value)}  
                        />
                        
                        <h3>{__('Link 3', 'idsk-toolkit')}</h3>
                        <TextControl
                            className="js-search-link-3-text"
                            key="editable"
                            placeholder={__('Link 3', 'idsk-toolkit')}
                            label={__('Link 3 name', 'idsk-toolkit')}
                            value={urlText3}
                            onChange={value => this.onChange('urlText3', value)} 
                        />
                        <TextControl
                            className="js-search-link-3-href"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('Link 3 URL', 'idsk-toolkit')}
                            value={url3}
                            onChange={value => this.onChange('url3', value)} 
                        />
                        
                        <h3>{__('Link 4', 'idsk-toolkit')}</h3>
                        <TextControl
                            className="js-search-link-4-text"
                            key="editable"
                            placeholder={__('Link 4', 'idsk-toolkit')}
                            label={__('Link 4 name', 'idsk-toolkit')}
                            value={urlText4}
                            onChange={value => this.onChange('urlText4', value)} 
                        />
                        <TextControl
                            className="js-search-link-4-href"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('Link 4 URL', 'idsk-toolkit')}
                            value={url4}
                            onChange={value => this.onChange('url4', value)} 
                        />
                        
                        <h3>{__('Link 5', 'idsk-toolkit')}</h3>
                        <TextControl
                            className="js-search-link-5-text"
                            key="editable"
                            placeholder={__('Link 5', 'idsk-toolkit')}
                            label={__('Link 5 name', 'idsk-toolkit')}
                            value={urlText5}
                            onChange={value => this.onChange('urlText5', value)} 
                        />
                        <TextControl
                            className="js-search-link-5-href"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('Link 5 URL', 'idsk-toolkit')}
                            value={url5}
                            onChange={value => this.onChange('url5', value)} 
                        />
                    </PanelBody>
                    }
                </InspectorControls>
                
                <div data-module="idsk-intro-block">
                    <div class="idsk-intro-block ">
                        <div class="govuk-grid-row ">
                            <div class="govuk-grid-column-full govuk-grid-column-two-thirds-from-desktop">
                                <RichText
                                    className="govuk-heading-m h2-main"
                                    key="editable"
                                    tagName="h2"
                                    placeholder={__('Main title', 'idsk-toolkit')}
                                    value={title}
                                    onChange={value => this.onChange('title', value)} 
                                />
                                <RichText
                                    className="govuk-body"
                                    key="editable"
                                    tagName="p"
                                    placeholder={__('Subtitle', 'idsk-toolkit')}
                                    value={subTitle}
                                    onChange={value => this.onChange('subTitle', value)} 
                                />
                                {!!withSearch &&
                                <>
                                    <div data-module="idsk-search-component" class="idsk-search-component">
                                        <label class="" for="intro-block-search">{__('Enter search term', 'idsk-toolkit')}</label>
                                        <input class="govuk-input govuk-input--width-30 idsk-search-component__input " id="intro-block-search" name="s" type="text" disabled />
                                        <button type="submit" class="govuk-button idsk-search-component__button ">
                                            {searchIcon}
                                            <span class="govuk-visually-hidden">{__('Search', 'idsk-toolkit')}</span>
                                        </button>
                                    </div>
                                    <div>
                                        <ul class="idsk-intro-block__list__ul">
                                            
                                            <li class="idsk-intro-block__bottom-menu__li govuk-caption-m">
                                                <RichText
                                                    tagName="span"
                                                    placeholder={__('Are you searching for this?', 'idsk-toolkit')}
                                                    value={searchTitle}
                                                    onChange={value => this.onChange('searchTitle', value)} 
                                                />
                                            </li>
                                            {!urlText1 == '' &&
                                            <li class="idsk-intro-block__list__li">
                                                <a class="govuk-link idsk-intro-block__list__a" href={url1}>
                                                    {urlText1}
                                                </a>
                                            </li>
                                            }
                                            {!urlText2 == '' &&
                                            <li class="idsk-intro-block__list__li">
                                                <a class="govuk-link idsk-intro-block__list__a" href={url2}>
                                                    {urlText2}
                                                </a>
                                            </li>
                                            }
                                            {!urlText3 == '' &&
                                            <li class="idsk-intro-block__list__li">
                                                <a class="govuk-link idsk-intro-block__list__a" href={url3}>
                                                    {urlText3}
                                                </a>
                                            </li>
                                            }
                                            {!urlText4 == '' &&
                                            <li class="idsk-intro-block__list__li">
                                                <a class="govuk-link idsk-intro-block__list__a" href={url4}>
                                                    {urlText4}
                                                </a>
                                            </li>
                                            }
                                            {!urlText5 == '' &&
                                            <li class="idsk-intro-block__list__li">
                                                <a class="govuk-link idsk-intro-block__list__a" href={url5}>
                                                    {urlText5}
                                                </a>
                                            </li>
                                            }
                                        </ul>
                                    </div>
                                </>
                                }
                            </div>

                            <div className={"idsk-intro-block__side-menu govuk-grid-column-full govuk-grid-column-one-third-from-desktop " + this.props.attributes.sideStyle}>
                                <RichText
                                    className="govuk-heading-s h2-side"
                                    key="editable"
                                    tagName="h2"
                                    placeholder={__('Sidebar', 'idsk-toolkit')}
                                    value={sideTitle}
                                    onChange={value => this.onChange('sideTitle', value)} 
                                />
                                <RichText
                                    className="idsk-intro-block__side-menu__ul"
                                    key="editable"
                                    tagName="ul"
                                    multiline="li"
                                    placeholder={__('Sidebar links', 'idsk-toolkit')}
                                    value={sideContent}
                                    onChange={value => this.onChange('sideContent', value)} 
                                />
                            </div>

                        </div>
                    </div>
                </div>
            </div>;
        }
    },

    // No save, dynamic block
    save() {
        return null
    },
})