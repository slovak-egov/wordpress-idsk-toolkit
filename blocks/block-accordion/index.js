/**
 * BLOCK - accordion
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

registerBlockType('idsk/accordion', {
    // built-in attributes
    title: __('Akordeón', 'idsk-toolkit'),
    description: __('Zobrazuje skladací blok.', 'idsk-toolkit'),
    icon: 'image-flip-vertical',
    category: 'idsk-components',
    keywords: [
        __('accordion', 'idsk-toolkit'),
        __('akordeón', 'idsk-toolkit'),
        __('blok', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        blockId: {
            type: 'string'
        },
        items: {
            type: 'array'
        },
    },

    // The UI for the WordPress editor
    edit: class Accordion extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                items: this.props.attributes.items || [],
            };

            this.addItem = this.addItem.bind(this);
            this.removeItem = this.removeItem.bind(this);
            this.editItem = this.editItem.bind(this);
        }

        // adds empty placeholder for item
        addItem(e) {
            e.preventDefault()

            // get items from state and their length
            const { items } = this.state

            // set up empty item
            const emptyItem = {
                id: nanoid(),
                open: false,
                title: '',
                summary: '',
                content: ''
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
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { blockId, items } = attributes

            if (!blockId) {
                this.props.setAttributes( { blockId: nanoid() } )
            }

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Nastavenia akordeónu', 'idsk-toolkit')}>
                        {!!items && items.map((item, index) => 
                            <PanelRow>
                                <ToggleControl
                                    checked={item.open}
                                    label={__('Akordeón', 'idsk-toolkit') + ' ' + (index+1)}
                                    help={item.open ? __('Rozbalený', 'idsk-toolkit') : __('Zbalený', 'idsk-toolkit')}
                                    onChange={checked => this.editItem('open', index, checked)}
                                />
                            </PanelRow>
                        )}
                    </PanelBody>
                </InspectorControls>
                <div class="govuk-accordion" data-module="idsk-accordion" id="with-descriptions">
                    <div class="govuk-accordion__controls">
                        <button class="govuk-accordion__open-all" data-open-title={__('Otvoriť všetky', 'idsk-toolkit')} data-close-title={__('Zatvoriť všetky', 'idsk-toolkit')} type="button" aria-expanded="false">
                            {__('Zatvoriť všetky', 'idsk-toolkit')}
                            <span class="govuk-visually-hidden govuk-accordion__controls-span" data-section-title={__('sekcie', 'idsk-toolkit')}></span>
                        </button>
                    </div>

                    {!!items && items.map((item, index) =>
                        <>
                            <div key={item.id || index} class="govuk-accordion__section govuk-accordion__section--expanded">
                                <div class="govuk-accordion__section-header">
                                    <h2 class="govuk-accordion__section-heading">
                                        <RichText
                                            className="govuk-accordion__section-button"
                                            key="editable"
                                            tagName="span"
                                            placeholder={__('Nadpis sekcie', 'idsk-toolkit')}
                                            value={item.title}
                                            onChange={value => this.editItem('title', index, value)} />
                                        <span class="govuk-accordion__icon" aria-hidden="true"></span>
                                    </h2>
                                    <RichText
                                        className="govuk-accordion__section-summary govuk-body"
                                        key="editable"
                                        tagName="div"
                                        placeholder={__('Popis sekcie', 'idsk-toolkit')}
                                        value={item.summary}
                                        onChange={value => this.editItem('summary', index, value)} />
                                </div>
                                <div class="govuk-accordion__section-content">
                                    <RichText
                                        className="govuk-body section-content"
                                        key="editable"
                                        tagName="p"
                                        placeholder={__('Obsah sekcie', 'idsk-toolkit')}
                                        value={item.content}
                                        onChange={value => this.editItem('content', index, value)} />
                                </div>
                            </div>

                            <button
                                className="button-secondary button"
                                type="submit"
                                onClick={(e) => this.removeItem(e, index)}
                            >{__('Vymazať akordeón', 'idsk-toolkit')}</button>
                        </>
                    )}

                    <br/>
                    <button
                        className="button-primary button"
                        type="submit"
                        onClick={(e) => this.addItem(e)}
                    >{__('Pridať akordeón', 'idsk-toolkit')}</button>

                </div>
            </div>;
        }
    },

    // No save, dynamic block
    save() {
        return null
    },
})