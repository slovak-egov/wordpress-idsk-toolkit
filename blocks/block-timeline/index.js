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
const {
    PanelBody,
    PanelRow,
    TextControl,
    RadioControl,
    DatePicker,
    Popover,
    Button
} = wp.components;
const { dateI18n } = wp.date;
const { Component, useState } = wp.element;
const { __ } = wp.i18n;
const classes = 'block-editor-rich-text__editable rich-text'; // default gutenberg <RichText> classes for displaying placeholders 

registerBlockType('idsk/timeline', {
    // built-in attributes
    title: __('Časová os - timeline', 'idsk'),
    description: __('Zobrazuje chronologicky usporiadaný obsah.', 'idsk'),
    icon: 'align-right',
    category: 'idsk-components',
    keywords: [
        __('timeline', 'idsk'),
        __('časová os', 'idsk'),
    ],

    // custom attributes
    attributes: {
        
        date: {
            type: 'string',
            selector: 'js-date-picker'
        },

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
    
    edit: class Intro extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                items: this.props.attributes.items || []
            };

            this.onChange = this.onChange.bind(this);
            this.nextCharacter = this.nextCharacter.bind(this);
            this.previousCharacter = this.previousCharacter.bind(this);
            this.addItem = this.addItem.bind(this);
            this.removeItem = this.removeItem.bind(this);
            this.editItem = this.editItem.bind(this);

            this.dateButton = this.dateButton.bind(this);
        }

        onChange(attribute, value) {
            return (
                this.props.setAttributes(
                    { [attribute]: value }
                )
            )
        }
        
        nextCharacter(c) { 
            return String.fromCharCode(c.charCodeAt(0) + 1); 
        } 
        
        previousCharacter(c) { 
            return String.fromCharCode(c.charCodeAt(0) - 1); 
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
                step: !!index ? index : ( length > 0 ? items[length-1].step+1 : 1 ),
                lastStep: true,
                hasSub: false,
                subStep: !!index ? 'a' : '',
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

        dateButton() {
            const [openDatePopup, setOpenDatePopup] = useState( false );
            return <>
                <Button isLink={true} onClick={() => setOpenDatePopup( ! openDatePopup )}>
                    { date ? dateI18n( 'F j, Y g:i a', date ) : "Pick Date & Time" }
                </Button>
                { openDatePopup && (
                    <Popover onClose={ setOpenDatePopup.bind( null, false )}>
                        <DatePicker
                            class={classes + " js-date-picker"}
                            currentDate={ date }
                            onChange={ (date) => this.onChange('date', date)} 
                        />
                    </Popover>
                ) }
            </>
            // return <div>halo</div>
        }
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { date, title, caption, stepperSubtitle, items } = attributes

            return <div className={className}>                
                <RichText
                    class={classes + " govuk-heading-l"}
                    key="editable"
                    tagName="h2"
                    placeholder={__('Nadpis steppera', 'idsk')}
                    value={title}
                    onChange={value => this.onChange('title', value)} 
                />
                <RichText
                    class={classes + " idsk-stepper__caption govuk-caption-m"}
                    key="editable"
                    tagName="p"
                    placeholder={__('Popis steppera', 'idsk')}
                    value={caption}
                    onChange={value => this.onChange('caption', value)} 
                />

                
                <div class="idsk-timeline " data-module="idsk-timeline" role="contentinfo">
                    <div class="govuk-container-width">

                        <div class="idsk-timeline__button__div">
                            <button type="button" class="idsk-timeline__button--back">
                                <svg class="idsk-timeline__button__svg--previous" width="20" height="15" viewbox="0 -2 25 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.2925 13.8005C7.6825 13.4105 7.6825 12.7805 7.2925 12.3905L3.4225 8.50047H18.5925C19.1425 8.50047 19.5925 8.05047 19.5925 7.50047C19.5925 6.95047 19.1425 6.50047 18.5925 6.50047H3.4225L7.3025 2.62047C7.6925 2.23047 7.6925 1.60047 7.3025 1.21047C6.9125 0.820469 6.2825 0.820469 5.8925 1.21047L0.2925 6.80047C-0.0975 7.19047 -0.0975 7.82047 0.2925 8.21047L5.8825 13.8005C6.2725 14.1805 6.9125 14.1805 7.2925 13.8005Z" fill="#0065B3"/>
                                </svg>
                                Zobraziť minulé udalosti
                            </button>
                        </div>

                        <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                            <div class="idsk-timeline__left-side">
                                {this.dateButton()}
                            <br/>
                            <br/>

                                {dateI18n('d.m.Y', date)}
                                <span class="govuk-body-m">14.03.2021</span>
                                <br/>
                                <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                            </div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line--circle"></span>
                            </div>
                            <div class="idsk-timeline__content__caption">
                                <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid">Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid</a>
                            </div>
                        </div>

                        <div class="idsk-timeline__content ">
                            <div class="idsk-timeline__left-side">
                                <span class="govuk-body-m">15.03.2021</span>
                                <br/>
                                <span class="idsk-timeline__content__time">9:30 - 12:00</span>
                            </div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line--circle"></span>
                            </div>
                            <div class="idsk-timeline__content__caption">
                                <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscing">Lorem ipsum dolor sit amet, consectetur adipiscing</a>
                            </div>
                        </div>

                        <div class="idsk-timeline__content govuk-body">
                            <div class="idsk-timeline__left-side"></div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line"></span>
                            </div>
                            <div class="idsk-timeline__content__date-line">
                                <span class="idsk-timeline__content__text">marec 2021
                                </span>
                            </div>
                        </div>

                        <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                            <div class="idsk-timeline__left-side">
                                <span class="govuk-body-m">16.03.2021</span>
                                <br/>
                                <span class="idsk-timeline__content__time">10:30 - 12:00</span>
                            </div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line--circle"></span>
                            </div>
                            <div class="idsk-timeline__content__caption">
                                <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid">Lorem ipsum dolor sit amet, consectetur adipiscingLorem ipsum dolor sit amet, consectetur adid</a>
                            </div>
                        </div>

                        <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                            <div class="idsk-timeline__left-side">
                                <span class="govuk-body-m">17.03.2021</span>
                                <br/>
                                <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                            </div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line--circle"></span>
                            </div>
                            <div class="idsk-timeline__content__caption">
                                <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt labor et labore. Lorem ipsum dolor sit amet, consectetur adipiscing">Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt labor et labore. Lorem ipsum dolor sit amet, consectetur adipiscing</a>
                            </div>
                        </div>

                        <div class="idsk-timeline__content govuk-body">
                            <div class="idsk-timeline__left-side"></div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line"></span>
                            </div>
                            <div class="idsk-timeline__content__date-line">
                                <span class="idsk-timeline__content__text">máj 2021
                                </span>
                            </div>
                        </div>

                        <div class="idsk-timeline__content idsk-timeline__content__title-div">
                            <div class="idsk-timeline__left-side"></div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line"></span>
                            </div>
                            <div class="idsk-timeline__content__title">
                                <h3 class="govuk-heading-m">Vybavenie rodného listu dieťaťa
                                </h3>
                            </div>
                        </div>

                        <div class="idsk-timeline__content idsk-timeline__content__caption--long">
                            <div class="idsk-timeline__left-side">
                                <span class="govuk-body-m">18.03.2021</span>
                                <br/>
                                <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                            </div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line--circle"></span>
                            </div>
                            <div class="idsk-timeline__content__caption">
                                <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt ut labore et labore. Lorem ipsum dolor sit">Lorem ipsum dolor sit amet, consectetur adipiscingelit, sed do eiusmod tempor incididunt ut labore et labore. Lorem ipsum dolor sit</a>
                            </div>
                        </div>

                        <div class="idsk-timeline__content ">
                            <div class="idsk-timeline__left-side">
                                <span class="govuk-body-m">19.03.2021</span>
                                <br/>
                                <span class="idsk-timeline__content__time">8:30 - 12:00</span>
                            </div>
                            <div class="idsk-timeline__middle">
                                <span class="idsk-timeline__vertical-line--circle"></span>
                            </div>
                            <div class="idsk-timeline__content__caption">
                                <a class="govuk-link"  href="#"  title="Lorem ipsum dolor sit amet, consectetur adipiscing">Lorem ipsum dolor sit amet, consectetur adipiscing</a>
                            </div>
                        </div>

                        <button type="button" class="idsk-timeline__button--forward">
                            Zobraziť budúce udalosti
                            <svg class="idsk-timeline__button__svg--next" width="20" height="13" viewbox="-5 0 25 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5558 0.281376C12.1577 0.666414 12.1577 1.2884 12.5558 1.67344L16.5063 5.51395L1.0208 5.51395C0.45936 5.51395 1.90735e-06 5.95823 1.90735e-06 6.50123C1.90735e-06 7.04424 0.45936 7.48851 1.0208 7.48851L16.5063 7.48851L12.5456 11.3192C12.1475 11.7042 12.1475 12.3262 12.5456 12.7112C12.9437 13.0963 13.5868 13.0963 13.9849 12.7112L19.7014 7.19233C20.0995 6.80729 20.0995 6.1853 19.7014 5.80027L13.9952 0.281376C13.597 -0.0937901 12.9437 -0.0937901 12.5558 0.281376Z" fill="#0065B3"/>
                            </svg>
                        </button>

                    </div>
                </div>


                <div class="idsk-stepper myClass" data-module="idsk-stepper" id="default-example" data-attribute="value" >
                    <div class="idsk-stepper__subtitle-container">
                        <div class="idsk-stepper__subtitle--heading govuk-grid-column-three-quarters">
                            <RichText
                                class={classes + " govuk-heading-m idsk-stepper__section-subtitle"}
                                key="editable"
                                tagName="h3"
                                placeholder={__('Nadpis míľnika', 'idsk')}
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
                                        placeholder={__('Nadpis míľnika', 'idsk')}
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
                                            placeholder={__('Nadpis kroku', 'idsk')}
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
                                        placeholder={__('Časť kroku', 'idsk')}
                                    />
                                </div>

                                {(!!item.lastSubStep || (item.subStep == '' && !item.hasSub )) &&
                                <p>
                                    <input
                                        className="button-primary button"
                                        type="submit"
                                        value={__('Pridať čiastočný krok', 'idsk')}
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
                            value={__('Pridať krok', 'idsk')}
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