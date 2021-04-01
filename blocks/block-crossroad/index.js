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
    Button,
    PanelBody,
    PanelRow,
    ToggleControl
} = wp.components;
const { Component } = wp.element
const { __ } = wp.i18n;

registerBlockType('idsk/crossroad', {
    // built-in attributes
    title: __('Rozcestník', 'idsk'),
    description: __('Rázcestník má formu jednoduchej dlaždice, zloženej z nadpisu, popisku a oddeľovacej čiary. Jeho účelom je prehľadne a jednoducho zoskupiť resp. usporiadať pre používateľa odkazy na súvisiaci obsah, ktorý je rozmiestnený na rôznych, samostatných podstránkach.', 'idsk'),
    icon: 'menu',
    category: 'idsk-components',
    keywords: [
        __('Rozcestník', 'idsk'),
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
                    <button class="idsk-crossroad__colapse--button" type="button">Zobraziť viac</button>
                </div>
            }

            return button;
        };

        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { numberOfCols, hideTiles, items } = attributes

            return (<div data-module="idsk-crossroad" className={className}>
                <div class="govuk-clearfix"></div>
                <InspectorControls>
                    <PanelBody title={__('Nastavenie razcestníka')}>
                        <PanelRow>
                            <ToggleControl
                                className="js-crossroad-two-cols"
                                checked={numberOfCols}
                                label={numberOfCols ? "Dva Stlpce" : "Jeden Stlpec"}
                                onChange={checked => setAttributes({ numberOfCols: checked })}
                            />
                        </PanelRow>
                        <PanelRow>
                            <ToggleControl
                                className="js-crossroad-hide-tiles"
                                checked={hideTiles}
                                label={__('Rozbaliteľný blok', 'idsk')}
                                onChange={checked => setAttributes({ hideTiles: checked })}
                            />
                        </PanelRow>
                    </PanelBody>
                </InspectorControls>
                {/* <div class={numberOfCols ? "idsk-crossroad idsk-crossroad-1" : "idsk-crossroad idsk-crossroad-2"}> */}

                {!!items && items.map((item, index) =>
                    <div key={item.id || index} className="idsk-crossroad__item">
                        <RichText
                            className="idsk-crossroad-title"
                            value={item.title}
                            onChange={value => this.editItem('title', index, value)}
                            tagName="a"
                            placeholder="Titulok"
                        />

                        <RichText
                            className="idsk-crossroad-subtitle"
                            value={item.subtitle}
                            onChange={value => this.editItem('subtitle', index, value)}
                            tagName="p"
                            placeholder="Popis"
                        />

                        <RichText
                            className="idsk-crossroad-link"
                            value={item.link}
                            onChange={value => this.editItem('link', index, value)}
                            tagName="p"
                            placeholder="URL Adresa"
                        />
                        <hr class="idsk-crossroad-line" aria-hidden="true" />

                        <p>
                            <input
                                className="button-secondary button"
                                type="submit"
                                value={__('Vymazať odkaz', 'idsk')}
                                onClick={(e) => this.removeItem(e, index)}
                            />
                        </p>
                    </div>
                )}
                {/* </div> */}
                <p class="idsk-crossroad__item">
                    <input
                        class="idsk-button"
                        data-module="idsk-button"
                        type="submit"
                        value={__('Pridať odkaz', 'idsk')}
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