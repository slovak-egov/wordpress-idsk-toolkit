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
    title: __('Timeline', 'idsk-toolkit'),
    description: __('Shows content in chronological order.', 'idsk-toolkit'),
    icon: 'align-right',
    category: 'idsk-components',
    keywords: [
        __('timeline', 'idsk-toolkit'),
        __('time line', 'idsk-toolkit'),
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

            this.addItem = this.addItem.bind(this);
            this.removeItem = this.removeItem.bind(this);
            this.editItem = this.editItem.bind(this);
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
                                                placeholder={__('january 1970', 'idsk-toolkit')}
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
                                                placeholder={__('Heading', 'idsk-toolkit')}
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
                                        placeholder={__('Caption', 'idsk-toolkit')}
                                    />                                    
                                </div>
                                }

                                {!!item.isLastContent &&
                                <>
                                    <p>
                                        <input
                                            className="button-primary button"
                                            type="submit"
                                            value={__('Add caption', 'idsk-toolkit')}
                                            onClick={(e) => this.addItem(e, index)}
                                        />
                                    </p>

                                    <p>
                                        <input
                                            className="button-secondary button"
                                            type="submit"
                                            value={__('Delete caption', 'idsk-toolkit')}
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
                                value={__('Add block to timeline', 'idsk-toolkit')}
                                onClick={(e) => this.addItem(e)}
                            />
                        </p>

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