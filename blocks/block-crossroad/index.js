/**
 * BLOCK - crossroad
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

// Used to make item ids
import { nanoid } from 'nanoid';
const { registerBlockType } = wp.blocks;
const {
    RichText,
    InspectorControls
} = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    ToggleControl
} = wp.components;
const { Component } = wp.element
const { __ } = wp.i18n;

registerBlockType('idsk/crossroad', {
    // built-in attributes
    title: __('Crossroad', 'idsk-toolkit'),
    description: __('The crossroad takes the form of a simple tile, consisting of a heading, caption and a separating line. Its purpose is to clearly and easily group or organise links for the user to related content that is located on different, separate subpages.', 'idsk-toolkit'),
    icon: 'menu',
    category: 'idsk-components',
    keywords: [
        __('crossroad', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        numberOfCols: {
            type: 'boolean',
            selector: 'js-crossroad-two-cols'
        },
        hideTiles: {
            type: 'boolean',
            selector: 'js-crossroad-hide-tiles'
        },
        items: {
            type: 'array',
            selector: 'js-crossroad-items'
        },
    },

    // The UI for the WordPress editor
    edit: class Crossroad extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                items: this.props.attributes.items || []
            };

            this.addItem = this.addItem.bind(this);
            this.removeItem = this.removeItem.bind(this);
            this.editItem = this.editItem.bind(this);
            this.showColsInputs = this.showColsInputs.bind(this);
            this.showCols = this.showCols.bind(this);
        }

        // adds empty placeholder for item
        addItem(e) {
            e.preventDefault()

            // get items from state
            const { items } = this.state

            // set up empty item
            const emptyItem = {
                id: nanoid(),
                title: '',
                subtitle: '',
                link: ''
            }

            // append new emptyItem object to items
            const newItems = [...items, emptyItem]

            // save new placeholder to WordPress
            this.props.setAttributes({ items: newItems })

            // and update state
            return this.setState({ items: newItems })
        }

        // remove item
        removeItem(e, index) {
            e.preventDefault()

            // make a true copy of items
            // const { items } = this.state does not work
            const items = JSON.parse(JSON.stringify(this.state.items))

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

        collapsableButton() {
            let button = '';

            if (this.props.attributes.hideTiles) {
                button = <div class="govuk-grid-column-full idsk-crossroad__collapse--shadow idsk-crossroad__uncollapse-div">
                    <button class="idsk-crossroad__colapse--button" type="button">{__('Show more', 'idsk-toolkit')}</button>
                </div>
            }

            return button;
        };

        showColsInputs(items, startIndex, endIndex) {
            const returnItems = items.map((item, index) => (
                (index >= startIndex && index < endIndex) &&
                    <div key={item.id || i-1} className="idsk-crossroad__item">
                        <RichText
                            className="idsk-crossroad-title"
                            value={item.title}
                            onChange={value => this.editItem('title', index, value)}
                            tagName="a"
                            placeholder={__('Title', 'idsk-toolkit')}
                        />

                        <RichText
                            className="idsk-crossroad-subtitle"
                            value={item.subtitle}
                            onChange={value => this.editItem('subtitle', index, value)}
                            tagName="p"
                            placeholder={__('Caption', 'idsk-toolkit')}
                        />

                        <RichText
                            className="idsk-crossroad-link"
                            value={item.link}
                            onChange={value => this.editItem('link', index, value)}
                            tagName="p"
                            placeholder={__('URL Address', 'idsk-toolkit')}
                        />
                        <hr class="idsk-crossroad-line" aria-hidden="true" />

                        <p>
                            <input
                                className="button-secondary button"
                                type="submit"
                                value={__('Delete link', 'idsk-toolkit')}
                                onClick={(e) => this.removeItem(e, index)}
                            />
                        </p>
                    </div>
            ))

            return returnItems
        }

        showCols(items) {
            // Show grid
            if ( this.props.attributes.numberOfCols ) {
                return <>
                    <div class="idsk-crossroad idsk-crossroad-2">
                        {this.showColsInputs(items, 0, Math.ceil(items.length/2))}
                    </div>
                    <div class="idsk-crossroad idsk-crossroad-2">
                        {items.length > 1 && this.showColsInputs(items, Math.ceil(items.length/2), items.length)}
                    </div>
                </>
            }
            else {
                return <div class="idsk-crossroad idsk-crossroad-1">
                    {this.showColsInputs(items, 0, items.length)}
                </div>
            }
        }

        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { numberOfCols, hideTiles, items } = attributes

            return (<div data-module="idsk-crossroad" className={className}>
                <InspectorControls>
                    <PanelBody title={__('Crossroad settings', 'idsk-toolkit')}>
                        <PanelRow>
                            <ToggleControl
                                className="js-crossroad-two-cols"
                                checked={numberOfCols}
                                label={numberOfCols ? __('Two columns', 'idsk-toolkit') : __('One column', 'idsk-toolkit')}
                                onChange={checked => setAttributes({ numberOfCols: checked })}
                            />
                        </PanelRow>
                        <PanelRow>
                            <ToggleControl
                                className="js-crossroad-hide-tiles"
                                checked={hideTiles}
                                label={__('Expandable block', 'idsk-toolkit')}
                                onChange={checked => setAttributes({ hideTiles: checked })}
                            />
                        </PanelRow>
                    </PanelBody>
                </InspectorControls>

                {!!items && this.showCols(items)}

                <div class="govuk-clearfix"></div>
                
                <p class="idsk-crossroad__item">
                    <input
                        class="idsk-button"
                        data-module="idsk-button"
                        type="submit"
                        value={__('Add link', 'idsk-toolkit')}
                        onClick={(e) => this.addItem(e)}
                    />
                </p>
                {this.collapsableButton()}
            </div>
            )
        }
    },

    // No save, dynamic block
    save: props => {
        return null
    }
})