/**
 * BLOCK - lists
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
    InspectorControls
} = wp.blockEditor;
const {
    PanelBody,
    RadioControl
} = wp.components;
const { Component } = wp.element
const { __ } = wp.i18n;

registerBlockType('idsk/lists', {
    // built-in attributes
    title: __('Zoznamy', 'idsk-toolkit'),
    description: __('Zobrazuje zoznamy s možnosťami.', 'idsk-toolkit'),
    icon: 'editor-ul',
    category: 'idsk-components',
    keywords: [
        __('zoznam', 'idsk-toolkit'),
        __('zoznamy', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        listType: {
            option: '',
            default: '',
            selector: 'js-lists-type'
        },
        items: {
            type: 'array'
        }
    },

    // The UI for the WordPress editor
    edit: class Lists extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                items: this.props.attributes.items || []
            };

            this.getItems = this.getItems.bind(this);
            this.addItem = this.addItem.bind(this);
            this.removeItem = this.removeItem.bind(this);
            this.editItem = this.editItem.bind(this);
        }

        // Get all sub list items
        getItems(parentItem) {
            const { items } = this.props.attributes
            let parent

            // Get parent item
            !!items && items.map(item =>
                item.id == parentItem && (parent = item)
            )

            const parentListType = parent.listType
            const TagName = parentListType.includes('number') ? 'ol' : 'ul'
            const reversedItems = items.slice(0).reverse()
            let inParents = [parentItem]
            let indent = '\u21FE '

            // Check for parents of parents and set indent text for control settings
            !!reversedItems && reversedItems.map(item => {
                if (inParents.includes(item.id) && item.parent != null) {
                    inParents.push(item.parent)
                    indent += '\u21FE '
                }
            })
            
            return <TagName className={"govuk-list "+parentListType}>
                <InspectorControls>
                    <PanelBody title={indent+__('Nastavenie zoznamu', 'idsk-toolkit')}>
                        <RadioControl
                            label={__('Typ zoznamu', 'idsk-toolkit')}
                            selected={ parentListType }
                            options={ [
                                { 
                                    label: __('Bez odrážok', 'idsk-toolkit'),
                                    value: '' 
                                },
                                { 
                                    label: __('Guličky', 'idsk-toolkit'),
                                    value: 'govuk-list--bullet'
                                },
                                { 
                                    label: __('Čísla', 'idsk-toolkit'),
                                    value: 'govuk-list--number' 
                                },
                            ] }
                            onChange={ ( option ) => this.editItem('listType', parentItem, option) }
                        />
                    </PanelBody>
                </InspectorControls>

                {!!items && items.map((item, index) => 
                    item.parent == parentItem && 
                        <li key={item.id || index}>
                            <RichText
                                key="editable"
                                className="js-lists-item"
                                tagName="span"
                                multiline={false}
                                placeholder={__('Položka', 'idsk-toolkit')}
                                value={item.text}
                                onChange={value => this.editItem('text', item.id, value)}
                            />

                            <p>
                                {!item.hasItems &&
                                    <input
                                        className="button-primary button"
                                        type="submit"
                                        value={__('Vložiť zoznam', 'idsk-toolkit')}
                                        onClick={(e) => this.addItem(e, item.id)}
                                    />
                                }
                                <input
                                    className="button-secondary button"
                                    type="submit"
                                    value={__('Vymazať položku', 'idsk-toolkit')}
                                    onClick={(e) => this.removeItem(e, item.id)}
                                />
                            </p>

                            {!!item.hasItems && this.getItems(item.id)}
                        </li>
                )}

                <p class="idsk-stepper__item">
                    <input
                        class="idsk-button"
                        data-module="idsk-button"
                        type="submit"
                        value={__('Pridať položku', 'idsk-toolkit')}
                        onClick={(e) => this.addItem(e, parentItem)}
                    />
                </p>
            </TagName>
        }

        // adds empty placeholder for item
        addItem(e, parentId=null) {
            e.preventDefault()

            // get items from state
            const { items } = this.state
            const length = items.length
            
            // set up empty item
            const emptyItem = {
                id: nanoid(),
                text: '',
                parent: parentId,
                listType: '',
                hasItems: false
            }

            let newItems

            // add sub list
            if (parentId != null) {
                // update previous item and insert new item
                newItems = items.slice(0)

                let itemIndex
                let helperIndex

                items.map((item, index) => {
                    if (item.id == parentId) {
                        helperIndex = index
                        itemIndex = item
                        itemIndex.hasItems = true
                    }
                })

                newItems.splice(helperIndex, 1, itemIndex)
                newItems.splice(length, 0, emptyItem)
            } 
            else {
                // append new emptyItem object to items
                newItems = [...items, emptyItem]
            }

            // save new placeholder to WordPress
            this.props.setAttributes({ items: newItems })

            // and update state
            return this.setState({ items: newItems })
        }

        // remove item
        removeItem(e, itemId) {
            e.preventDefault()
            
            // make a true copy of items
            const items = JSON.parse(JSON.stringify(this.state.items))
            // const { items } = this.props.attributes
            let newItems = []
            let toDelete = [itemId]
            let index

            // get all IDs of subparents
            items.map((item) => toDelete.includes(item.parent) && item.hasItems && toDelete.push(item.id))

            // set newItems with excluded sublists
            newItems = items.filter(item => !toDelete.includes(item.parent))
            // set index of item to be deleted
            newItems.map((item, subIndex) => toDelete.includes(item.id) && ( index = subIndex ))

            // delete item
            newItems.splice(index, 1)

            // save updated items and update state (in callback)
            return (
                this.props.setAttributes(
                    { items: newItems },
                    this.setState({ items: newItems })
                )
            )
        };

        // handler function to update item
        editItem(key, itemId, value) {
            // make a true copy of items
            const items = JSON.parse(JSON.stringify(this.state.items))
            if (items.length === 0) return

            let helperIndex

            // get index of updated item
            items.map((item, index) => (item.id == itemId) && (helperIndex = index))
            
            // update value
            items[helperIndex][key] = value

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
            const { listType, items } = attributes

            const TagName = listType.includes('number') ? 'ol' : 'ul'

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Nastavenie zoznamu', 'idsk-toolkit')}>
                        <RadioControl
                            className="js-lists-type"
                            label={__('Typ zoznamu', 'idsk-toolkit')}
                            selected={ listType }
                            options={ [
                                { 
                                    label: __('Bez odrážok', 'idsk-toolkit'),
                                    value: '' 
                                },
                                { 
                                    label: __('Guličky', 'idsk-toolkit'),
                                    value: 'govuk-list--bullet'
                                },
                                { 
                                    label: __('Čísla', 'idsk-toolkit'),
                                    value: 'govuk-list--number' 
                                },
                            ] }
                            onChange={ ( option ) => { setAttributes( { listType: option } ) } }
                        />
                    </PanelBody>
                </InspectorControls>

                <TagName className={"govuk-list "+listType}>
                    {!!items && items.map((item, index) => 
                        item.parent == null &&
                            <li key={item.id || index}>
                                <RichText
                                    key="editable"
                                    className="js-lists-item"
                                    tagName="span"
                                    multiline={false}
                                    placeholder={__('Položka', 'idsk-toolkit')}
                                    value={item.text}
                                    onChange={value => this.editItem('text', item.id, value)}
                                />

                                <p>
                                    {!item.hasItems &&
                                        <input
                                            className="button-primary button"
                                            type="submit"
                                            value={__('Vložiť zoznam', 'idsk-toolkit')}
                                            onClick={(e) => this.addItem(e, item.id)}
                                        />
                                    }
                                    <input
                                        className="button-secondary button"
                                        type="submit"
                                        value={__('Vymazať položku', 'idsk-toolkit')}
                                        onClick={(e) => this.removeItem(e, item.id)}
                                    />
                                </p>

                                {!!item.hasItems && this.getItems(item.id)}
                            </li>
                    )}

                    <p>
                        <input
                            class="idsk-button"
                            data-module="idsk-button"
                            type="submit"
                            value={__('Pridať položku', 'idsk-toolkit')}
                            onClick={(e) => this.addItem(e)}
                        />
                    </p>
                </TagName>
            </div>;
        }
    },
    
    // No save, dynamic block
    save() {
        return null
    },
})