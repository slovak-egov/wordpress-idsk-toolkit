/**
 * BLOCK - graph-component
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

// Used to make item ids
import { nanoid } from 'nanoid'
const { registerBlockType } = wp.blocks // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    InspectorControls
} = wp.blockEditor
const {
    PanelBody,
    TextControl,
    ToggleControl
} = wp.components
const { Component } = wp.element
const { __ } = wp.i18n

registerBlockType('idsk/graph-component', {
    // built-in attributes
    title: __('Grafový komponent', 'idsk-toolkit'),
    description: __('Grafové zobrazenie údajov pomáha používateľom lepšie pochopiť prezentované údaje. Grafový komponent použite, keď chcete používateľom zobrazovať nejaký jav v závislosti na ďalšej premennej - napríklad vývoj javu v čase (napr. vývoj počtu nakazených COVID-19 na Slovensku).', 'idsk-toolkit'),
    icon: 'chart-area',
    category: 'idsk-components',
    keywords: [
        __('graf', 'idsk-toolkit'),
        __('komponent', 'idsk-toolkit'),
        __('grafový komponent', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        blockId: {
            type: 'string'
        },
        title: {
            type: 'string',
            selector: 'h2.govuk-heading-m'
        },
        graphOptions: {
            type: 'array'
        },
        summary: {
            type: 'string',
            selector: 'idsk-graph__summary'
        },
        iframeLabel1: {
            type: 'string',
            selector: 'js-iframe-label-1'
        },
        iframeLabel2: {
            type: 'string',
            selector: 'js-iframe-label-2'
        },
        iframeLabel3: {
            type: 'string',
            selector: 'js-iframe-label-3'
        },
        iframeLabel4: {
            type: 'string',
            selector: 'js-iframe-label-4'
        },
        iframeTitleGraph1: {
            type: 'string',
            selector: 'js-iframe-title-graph'
        },
        iframeGraph1: {
            type: 'string',
            selector: 'js-iframe-graph'
        },
        iframeTitleGraph2: {
            type: 'string',
            selector: 'js-iframe-title-graph-2'
        },
        iframeGraph2: {
            type: 'string',
            selector: 'js-iframe-graph-2'
        },
        iframeTitleGraph3: {
            type: 'string',
            selector: 'js-iframe-title-graph-3'
        },
        iframeGraph3: {
            type: 'string',
            selector: 'js-iframe-graph-3'
        },
        bodyGraph4: {
            type: 'string',
            selector: 'js-iframe-body-graph-4'
        },
        downloadLinks: {
            type: 'array'
        },
        shareOption: {
            type: 'boolean',
            selector: 'js-share-option',
            default: true
        },
        source: {
            type: 'string',
            selector: 'idsk-graph__meta-source'
        },
    },

    // The UI for the WordPress editor
    edit: class GraphComponent extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                shareOption: this.props.attributes.shareOption,
                graphOptions: this.props.attributes.graphOptions || [],
                downloadLinks: this.props.attributes.downloadLinks || []
            }

            this.addItem = this.addItem.bind(this)
            this.removeItem = this.removeItem.bind(this)
            this.editItem = this.editItem.bind(this)
            this.onChange = this.onChange.bind(this)
        }

        // custom functions
        onChange(attribute, value) {
            return (
                this.props.setAttributes(
                    { [attribute]: value }
                )
            )
        }

        // adds empty placeholder for item
        addItem(e, array='') {
            e.preventDefault()

            let arrayState
            let arrayName
            let emptyItem

            // downloadLinks array
            if (array == 'downloadLinks') {
                // set up empty item
                emptyItem = {
                    id: nanoid(),
                    name: '',
                    url: ''
                }

                arrayName = 'downloadLinks'
                // get items from state
                arrayState = this.state.downloadLinks
            } 
            // default array
            else {
                // set up empty item
                emptyItem = {
                    id: nanoid(),
                    name: '',
                    value: ''
                }

                arrayName = 'graphOptions'
                // get items from state
                arrayState = this.state.graphOptions
            }

            // append new emptyItem object to arrayState
            const newArray = [...arrayState, emptyItem]

            // save new placeholder to WordPress
            this.props.setAttributes({ [arrayName]: newArray })

            // and update state
            return this.setState({ [arrayName]: newArray })
        }

        // remove item
        removeItem(e, index, array='') {
            e.preventDefault()
            
            let arrayState
            let arrayName

            // downloadLinks array
            if (array == 'downloadLinks') {
                // make a true copy of array
                arrayState = JSON.parse(JSON.stringify(this.state.downloadLinks))
                arrayName = 'downloadLinks'
            } 
            // default array
            else {
                // make a true copy of array
                arrayState = JSON.parse(JSON.stringify(this.state.graphOptions))
                arrayName = 'graphOptions'
            }

            // remove specified item
            arrayState.splice(index, 1)

            // save updated array and update state (in callback)
            return (
                this.props.setAttributes(
                    { [arrayName]: arrayState },
                    this.setState({ [arrayName]: arrayState })
                )
            )
        }

        // handler function to update item
        editItem(key, index, value, array='') {
            
            let arrayState
            let arrayName

            // downloadLinks array
            if (array == 'downloadLinks') {
                // make a true copy of array
                arrayState = JSON.parse(JSON.stringify(this.state.downloadLinks))
                arrayName = 'downloadLinks'
            }
            // default array
            else {
                // make a true copy of array
                arrayState = JSON.parse(JSON.stringify(this.state.graphOptions))
                arrayName = 'graphOptions'
            }

            if (arrayState.length === 0) return

            // update value
            arrayState[index][key] = value

            // save values in WordPress and update state (in callback)
            return (
                this.props.setAttributes(
                    { [arrayName]: arrayState },
                    this.setState({ [arrayName]: arrayState })
                )
            )
        }
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { blockId, title, graphOptions, summary, iframeLabel1, iframeLabel2, iframeLabel3, iframeLabel4, iframeTitleGraph1, iframeGraph1, iframeTitleGraph2, iframeGraph2, iframeTitleGraph3, iframeGraph3, bodyGraph4, downloadLinks, shareOption, source } = attributes

            if (!blockId) {
                this.props.setAttributes( { blockId: 'graph-' + nanoid() } )
            }

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Nastavenia pohľadov', 'idsk-toolkit')}>
                        <h2>{!!iframeLabel1 ? iframeLabel1 : __('Pohľad 1', 'idsk-toolkit')}</h2>
                        <TextControl
                            className="js-iframe-title-graph"
                            key="editable"
                            label={ ( !!iframeLabel1 ? iframeLabel1 : __('Pohľad 1', 'idsk-toolkit') ) + __(' - titulok iframe pohľadu', 'idsk-toolkit')}
                            value={iframeTitleGraph1}
                            onChange={value => this.onChange('iframeTitleGraph1', value)} 
                        />
                        <TextControl
                            className="js-iframe-graph"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={ ( !!iframeLabel1 ? iframeLabel1 : __('Pohľad 1', 'idsk-toolkit') ) + __(' - URL zdroj pre iframe pohľadu', 'idsk-toolkit')}
                            value={iframeGraph1}
                            onChange={value => this.onChange('iframeGraph1', value)} 
                        />

                        <h2>{!!iframeLabel2 ? iframeLabel2 : __('Pohľad 2', 'idsk-toolkit')}</h2>
                        <TextControl
                            className="js-iframe-title-graph-2"
                            key="editable"
                            label={ ( !!iframeLabel2 ? iframeLabel2 : __('Pohľad 2', 'idsk-toolkit') ) + __(' - titulok iframe pohľadu', 'idsk-toolkit')}
                            value={iframeTitleGraph2}
                            onChange={value => this.onChange('iframeTitleGraph2', value)} 
                        />
                        <TextControl
                            className="js-iframe-graph-2"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={ ( !!iframeLabel2 ? iframeLabel2 : __('Pohľad 2', 'idsk-toolkit') ) + __(' - URL zdroj pre iframe pohľadu', 'idsk-toolkit')}
                            value={iframeGraph2}
                            onChange={value => this.onChange('iframeGraph2', value)} 
                        />

                        <h2>{!!iframeLabel3 ? iframeLabel3 : __('Pohľad 3', 'idsk-toolkit')}</h2>
                        <TextControl
                            className="js-iframe-title-graph-3"
                            key="editable"
                            label={ ( !!iframeLabel3 ? iframeLabel3 : __('Pohľad 3', 'idsk-toolkit') ) + __(' - titulok iframe pohľadu', 'idsk-toolkit')}
                            value={iframeTitleGraph3}
                            onChange={value => this.onChange('iframeTitleGraph3', value)} 
                        />
                        <TextControl
                            className="js-iframe-graph-3"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={ ( !!iframeLabel3 ? iframeLabel3 : __('Pohľad 3', 'idsk-toolkit') ) + __(' - URL zdroj pre iframe pohľadu', 'idsk-toolkit')}
                            value={iframeGraph3}
                            onChange={value => this.onChange('iframeGraph3', value)} 
                        />
                    </PanelBody>

                    <PanelBody title={__('Nastavenia zobrazenia javov v grafe', 'idsk-toolkit')}>
                        {!!graphOptions && graphOptions.map((item, index) =>
                            <>
                                <h2>{__('Zobrazenie javu', 'idsk-toolkit')} {index+1}</h2>
                                <div key={item.id || index}>
                                    <TextControl
                                        key="editable"
                                        label={__('Názov javu', 'idsk-toolkit') + ' ' + (index+1)}
                                        value={item.name}
                                        onChange={value => this.editItem('name', index, value)} 
                                    />
                                    <TextControl
                                        key="editable"
                                        label={__('Hodnota (value) javu', 'idsk-toolkit') + ' ' + (index+1)}
                                        value={item.value}
                                        onChange={value => this.editItem('value', index, value)} 
                                    />
                                </div>
                                <input
                                    className="button-secondary button"
                                    type="submit"
                                    value={__('Vymazať jav grafu', 'idsk-toolkit')}
                                    onClick={(e) => this.removeItem(e, index)}
                                />
                                <div class="govuk-clearfix"></div>
                            </>
                        )}
                        <input
                            className="button-primary button"
                            type="submit"
                            value={__('Pridať jav grafu', 'idsk-toolkit')}
                            onClick={(e) => this.addItem(e)}
                        />
                    </PanelBody>

                    <PanelBody title={__('Nastavenia súborov na stiahnutie', 'idsk-toolkit')}>
                        {!!downloadLinks && downloadLinks.map((item, index) =>
                            <>
                                <h2>{__('Súbor na stiahnutie', 'idsk-toolkit')} {index+1}</h2>
                                <div key={item.id || index}>
                                    <TextControl
                                        key="editable"
                                        label={__('Názov odkazu', 'idsk-toolkit')}
                                        value={item.name}
                                        placeholder={__('ako CSV (54 kB)', 'idsk-toolkit')}
                                        onChange={value => this.editItem('name', index, value, 'downloadLinks')} 
                                    />
                                    <TextControl
                                        key="editable"
                                        label={__('URL odkazu', 'idsk-toolkit')}
                                        value={item.url}
                                        placeholder={__('https://www.google.com', 'idsk-toolkit')}
                                        onChange={value => this.editItem('url', index, value, 'downloadLinks')} 
                                    />
                                </div>
                                <input
                                    className="button-secondary button"
                                    type="submit"
                                    value={__('Vymazať súbor na stiahnutie', 'idsk-toolkit')}
                                    onClick={(e) => this.removeItem(e, index, 'downloadLinks')}
                                />
                                <div class="govuk-clearfix"></div>
                            </>
                        )}
                        <input
                            className="button-primary button"
                            type="submit"
                            value={__('Pridať súbor na stiahnutie', 'idsk-toolkit')}
                            onClick={(e) => this.addItem(e, 'downloadLinks')}
                        />
                    </PanelBody>
                    
                    <PanelBody title={__('Nastavenie zdieľania', 'idsk-toolkit')}>
                        <ToggleControl
                            className="js-share-option"
                            checked={shareOption}
                            label={shareOption ? __('Povolené', 'idsk-toolkit') : __('Zakázané', 'idsk-toolkit')}
                            onChange={checked => setAttributes({ shareOption: checked })}
                        />
                    </PanelBody>
                </InspectorControls>

                <div data-module="idsk-graph" class="idsk-graph" id={blockId}>
                    <div class="govuk-grid-row idsk-graph__heading">
                        <div class="idsk-graph__title">
                            <RichText
                                className="govuk-heading-m"
                                key="editable"
                                tagName="h2"
                                placeholder={__('Nadpis grafového komponentu', 'idsk-toolkit')}
                                value={title}
                                onChange={value => this.onChange('title', value)} 
                            />
                        </div>
                        <div class="idsk-graph__controls">
                            <div class="govuk-form-group">
                                <div class="govuk-radios govuk-radios--inline">

                                    {(!!graphOptions && graphOptions.length != 0) && graphOptions.map((item, index) =>
                                        <div key={item.id || index} class="govuk-radios__item">
                                            <input class="govuk-radios__input idsk-graph__radio" name={"radio-" + blockId} id={"radio-" + blockId + "-" + index} type="radio" value={item.name} />
                                            <label class="govuk-label govuk-radios__label" for={"radio-" + blockId + "-" + index}>{item.name}</label>
                                        </div>
                                    )}

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="govuk-grid-row">
                        <div class="govuk-grid-column-one-half">
                            <RichText
                                className="govuk-body-s idsk-graph__summary"
                                key="editable"
                                tagName="summary"
                                placeholder={__('Súhrnný popis grafového komponentu', 'idsk-toolkit')}
                                value={summary}
                                onChange={value => this.onChange('summary', value)} 
                            />
                        </div>
                    </div>

                    
                    <div class="govuk-tabs" data-activetab="" data-module="govuk-tabs">
                        <h2 class="govuk-tabs__title">
                            {__('Obsah', 'idsk-toolkit')}
                        </h2>
                        <ul class="govuk-tabs__list">
                            <li class="govuk-tabs__list-item">
                                <RichText
                                    className="govuk-tabs__tab js-iframe-label-1"
                                    key="editable"
                                    tagName="a"
                                    placeholder={__('Pohľad 1', 'idsk-toolkit')}
                                    value={iframeLabel1}
                                    onChange={value => this.onChange('iframeLabel1', value)} 
                                />
                            </li>
                            <li class="govuk-tabs__list-item">
                                <RichText
                                    className="govuk-tabs__tab js-iframe-label-2"
                                    key="editable"
                                    tagName="a"
                                    placeholder={__('Pohľad 2', 'idsk-toolkit')}
                                    value={iframeLabel2}
                                    onChange={value => this.onChange('iframeLabel2', value)} 
                                />
                            </li>
                            <li class="govuk-tabs__list-item">
                                <RichText
                                    className="govuk-tabs__tab js-iframe-label-3"
                                    key="editable"
                                    tagName="a"
                                    placeholder={__('Pohľad 3', 'idsk-toolkit')}
                                    value={iframeLabel3}
                                    onChange={value => this.onChange('iframeLabel3', value)} 
                                />
                            </li>
                            <li class="govuk-tabs__list-item govuk-tabs__list-item--selected idsk-graph__section--selected">
                                <RichText
                                    className="govuk-tabs__tab js-iframe-label-4"
                                    key="editable"
                                    tagName="a"
                                    placeholder={__('Metodika', 'idsk-toolkit')}
                                    value={iframeLabel4}
                                    onChange={value => this.onChange('iframeLabel4', value)} 
                                />
                            </li>
                        </ul>
                        <section class="govuk-tabs__panel govuk-tabs__panel--hidden" id={blockId + "-1"}>
                            <iframe class='idsk-graph__iframe' data-src={iframeGraph1} src={iframeGraph1} title={iframeTitleGraph1}></iframe>
                        </section>
                        <section class="govuk-tabs__panel govuk-tabs__panel--hidden" id={blockId + "-2"}>
                            <iframe class='idsk-graph__iframe' data-src={iframeGraph2} src={iframeGraph2} title={iframeTitleGraph2}></iframe>
                        </section>
                        <section class="govuk-tabs__panel govuk-tabs__panel--hidden" id={blockId + "-3"}>
                            <iframe class='idsk-graph__iframe' data-src={iframeGraph3} src={iframeGraph3} title={iframeTitleGraph3}></iframe>
                        </section>
                        <section class="govuk-tabs__panel idsk-graph__section-show" id={blockId + "-4"}>
                            <RichText
                                className="govuk-body js-iframe-body-graph-4"
                                key="editable"
                                tagName="p"
                                multiline={true}
                                placeholder={__('Podrobný popis metodiky', 'idsk-toolkit')}
                                value={bodyGraph4}
                                onChange={value => this.onChange('bodyGraph4', value)} 
                            />
                        </section>
                    </div>

                    <div class="idsk-graph__meta">
                        <div class="idsk-graph__meta-download-share">
                            {(!!downloadLinks && downloadLinks.length != 0) &&
                                <div class="idsk-graph__meta-download">
                                    <a class="govuk-link idsk-graph__meta-link-list" title={__('Stiahnuť údaje', 'idsk-toolkit')} href="#">
                                        {__('Stiahnuť údaje', 'idsk-toolkit')}
                                        <svg width="18" height="11" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.0725 1.07107L9.00146 8.14214L1.9304 1.07107" stroke="#0B0C0C" stroke-width="3"/>
                                        </svg>
                                    </a>
                                    <ul class="idsk-graph__meta-list">
                                        
                                        {!!downloadLinks && downloadLinks.map((item, index) =>
                                            <li key={item.id || index}>
                                                <a title={item.name} href="#" class="govuk-link">{item.name}</a>
                                            </li>
                                        )}

                                    </ul>
                                </div>
                            }
                            {!!shareOption &&
                                <div class="idsk-graph__meta-share">
                                    <a class="govuk-link idsk-graph__meta-link-list" title={__('Zdielať údaje', 'idsk-toolkit')} href="#">
                                        {__('Zdielať údaje', 'idsk-toolkit')}
                                        <svg width="18" height="11" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.0725 1.07107L9.00146 8.14214L1.9304 1.07107" stroke="#0B0C0C" stroke-width="3"/>
                                        </svg>
                                    </a>
                                    <ul class="idsk-graph__meta-list">
                                        <li>
                                            <a title={__('Kopírovať link', 'idsk-toolkit')} href="#" class="govuk-link idsk-graph__copy-to-clickboard" >{__('Kopírovať link', 'idsk-toolkit')}</a>
                                        </li>
                                        <li>
                                            <a title={__('Emailom', 'idsk-toolkit')} href={"#" + blockId} class="govuk-link idsk-graph__send-link-by-email" >{__('Emailom', 'idsk-toolkit')}</a>
                                        </li>
                                        <li>
                                            <a title={__('na Facebooku', 'idsk-toolkit')} href={"#" + blockId} class="govuk-link idsk-graph__share-on-facebook" target="_blank">{__('na Facebooku', 'idsk-toolkit')}</a>
                                        </li>
                                    </ul>
                                </div>
                            }
                        </div>
                        <RichText
                            className="idsk-graph__meta-source"
                            key="editable"
                            tagName="div"
                            placeholder={__('Zdroj: zdroj grafového prehľadu', 'idsk-toolkit')}
                            value={source}
                            onChange={value => this.onChange('source', value)} 
                        />
                    </div>
                </div>
            </div>
        }
    },

    // No save, dynamic block
    save() {
        return null
    },
})