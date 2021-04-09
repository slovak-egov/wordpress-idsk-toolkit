/**
 * BLOCK - stepper
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

registerBlockType('idsk/stepper', {
    // built-in attributes
    title: __('Stepper', 'idsk-toolkit'),
    description: __('Zobrazuje sled udalostí, procesných úkonov.', 'idsk-toolkit'),
    icon: 'editor-ol',
    category: 'idsk-components',
    keywords: [
        __('stepper', 'idsk-toolkit'),
        __('proces', 'idsk-toolkit'),
        __('kroky', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        title: {
            type: 'string',
            selector: 'h2'
        },
        caption: {
            type: 'string',
            selector: 'idsk-stepper__caption'
        },
        stepperSubtitle: {
            type: 'string',
            selector: 'idsk-stepper__section-subtitle'
        },
        items: {
            type: 'array',
            selector: 'js-stepper-items'
        },
    },
    
    edit: class Stepper extends Component {
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

            // get items from state and their length
            const { items } = this.state
            const length = items.length

            // set up empty item
            const emptyItem = {
                id: nanoid(),
                step: index != null ? index : ( length > 0 ? items[length-1].step+1 : 1 ),
                lastStep: true,
                hasSub: false,
                subStep: index != null ? 'a' : '',
                lastSubStep: false,
                sectionTitle: '',
                sectionHeading: '',
                sectionContent: ''
            }
            
            let newItems

            // add subStep
            if (index != null) {

                // get previous item
                const itemIndex = items[index]
                
                // update previous item attrs
                if (itemIndex.subStep != '') {
                    itemIndex.lastSubStep = false
                } else {
                    itemIndex.hasSub = true
                }
                itemIndex.lastStep = false

                // update new item attrs
                emptyItem.step = itemIndex.step
                emptyItem.lastSubStep = true

                // if added substep is not last in stepper block
                if (index != length-1) {
                    emptyItem.lastStep = false
                }

                // update previous item and insert new item
                newItems = items.slice(0)
                newItems.splice(index, 1, itemIndex)
                newItems.splice(index+1, 0, emptyItem)
    
            } 
            // add step
            else {

                if (length > 0) {
                    // update last item not to be last and append new item
                    const lastIndex = length-1
                    const lastItem = items[lastIndex]
                    lastItem.lastStep = false

                    newItems = items.slice(0)
                    newItems.splice(lastIndex, 1, lastItem)
                    newItems.splice(lastIndex+1, 0, emptyItem)
                } else {
                    // append first item
                    newItems = [...items, emptyItem]
                }

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
            // const { items } = this.state does not work
            const items = JSON.parse(JSON.stringify(this.state.items))

            // helper items around item to be deleted
            const actual = items[index]
            const previous = items[index-1]
            const next = items[index+1]

            // delete only subStep
            if (actual.subStep != '') {
                // last subStep deleted
                if (!!actual.lastSubStep) {
                    if (!previous.hasSub) {
                        previous.lastSubStep = true
                    } 
                    // deleted subStep was only subStep left
                    else if (!next || next.subStep == '') {
                        previous.hasSub = false
                    }
                } 
            } else {
                // delete all subSteps
                if (!!actual.hasSub) {
                    let nextSubIndex = index+1

                    while (!!items[nextSubIndex] && items[nextSubIndex].step == actual.step && items[nextSubIndex].subStep != '') {
                        if (!!items[nextSubIndex].lastStep) {
                            actual.lastStep = true
                        }
                        items.splice(nextSubIndex, 1)
                    }
                }

                // sanitize steps indexes
                if (!!items[index+1]) {
                    let nextIndex = index+1

                    while (!!items[nextIndex]) {
                        const nextItem = items[nextIndex]
                        
                        nextItem.step = nextItem.step-1

                        items.splice(nextIndex, 1, nextItem)
                        nextIndex++
                    }
                }
            }

            // sanitize last step
            if (!!actual.lastStep) {
                if (!!previous) {
                    previous.lastStep = true
                }
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
            const { title, caption, stepperSubtitle, items } = attributes

            return <div className={className}>                
                <RichText
                    className="govuk-heading-l"
                    key="editable"
                    tagName="h2"
                    placeholder={__('Nadpis steppera', 'idsk-toolkit')}
                    value={title}
                    onChange={value => this.onChange('title', value)} 
                />
                <RichText
                    className="idsk-stepper__caption govuk-caption-m"
                    key="editable"
                    tagName="p"
                    placeholder={__('Popis steppera', 'idsk-toolkit')}
                    value={caption}
                    onChange={value => this.onChange('caption', value)} 
                />

                <div class="idsk-stepper myClass" data-module="idsk-stepper" id="default-example" data-attribute="value" >
                    <div class="idsk-stepper__subtitle-container">
                        <div class="idsk-stepper__subtitle--heading govuk-grid-column-three-quarters">
                            <RichText
                                className="govuk-heading-m idsk-stepper__section-subtitle"
                                key="editable"
                                tagName="h3"
                                placeholder={__('Nadpis míľnika', 'idsk-toolkit')}
                                value={stepperSubtitle}
                                onChange={value => this.onChange('stepperSubtitle', value)} 
                            />
                        </div>
                        <div class="idsk-stepper__controls govuk-grid-column-one-quarter">
                        </div>
                    </div>
                    
                    {!!items && items.map((item, index) =>
                        <>
                            {(index != 0 && item.subStep == '' ) &&
                            <div class="idsk-stepper__section-title">
                                <div class="idsk-stepper__section-header idsk-stepper__section-subtitle">
                                    <RichText
                                        className="govuk-heading-m"
                                        value={item.sectionTitle}
                                        onChange={value => this.editItem('sectionTitle', index, value)}
                                        tagName="p"
                                        placeholder={__('Nadpis míľnika', 'idsk-toolkit')}
                                    />
                                </div>
                            </div>
                            }

                            <div key={item.id || index} className={"idsk-stepper__section" + ( !!item.lastStep ? ' idsk-stepper__section--last-item' : '' ) }>
                                
                                <div class="idsk-stepper__section-header">
                                    <span class={"idsk-stepper__circle idsk-stepper__circle--" + ( item.subStep == '' ? 'number' : 'letter' ) }>
                                        <span class="idsk-stepper__circle-inner">
                                            <span class="idsk-stepper__circle-background">
                                                <span class="idsk-stepper__circle-step-label">{ item.subStep == '' ? item.step : item.subStep }</span>
                                            </span>
                                        </span>
                                    </span>
                                    <h4 class="idsk-stepper__section-heading">
                                        <RichText
                                            className="idsk-stepper__section-button"
                                            value={item.sectionHeading}
                                            onChange={value => this.editItem('sectionHeading', index, value)}
                                            tagName="span"
                                            placeholder={__('Nadpis kroku', 'idsk-toolkit')}
                                        />
                                    </h4>
                                </div>
                                
                                <div id="default-example-content-1" class="idsk-stepper__section-content" aria-labelledby="default-example-heading-1">
                                    <RichText
                                        className="govuk-list"
                                        value={item.sectionContent}
                                        onChange={value => this.editItem('sectionContent', index, value)}
                                        tagName="ul"
                                        multiline="li"
                                        placeholder={__('Časť kroku', 'idsk-toolkit')}
                                    />
                                </div>

                                {(!!item.lastSubStep || (item.subStep == '' && !item.hasSub )) &&
                                <p>
                                    <input
                                        className="button-primary button"
                                        type="submit"
                                        value={__('Pridať čiastočný krok', 'idsk-toolkit')}
                                        onClick={(e) => this.addItem(e, index)}
                                    />
                                </p>
                                }
                                
                                <p>
                                    <input
                                        className="button-secondary button"
                                        type="submit"
                                        value={ item.subStep != '' ? 'Vymazať čiastočný krok' : 'Vymazať krok' }
                                        onClick={(e) => this.removeItem(e, index)}
                                    />
                                </p>
                            </div>
                        </>
                    )}

                    <p class="idsk-stepper__item">
                        <input
                            class="idsk-button"
                            data-module="idsk-button"
                            type="submit"
                            value={__('Pridať krok', 'idsk-toolkit')}
                            onClick={(e) => this.addItem(e)}
                        />
                    </p>

                </div>

            </div>;
        }
    },

    // No save, dynamic block
    save() {
        return null
    },
})