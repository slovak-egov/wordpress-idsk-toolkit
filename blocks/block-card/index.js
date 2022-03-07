/**
 * BLOCK - card
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

// Used to make item ids
import { nanoid } from 'nanoid'
const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    InspectorControls,
    MediaUpload
} = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    TextControl,
    ToggleControl,
    RadioControl,
    DatePicker
} = wp.components;
const { dateI18n } = wp.date;
const { Component } = wp.element;
const { __ } = wp.i18n;

registerBlockType('idsk/card', {
    // built-in attributes
    title: __('Card', 'idsk-toolkit'),
    description: __('Shows card on the page. Various types of displays available.', 'idsk-toolkit'),
    icon: 'id',
    category: 'idsk-components',
    keywords: [
        __('card', 'idsk-toolkit'),
        __('profile', 'idsk-toolkit'),
        __('hero', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        cardType: {
            option: '',
            default: 'basic',
            selector: 'js-card-type'
        },

        img: {
            type: 'string'
        },

        imgAlt: {
            type: 'string',
            selector: 'js-img-alt'
        },
        imgLink: {
            type: 'string',
            selector: 'js-img-link'
        },

        title: {
            type: 'string',
            selector: 'idsk-heading'
        },
        subTitle: {
            type: 'string',
            selector: 'idsk-body'
        },
        profileQuote: {
            type: 'string',
            selector: 'idsk-quote'
        },

        dateVisible: {
            type: 'boolean',
            selector: 'js-date-visible',
            default: false
        },
        date: {
            type: 'string',
            selector: 'js-date-picker'
        },
        dateLink: {
            type: 'string',
            selector: 'js-date-link'
        },
        tags: {
            type: 'array',
            default: []
        }
    },
    
    edit: class Card extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                cardType: this.props.attributes.cardType,
                tags: this.props.attributes.tags || []
            };

            this.onChange = this.onChange.bind(this)
            this.selectImage = this.selectImage.bind(this)
            this.addItem = this.addItem.bind(this)
            this.removeItem = this.removeItem.bind(this)
            this.editItem = this.editItem.bind(this)
        }

        onChange(attribute, value) {
            return (
                this.props.setAttributes(
                    { [attribute]: value }
                )
            )
        }
        
        selectImage(value) {
            return (
                this.props.setAttributes({
                    img: value.sizes.full.url,
                })
            )
        }

        // adds empty placeholder for item
        addItem(e) {
            e.preventDefault()

            // get items from state
            const { tags } = this.state

            // set up empty item
            const emptyItem = {
                id: nanoid(),
                text: '',
                url: ''
            }

            // append new emptyItem object to tags
            const newTags = [...tags, emptyItem]

            // save new placeholder to WordPress
            this.props.setAttributes({ tags: newTags })

            // and update state
            return this.setState({ tags: newTags })
        }

        // remove item
        removeItem(e, index) {
            e.preventDefault()

            // make a true copy of tags
            const tags = JSON.parse(JSON.stringify(this.state.tags))

            // remove specified item
            tags.splice(index, 1)

            // save updated tags and update state (in callback)
            return (
                this.props.setAttributes(
                    { tags: tags },
                    this.setState({ tags: tags })
                )
            )
        }

        // handler function to update item
        editItem(key, index, value) {
            // make a true copy of tags
            const tags = JSON.parse(JSON.stringify(this.state.tags))
            if (tags.length === 0) return

            // update value
            tags[index][key] = value

            // save values in WordPress and update state (in callback)
            return (
                this.props.setAttributes(
                    { tags: tags },
                    this.setState({ tags: tags })
                )
            )
        }
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { title, subTitle, imgLink, imgAlt, profileQuote, cardType, dateVisible, date, dateLink, tags } = attributes

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Card display', 'idsk-toolkit')}>
                        <PanelRow>
                            <RadioControl
                                className="js-card-type"
                                label={__('Card view style', 'idsk-toolkit')}
                                selected={ cardType }
                                options={ [
                                    { 
                                        label: __('Basic card', 'idsk-toolkit'),
                                        value: 'basic' 
                                    },
                                    { 
                                        label: __('Secondary card', 'idsk-toolkit'),
                                        value: 'secondary' 
                                    },
                                    { 
                                        label: __('Secondary card - horizontal', 'idsk-toolkit'),
                                        value: 'secondary-horizontal' 
                                    },
                                    { 
                                        label: __('Simple card', 'idsk-toolkit'),
                                        value: 'simple' 
                                    },
                                    { 
                                        label: __('Hero card', 'idsk-toolkit'),
                                        value: 'hero' 
                                    },
                                    { 
                                        label: __('Basic card - no image', 'idsk-toolkit'),
                                        value: 'basic-variant' 
                                    },
                                    { 
                                        label: __('Profile card - vertical', 'idsk-toolkit'),
                                        value: 'profile-vertical' 
                                    },
                                    { 
                                        label: __('Profile card - horizontal', 'idsk-toolkit'),
                                        value: 'profile-horizontal' 
                                    },
                                ] }
                                onChange={ ( option ) => { setAttributes( { cardType: option } ) } }
                            />
                        </PanelRow>
                    </PanelBody>

                    {(cardType != 'basic-variant') &&
                    <PanelBody title={__('Image attributes', 'idsk-toolkit')}>
                        <TextControl
                            className="js-img-alt"
                            key="editable"
                            placeholder={__('Image name', 'idsk-toolkit')}
                            label={__('Image alternative name', 'idsk-toolkit')}
                            value={imgAlt}
                            onChange={value => this.onChange('imgAlt', value)} 
                        />
                        <TextControl
                            className="js-img-link"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('Redirect link after clicking on image', 'idsk-toolkit')}
                            value={imgLink}
                            onChange={value => this.onChange('imgLink', value)} 
                        />
                    </PanelBody>
                    }

                    {(cardType != 'profile-vertical' && cardType != 'profile-horizontal') &&
                    <>
                    <PanelBody title={__('Date', 'idsk-toolkit')}>
                        <PanelRow>
                            <ToggleControl
                                className="js-date-visible"
                                checked={dateVisible}
                                label={__('Display date', 'idsk-toolkit')}
                                help={dateVisible ? __('Displayed', 'idsk-toolkit') : __('Hidden', 'idsk-toolkit')}
                                onChange={checked => setAttributes({ dateVisible: checked })}
                            />
                        </PanelRow>
                        {!!dateVisible &&
                        <>
                            <DatePicker
                                className="js-date-picker"
                                currentDate={ date }
                                onChange={ (date) => this.onChange('date', date)} 
                            />
                            <TextControl
                                className="js-date-link"
                                key="editable"
                                placeholder={__('https://www.google.com', 'idsk-toolkit')}
                                label={__('Date link', 'idsk-toolkit')}
                                value={dateLink}
                                onChange={value => this.onChange('dateLink', value)} 
                            />
                        </>
                        }
                    </PanelBody>
                    
                    <PanelBody title={__('Tags', 'idsk-toolkit')}>
                        {!!tags && tags.map((item, index) =>
                            <>
                                <h2>{__('Tag', 'idsk-toolkit')} {index+1}</h2>
                                <div key={item.id || index}>
                                    <TextControl
                                        key="editable"
                                        label={__('Tag name', 'idsk-toolkit')}
                                        value={item.text}
                                        onChange={value => this.editItem('text', index, value)} 
                                    />
                                    <TextControl
                                        key="editable"
                                        label={__('Tag URL', 'idsk-toolkit')}
                                        placeholder={__('https://www.google.com', 'idsk-toolkit')}
                                        value={item.url}
                                        onChange={value => this.editItem('url', index, value)} 
                                    />
                                </div>
                                <input
                                    className="button-secondary button"
                                    type="submit"
                                    value={__('Delete tag', 'idsk-toolkit')}
                                    onClick={(e) => this.removeItem(e, index)}
                                />
                                <div class="govuk-clearfix"></div>
                            </>
                        )}
                        <br/>
                        <input
                            className="button-primary button"
                            type="submit"
                            value={__('Add tag', 'idsk-toolkit')}
                            onClick={(e) => this.addItem(e)}
                        />
                    </PanelBody>
                    </>
                    }
                </InspectorControls>
                
                <div class={"idsk-card idsk-card-" + cardType}>
                    
                    {(cardType != 'basic-variant') &&
                    <MediaUpload 
                        class={"idsk-card-img idsk-card-img-" + cardType}
                        onSelect={this.selectImage}
                        render={ ({open}) => {
                            return <>
                                {!!attributes.img ? (
                                    <img 
                                    alt={imgAlt}
                                    src={attributes.img}
                                    class={"idsk-card-img idsk-card-img-" + cardType}
                                    onClick={open}
                                    />
                                ) : (
                                    <button class="imgUpload" onClick={open}>{__('Upload image', 'idsk-toolkit')}</button>
                                )}
                                </>;
                        }}
                    />
                    }

                    <div class={"idsk-card-content idsk-card-content-" + cardType}>

                        <div class="meta-handler-top">
                            {(cardType != 'profile-vertical' && cardType != 'profile-horizontal' && cardType != 'basic-variant') &&
                            <div class="idsk-card-meta-container">
                                {(!!dateVisible && !!date) &&
                                <span class="idsk-card-meta idsk-card-meta-date">
                                    <a href={dateLink} class="govuk-link">{dateI18n('d.m.Y', date)}</a>
                                </span> 
                                }
                                {!!tags && tags.map((item, index) =>
                                <span key={item.id || index} class="idsk-card-meta idsk-card-meta-tag">
                                    <a href={item.url} class="govuk-link">{item.text}</a>
                                </span>
                                )}
                            </div>
                            }
                        </div>

                        <RichText
                            className={"idsk-heading idsk-heading-" + cardType}
                            key="editable"
                            tagName="div"
                            placeholder={__('Main title', 'idsk-toolkit')}
                            value={title}
                            onChange={value => this.onChange('title', value)} 
                        />

                        {(cardType != 'simple') &&
                        <RichText
                            className={"idsk-body idsk-body-" + cardType}
                            key="editable"
                            tagName="p"
                            placeholder={__('Caption', 'idsk-toolkit')}
                            value={subTitle}
                            onChange={value => this.onChange('subTitle', value)} 
                        />
                        }

                        {(cardType == 'profile-horizontal') &&
                        <>
                            <div aria-hidden="true">
                                <svg width="24" height="19" viewBox="0 0 29 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M26.3553 0.0139084C23.5864 0.226497 19.9201 2.88 17.0759 7.02567C15.053 9.97412 12.8391 14.6653 12.8391 18.4203C12.8391 21.3658 15.151 23.7536 18.0028 23.7536C20.8546 23.7536 23.1665 21.3658 23.1665 18.4203C23.1665 15.9126 21.4908 13.8092 19.233 13.2392C19.7995 11.258 20.8141 9.10337 22.2396 7.02567C24.1378 4.25885 26.4022 2.15668 28.5216 1.00119L26.3553 0.0139084Z" fill="#003078"/>
                                    <path d="M4.23679 7.02557C7.22761 2.66622 11.1274 -0.0431738 13.937 0.000520662L15.8902 0.890673C13.7117 2.01967 11.3608 4.16818 9.40047 7.02557C7.97502 9.10327 6.96037 11.2579 6.39387 13.2391C8.65175 13.8091 10.3274 15.9125 10.3274 18.4202C10.3274 21.3657 8.0155 23.7535 5.16368 23.7535C2.31186 23.7535 0 21.3657 0 18.4202C0 14.6652 2.21394 9.97402 4.23679 7.02557Z" fill="#003078"/>
                                    
                                    <image src="/assets/images/quote-left.png" width="29" height="25"></image>
                                </svg>
                            </div>
                            <RichText
                                className="idsk-quote"
                                key="editable"
                                tagName="div"
                                placeholder={__('Citation', 'idsk-toolkit')}
                                value={profileQuote}
                                onChange={value => this.onChange('profileQuote', value)} 
                            />
                            <div class="idsk-quote-right" aria-hidden="true">
                                <svg width="24" height="20" viewBox="0 0 29 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.1662 24.4934C4.93513 24.2808 8.60138 21.6273 11.4456 17.4817C13.4684 14.5332 15.6824 9.84205 15.6824 6.08707C15.6824 3.14154 13.3705 0.753727 10.5187 0.753727C7.66689 0.753727 5.35503 3.14154 5.35503 6.08707C5.35503 8.59472 7.03065 10.6982 9.28852 11.2681C8.72202 13.2493 7.70737 15.404 6.28192 17.4817C4.38369 20.2485 2.1193 22.3506 -0.000114441 23.5061L2.1662 24.4934Z" fill="#003078"/>
                                    <path d="M24.2847 17.4818C21.2939 21.8411 17.3941 24.5505 14.5845 24.5068L12.6313 23.6167C14.8098 22.4877 17.1606 20.3391 19.121 17.4818C20.5465 15.4041 21.5611 13.2494 22.1276 11.2682C19.8697 10.6983 18.1941 8.59482 18.1941 6.08716C18.1941 3.14164 20.506 0.753824 23.3578 0.753824C26.2096 0.753824 28.5215 3.14164 28.5215 6.08716C28.5215 9.84214 26.3075 14.5333 24.2847 17.4818Z" fill="#003078"/>
                                    
                                    <image src="/assets/images/quote-right.png" width="29" height="25"></image>
                                </svg>
                            </div>
                        </>
                        }
                        
                        <div class="meta-handler-bottom">
                            {(cardType == 'basic-variant') &&
                            <div class="idsk-card-meta-container">
                                {(!!dateVisible && !!date) &&
                                <span class="idsk-card-meta idsk-card-meta-date">
                                    <a href={dateLink} class="govuk-link">{dateI18n('d.m.Y', date)}</a>
                                </span> 
                                }
                                {!!tags && tags.map((item, index) =>
                                <span key={item.id || index} class="idsk-card-meta idsk-card-meta-tag">
                                    <a href={item.url} class="govuk-link">{item.text}</a>
                                </span>
                                )}
                            </div>
                            }
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