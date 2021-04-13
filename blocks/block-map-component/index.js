/**
 * BLOCK - map-component
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
    TextControl
} = wp.components
const { Component } = wp.element
const { __ } = wp.i18n

registerBlockType('idsk/map-component', {
    // built-in attributes
    title: __('Mapový komponent', 'idsk-toolkit'),
    description: __('Mapový komponent použite, keď chcete používateľom zobrazovať nejaký jav vzťahujúci sa k priestoru (napr. počet zaočkovaných proti COVID-19 na Slovensku v krajoch).', 'idsk-toolkit'),
    icon: 'admin-site-alt',
    category: 'idsk-components',
    keywords: [
        __('mapa', 'idsk-toolkit'),
        __('komponent', 'idsk-toolkit'),
        __('mapový komponent', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        title: {
            type: 'string',
            selector: 'h2.govuk-heading-l'
        },
        indicatorOptions: {
            type: 'array'
        },
        iframeMapTitle: {
            type: 'string',
            selector: 'js-iframe-map-title'
        },
        iframeMap: {
            type: 'string',
            selector: 'js-iframe-map'
        },
        iframeTableTitle: {
            type: 'string',
            selector: 'js-iframe-table-title'
        },
        iframeTable: {
            type: 'string',
            selector: 'js-iframe-table'
        },
        csvDownload: {
            type: 'string',
            selector: 'js-csv-download'
        },
        downloadText: {
            type: 'string',
            selector: 'idsk-interactive-map__meta-data'
        },
        source: {
            type: 'string',
            selector: 'idsk-interactive-map__meta-source'
        },
    },

    // The UI for the WordPress editor
    edit: class MapComponent extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                periodOption: __('Celé obdobie', 'idsk-toolkit'),
                indicatorOption: this.props.attributes.indicatorOptions ? this.props.attributes.indicatorOptions[0].text : '',
                indicatorOptions: this.props.attributes.indicatorOptions || []
            }

            this.addItem = this.addItem.bind(this)
            this.removeItem = this.removeItem.bind(this)
            this.editItem = this.editItem.bind(this)
            this.onChange = this.onChange.bind(this)
            this.handleChange = this.handleChange.bind(this)
        }

        // custom functions
        onChange(attribute, value) {
            return (
                this.props.setAttributes(
                    { [attribute]: value }
                )
            )
        }

        // handle selected options
        handleChange(e) {
            const index = e.nativeEvent.target.selectedIndex
            const name = e.nativeEvent.target.name
            const attribute = ( name == 'time-period' ? 'periodOption' : 'indicatorOption' )

            return (
                this.setState(
                    { [attribute]: e.nativeEvent.target[index].text }
                )
            )
        }

        // adds empty placeholder for item
        addItem(e) {
            e.preventDefault()

            // get items from state
            const { indicatorOptions } = this.state

            // set up empty item
            const emptyItem = {
                id: nanoid(),
                value: '',
                text: ''
            }

            // append new emptyItem object to indicatorOptions
            const newIndicatorOptions = [...indicatorOptions, emptyItem]

            // save new placeholder to WordPress
            this.props.setAttributes({ indicatorOptions: newIndicatorOptions })

            // and update state
            return this.setState({ indicatorOptions: newIndicatorOptions })
        }

        // remove item
        removeItem(e, index) {
            e.preventDefault()

            // make a true copy of indicatorOptions
            const indicatorOptions = JSON.parse(JSON.stringify(this.state.indicatorOptions))

            // remove specified item
            indicatorOptions.splice(index, 1)

            // save updated indicatorOptions and update state (in callback)
            return (
                this.props.setAttributes(
                    { indicatorOptions: indicatorOptions },
                    this.setState({ indicatorOptions: indicatorOptions })
                )
            )
        }

        // handler function to update item
        editItem(key, index, value) {
            // make a true copy of indicatorOptions
            const indicatorOptions = JSON.parse(JSON.stringify(this.state.indicatorOptions))
            if (indicatorOptions.length === 0) return

            // update value
            indicatorOptions[index][key] = value

            // save values in WordPress and update state (in callback)
            return (
                this.props.setAttributes(
                    { indicatorOptions: indicatorOptions },
                    this.setState({ indicatorOptions: indicatorOptions })
                )
            )
        }
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { periodOption, indicatorOption } = this.state
            const { title, indicatorOptions, iframeMapTitle, iframeTableTitle, iframeMap, iframeTable, csvDownload, downloadText, source } = attributes

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Nastavenia odkazov', 'idsk-toolkit')}>
                        <TextControl
                            className="js-iframe-map-title"
                            key="editable"
                            label={__('Titulok iframe mapového prehľadu', 'idsk-toolkit')}
                            value={iframeMapTitle}
                            onChange={value => this.onChange('iframeMapTitle', value)} 
                        />
                        <TextControl
                            className="js-iframe-map"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('URL zdroj pre iframe mapového prehľadu', 'idsk-toolkit')}
                            value={iframeMap}
                            onChange={value => this.onChange('iframeMap', value)} 
                        />
                        <TextControl
                            className="js-iframe-table-title"
                            key="editable"
                            label={__('Titulok iframe tabuľkového prehľadu', 'idsk-toolkit')}
                            value={iframeTableTitle}
                            onChange={value => this.onChange('iframeTableTitle', value)} 
                        />
                        <TextControl
                            className="js-iframe-table"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('URL zdroj pre iframe tabuľkového prehľadu', 'idsk-toolkit')}
                            value={iframeTable}
                            onChange={value => this.onChange('iframeTable', value)} 
                        />
                        <TextControl
                            className="js-csv-download"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('URL zdroj súboru na stiahnutie', 'idsk-toolkit')}
                            value={csvDownload}
                            onChange={value => this.onChange('csvDownload', value)} 
                        />
                    </PanelBody>

                    <PanelBody title={__('Nastavenia ukazovateľov', 'idsk-toolkit')}>
                        {!!indicatorOptions && indicatorOptions.map((item, index) =>
                            <>
                                <h2>{__('Ukazovateľ', 'idsk-toolkit')} {index+1}</h2>
                                <div key={item.id || index}>
                                    <TextControl
                                        key="editable"
                                        label={__('Hodnota (value) ukazovateľa', 'idsk-toolkit')}
                                        value={item.value}
                                        onChange={value => this.editItem('value', index, value)} 
                                    />
                                    <TextControl
                                        key="editable"
                                        label={__('Text ukazovateľa', 'idsk-toolkit')}
                                        value={item.text}
                                        onChange={value => this.editItem('text', index, value)} 
                                    />
                                </div>
                                <input
                                    className="button-secondary button"
                                    type="submit"
                                    value={__('Vymazať ukazovateľ', 'idsk-toolkit')}
                                    onClick={(e) => this.removeItem(e, index)}
                                />
                                <div class="govuk-clearfix"></div>
                            </>
                        )}
                        <input
                            className="button-primary button"
                            type="submit"
                            value={__('Pridať ukazovateľ', 'idsk-toolkit')}
                            onClick={(e) => this.addItem(e)}
                        />
                    </PanelBody>
                </InspectorControls>

                <div data-module="idsk-interactive-map" class="idsk-interactive-map">
                    <RichText
                        className="govuk-heading-l"
                        key="editable"
                        tagName="h2"
                        placeholder={__('Nadpis mapového komponentu', 'idsk-toolkit')}
                        value={title}
                        onChange={value => this.onChange('title', value)} 
                    />
                    <div class="idsk-interactive-map__header">
                        <div class="idsk-interactive-map__header-controls">
                            <div class="idsk-interactive-map__header-radios">
                                <div class="govuk-form-group">
                                    <div class="govuk-radios govuk-radios--inline">
                                        <div class="govuk-radios__item idsk-intereactive-map__radio-map">
                                            <input class="govuk-radios__input" name="interactive-radios-b" id="interactive-radios-b-1" type="radio" value="map" checked />
                                            <label class="govuk-label govuk-radios__label" for="interactive-radios-b-1">{__('Mapa', 'idsk-toolkit')}</label>
                                        </div>
                                        <div class="govuk-radios__item idsk-intereactive-map__radio-table">
                                            <input class="govuk-radios__input" name="interactive-radios-b" id="interactive-radios-b-2" type="radio" value="table" />
                                            <label class="govuk-label govuk-radios__label" for="interactive-radios-b-2">{__('Tabuľka', 'idsk-toolkit')}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="idsk-interactive-map__header-selects">
                                <div class="govuk-form-group">
                                    <div class="govuk-label-wrapper">
                                        <label class="govuk-label" for="time-period"><strong>{__('Obdobie', 'idsk-toolkit')}</strong></label>
                                    </div>
                                    <select class="idsk-interactive-map__select-time-period govuk-select" id="time-period" name="time-period" onChange={this.handleChange}>
                                        <option value="30">{__('Posledný mesiac', 'idsk-toolkit')}</option>
                                        <option value="90">{__('Posledné 3 mesiace', 'idsk-toolkit')}</option>
                                        <option value="180">{__('Posledných 6 mesiacov', 'idsk-toolkit')}</option>
                                        <option value="" selected="selected">{__('Celé obdobie', 'idsk-toolkit')}</option>
                                    </select>
                                </div>

                                {(!!indicatorOptions && indicatorOptions.length != 0) &&
                                    <div class="govuk-form-group">
                                        <div class="govuk-label-wrapper">
                                            <label class="govuk-label" for="indicator"><strong>{__('Ukazovateľ', 'idsk-toolkit')}</strong></label>
                                        </div>
                                        <select class="idsk-interactive-map__select-indicator govuk-select" id="indicator" name="indicator" onChange={this.handleChange}>
                                            {!!indicatorOptions && indicatorOptions.map((item, index) =>
                                                <option key={item.id || index} value={item.value}>{item.text}</option>
                                            )}
                                        </select>
                                    </div>
                                }
                            </div>
                        </div>

                        {(!!indicatorOptions && indicatorOptions.length != 0) &&
                            <h3 class="govuk-heading-m">
                                <span class="idsk-interactive-map__current-indicator">{indicatorOption}</span> {__('za', 'idsk-toolkit')} <span class="idsk-interactive-map__current-time-period">{periodOption}</span>
                            </h3>
                        }

                    </div>
                    <div class="idsk-interactive-map__body">
                        <div class="idsk-interactive-map__map">
                            <iframe class="idsk-interactive-map__map-iframe" data-src={iframeMap} src={iframeMap} title={iframeMapTitle}></iframe>
                        </div>
                        <div class="idsk-interactive-map__table">
                            <iframe class="idsk-interactive-map__table-iframe" data-src={iframeTable} title={iframeTableTitle}></iframe>
                        </div>
                    </div>
                    <div class="idsk-interactive-map__meta">
                        {(!!csvDownload && csvDownload != '') &&
                            <RichText
                                className="idsk-interactive-map__meta-data"
                                key="editable"
                                tagName="a"
                                placeholder={__('Stiahnuť údaje (CSV, 42 kb)', 'idsk-toolkit')}
                                value={downloadText}
                                onChange={value => this.onChange('downloadText', value)} 
                            />
                        }
                        <RichText
                            className="idsk-interactive-map__meta-source"
                            key="editable"
                            tagName="span"
                            placeholder={__('Zdroj: zdroj mapového prehľadu', 'idsk-toolkit')}
                            value={source}
                            onChange={value => this.onChange('source', value)} 
                        />
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