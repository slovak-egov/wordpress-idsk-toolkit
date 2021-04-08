/**
 * BLOCK - timeline
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

// Used to make item ids
import { nanoid } from 'nanoid';
const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const { RichText } = wp.blockEditor;
const { Component } = wp.element;
const { __ } = wp.i18n;

registerBlockType('idsk/timeline', {
    // built-in attributes
    title: __('Časová os - timeline', 'idsk-toolkit'),
    description: __('Zobrazuje chronologicky usporiadaný obsah.', 'idsk-toolkit'),
    icon: 'align-right',
    category: 'idsk-components',
    keywords: [
        __('timeline', 'idsk-toolkit'),
        __('časová os', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        items: {
            type: 'array'
        }
    },
    
    edit: class Timeline extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                items: this.props.attributes.items || []
            };

            this.onChange = this.onChange.bind(this);
            this.addItem = this.addItem.bind(this);
            this.removeItem = this.removeItem.bind(this);
            this.editItem = this.editItem.bind(this);
        }

        onChange(attribute, value) {
            return (
                this.props.setAttributes(
                    { [attribute]: value }
                )
            )
        }

        // adds empty placeholder for item
        addItem(e, index=null) {
            e.preventDefault()

            // get items from state
            const { items } = this.state

            // set up empty item
            const emptyItem = {
                id: nanoid(),
                dateText: '',
                heading: '',
                isHeading: index != null ? false : true,
                date: '',
                time: '',
                content: '',
                isLastContent: true
            }
            
            let newItems

            if (index != null) {
                // sanitize last content

                // get previous item
                const itemIndex = items[index]
                
                // update previous item attrs
                if (!!itemIndex.isLastContent) {
                    itemIndex.isLastContent = false
                }

                // update previous item and insert new item
                newItems = items.slice(0)
                newItems.splice(index, 1, itemIndex)
                newItems.splice(index+1, 0, emptyItem)
            } else {
                // append new emptyItem object to items
                newItems = [...items, emptyItem]
            }

            // save new placeholder to WordPress
            this.props.setAttributes({ items: newItems })

            // and update state
            return this.setState({ items: newItems })
        }

        // remove item
        removeItem(e, index) {
            e.preventDefault()

            // make a true copy of items
            const items = JSON.parse(JSON.stringify(this.state.items))

            // set previous to be last
            const previous = items[index-1]

            if (!!previous) {
                previous.isLastContent = true
            }

            // remove specified item
            items.splice(index, 1)

            // save updated items and update state (in callback)
            return (
                this.props.setAttributes(
                    { items: items },
                    this.setState({ items: items })
                )
            )
        };

        // handler function to update item
        editItem(key, index, value) {
            // make a true copy of items
            const items = JSON.parse(JSON.stringify(this.state.items))
            if (items.length === 0) return

            // update value
            items[index][key] = value

            // save values in WordPress and update state (in callback)
            return (
                this.props.setAttributes(
                    { items: items },
                    this.setState({ items: items })
                )
            )
        };
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { items } = attributes

            return <div className={className}>
                <div class="idsk-timeline " data-module="idsk-timeline" role="contentinfo">
                    <div class="govuk-container-width">

                        <div class="idsk-timeline__button__div">
                            <button type="button" class="idsk-timeline__button--back">
                                <svg class="idsk-timeline__button__svg--previous" width="20" height="15" viewbox="0 -2 25 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.2925 13.8005C7.6825 13.4105 7.6825 12.7805 7.2925 12.3905L3.4225 8.50047H18.5925C19.1425 8.50047 19.5925 8.05047 19.5925 7.50047C19.5925 6.95047 19.1425 6.50047 18.5925 6.50047H3.4225L7.3025 2.62047C7.6925 2.23047 7.6925 1.60047 7.3025 1.21047C6.9125 0.820469 6.2825 0.820469 5.8925 1.21047L0.2925 6.80047C-0.0975 7.19047 -0.0975 7.82047 0.2925 8.21047L5.8825 13.8005C6.2725 14.1805 6.9125 14.1805 7.2925 13.8005Z" fill="#0065B3"/>
                                </svg>
                                {__('Zobraziť minulé udalosti', 'idsk-toolkit')}
                            </button>
                        </div>

                        {!!items && items.map((item, index) =>
                            <>
                                {!!item.isHeading &&
                                <>
                                    <div class="idsk-timeline__content govuk-body">
                                        <div class="idsk-timeline__left-side"></div>
                                        <div class="idsk-timeline__middle">
                                            <span class="idsk-timeline__vertical-line"></span>
                                        </div>
                                        <div class="idsk-timeline__content__date-line">
                                            <RichText
                                                className="idsk-timeline__content__text"
                                                value={item.dateText}
                                                onChange={value => this.editItem('dateText', index, value)}
                                                tagName="span"
                                                placeholder={__('január 1970', 'idsk-toolkit')}
                                            />
                                        </div>
                                    </div>

                                    <div class="idsk-timeline__content idsk-timeline__content__title-div">
                                        <div class="idsk-timeline__left-side"></div>
                                        <div class="idsk-timeline__middle">
                                            <span class="idsk-timeline__vertical-line"></span>
                                        </div>
                                        <div class="idsk-timeline__content__title">
                                            <RichText
                                                className="govuk-heading-m"
                                                value={item.heading}
                                                onChange={value => this.editItem('heading', index, value)}
                                                tagName="h3"
                                                placeholder={__('Nadpis', 'idsk-toolkit')}
                                            />
                                        </div>
                                    </div>
                                </>
                                }

                                {!item.isHeading &&
                                <div key={item.id || index} class="idsk-timeline__content idsk-timeline__content__caption--long">
                                    <div class="idsk-timeline__left-side">
                                        <RichText
                                            className="govuk-body-m"
                                            value={item.date}
                                            onChange={value => this.editItem('date', index, value)}
                                            tagName="span"
                                            placeholder={__('01.01.1970', 'idsk-toolkit')}
                                        />
                                        <br />
                                        <RichText
                                            className="idsk-timeline__content__time"
                                            value={item.time}
                                            onChange={value => this.editItem('time', index, value)}
                                            tagName="span"
                                            placeholder={__('8:30 - 12:00', 'idsk-toolkit')}
                                        />
                                    </div>
                                    <div class="idsk-timeline__middle">
                                        <span class="idsk-timeline__vertical-line--circle"></span>
                                    </div>
                                    <RichText
                                        className="idsk-timeline__content__caption"
                                        value={item.content}
                                        onChange={value => this.editItem('content', index, value)}
                                        tagName="span"
                                        placeholder={__('Popis', 'idsk-toolkit')}
                                    />                                    
                                </div>
                                }

                                {!!item.isLastContent &&
                                <>
                                    <p>
                                        <input
                                            className="button-primary button"
                                            type="submit"
                                            value={__('Pridať popis', 'idsk-toolkit')}
                                            onClick={(e) => this.addItem(e, index)}
                                        />
                                    </p>

                                    <p>
                                        <input
                                            className="button-secondary button"
                                            type="submit"
                                            value={__('Vymazať popis', 'idsk-toolkit')}
                                            onClick={(e) => this.removeItem(e, index)}
                                        />
                                    </p>
                                </>
                                }
                            </>
                        )}

                        <p class="idsk-stepper__item">
                            <input
                                class="idsk-button"
                                data-module="idsk-button"
                                type="submit"
                                value={__('Pridať blok časovej osi', 'idsk-toolkit')}
                                onClick={(e) => this.addItem(e)}
                            />
                        </p>

                        <button type="button" class="idsk-timeline__button--forward">
                            {__('Zobraziť budúce udalosti', 'idsk-toolkit')}
                            <svg class="idsk-timeline__button__svg--next" width="20" height="13" viewbox="-5 0 25 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5558 0.281376C12.1577 0.666414 12.1577 1.2884 12.5558 1.67344L16.5063 5.51395L1.0208 5.51395C0.45936 5.51395 1.90735e-06 5.95823 1.90735e-06 6.50123C1.90735e-06 7.04424 0.45936 7.48851 1.0208 7.48851L16.5063 7.48851L12.5456 11.3192C12.1475 11.7042 12.1475 12.3262 12.5456 12.7112C12.9437 13.0963 13.5868 13.0963 13.9849 12.7112L19.7014 7.19233C20.0995 6.80729 20.0995 6.1853 19.7014 5.80027L13.9952 0.281376C13.597 -0.0937901 12.9437 -0.0937901 12.5558 0.281376Z" fill="#0065B3"/>
                            </svg>
                        </button>

                    </div>
                </div>
                <div class="govuk-clearfix"></div>
            </div>
        }
    },

    // No save, dynamic block
    save() {
        return null
    },
})