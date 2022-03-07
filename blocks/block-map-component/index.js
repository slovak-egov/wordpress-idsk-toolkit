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
    title: __('Map component', 'idsk-toolkit'),
    description: __('Use the map component when you want to show the users a phenomenon related to space (e.g. the number of people vaccinated against COVID-19 in Slovakia in different regions).', 'idsk-toolkit'),
    icon: 'admin-site-alt',
    category: 'idsk-components',
    keywords: [
        __('map', 'idsk-toolkit'),
        __('component', 'idsk-toolkit'),
        __('map component', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        blockId: {
            type: 'string'
        },
        title: {
            type: 'string',
            selector: 'h2.govuk-heading-l'
        },
        indicatorOptions: {
            type: 'array',
            default: []
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
                periodOption: __('Entire period', 'idsk-toolkit'),
                indicatorOption: this.props.attributes.indicatorOptions.length > 0 ? this.props.attributes.indicatorOptions[0].text : '',
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
            const { blockId, title, indicatorOptions, iframeMapTitle, iframeTableTitle, iframeMap, iframeTable, csvDownload, downloadText, source } = attributes

            if (!blockId) {
                this.props.setAttributes( { blockId: nanoid() } )
            }

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Links settings', 'idsk-toolkit')}>
                        <TextControl
                            className="js-iframe-map-title"
                            key="editable"
                            label={__('Iframe title of map overview', 'idsk-toolkit')}
                            value={iframeMapTitle}
                            onChange={value => this.onChange('iframeMapTitle', value)} 
                        />
                        <TextControl
                            className="js-iframe-map"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('URL source for iframe of map overview', 'idsk-toolkit')}
                            value={iframeMap}
                            onChange={value => this.onChange('iframeMap', value)} 
                        />
                        <TextControl
                            className="js-iframe-table-title"
                            key="editable"
                            label={__('Iframe title of table oveview', 'idsk-toolkit')}
                            value={iframeTableTitle}
                            onChange={value => this.onChange('iframeTableTitle', value)} 
                        />
                        <TextControl
                            className="js-iframe-table"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('URL source for iframe of table overview', 'idsk-toolkit')}
                            value={iframeTable}
                            onChange={value => this.onChange('iframeTable', value)} 
                        />
                        <TextControl
                            className="js-csv-download"
                            key="editable"
                            placeholder={__('e.g. Download data (CSV, 42kb)', 'idsk-toolkit')}
                            label={__('File link name to download', 'idsk-toolkit')}
                            value={downloadText}
                            onChange={value => this.onChange('downloadText', value)} 
                        />
                        <TextControl
                            className="js-csv-download"
                            key="editable"
                            placeholder={__('https://www.google.com', 'idsk-toolkit')}
                            label={__('URL source for file to download', 'idsk-toolkit')}
                            value={csvDownload}
                            onChange={value => this.onChange('csvDownload', value)} 
                        />
                    </PanelBody>

                    <PanelBody title={__('Indicators settings', 'idsk-toolkit')}>
                        {!!indicatorOptions && indicatorOptions.map((item, index) =>
                            <>
                                <h2>{__('Indicator', 'idsk-toolkit')} {index+1}</h2>
                                <div key={item.id || index}>
                                    <TextControl
                                        key="editable"
                                        label={__('Indicator value', 'idsk-toolkit')}
                                        value={item.value}
                                        onChange={value => this.editItem('value', index, value)} 
                                    />
                                    <TextControl
                                        key="editable"
                                        label={__('Indicator text', 'idsk-toolkit')}
                                        value={item.text}
                                        onChange={value => this.editItem('text', index, value)} 
                                    />
                                </div>
                                <input
                                    className="button-secondary button"
                                    type="submit"
                                    value={__('Delete indicator', 'idsk-toolkit')}
                                    onClick={(e) => this.removeItem(e, index)}
                                />
                                <div class="govuk-clearfix"></div>
                            </>
                        )}
                        <br/>
                        <input
                            className="button-primary button"
                            type="submit"
                            value={__('Add indicator', 'idsk-toolkit')}
                            onClick={(e) => this.addItem(e)}
                        />
                    </PanelBody>
                </InspectorControls>

                <div data-module="idsk-interactive-map" class="idsk-interactive-map">
                    <RichText
                        className="govuk-heading-l"
                        key="editable"
                        tagName="h2"
                        placeholder={__('Map component heading', 'idsk-toolkit')}
                        value={title}
                        onChange={value => this.onChange('title', value)} 
                    />
                    <div class="idsk-interactive-map__header">
                        <div class="idsk-interactive-map__header-controls">
                            <div class="idsk-interactive-map__header-radios">
                                <div class="govuk-form-group">
                                    <div class="govuk-radios govuk-radios--inline">
                                        <div class="govuk-radios__item idsk-intereactive-map__radio-map">
                                            <input class="govuk-radios__input" name="interactive-radios-b" id={blockId + "-interactive-radios-b-1"} type="radio" value="map" checked />
                                            <label class="govuk-label govuk-radios__label" for={blockId + "-interactive-radios-b-1"}>{__('Map', 'idsk-toolkit')}</label>
                                        </div>
                                        <div class="govuk-radios__item idsk-intereactive-map__radio-table">
                                            <input class="govuk-radios__input" name="interactive-radios-b" id={blockId + "-interactive-radios-b-2"} type="radio" value="table" />
                                            <label class="govuk-label govuk-radios__label" for={blockId + "-interactive-radios-b-2"}>{__('Table', 'idsk-toolkit')}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="idsk-interactive-map__header-selects">
                                <div class="govuk-form-group">
                                    <div class="govuk-label-wrapper">
                                        <label class="govuk-label" for="time-period"><strong>{__('Period', 'idsk-toolkit')}</strong></label>
                                    </div>
                                    <select class="idsk-interactive-map__select-time-period govuk-select" id="time-period" name="time-period" onChange={this.handleChange}>
                                        <option value="30">{__('Last month', 'idsk-toolkit')}</option>
                                        <option value="90">{__('Last 3 months', 'idsk-toolkit')}</option>
                                        <option value="180">{__('Last 6 months', 'idsk-toolkit')}</option>
                                        <option value="" selected="selected">{__('Entire period', 'idsk-toolkit')}</option>
                                    </select>
                                </div>

                                {(!!indicatorOptions && indicatorOptions.length != 0) &&
                                    <div class="govuk-form-group">
                                        <div class="govuk-label-wrapper">
                                            <label class="govuk-label" for="indicator"><strong>{__('Indicator', 'idsk-toolkit')}</strong></label>
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
                                <span class="idsk-interactive-map__current-indicator">{indicatorOption}</span> {__('for', 'idsk-toolkit')} <span class="idsk-interactive-map__current-time-period">{periodOption}</span>
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
                        {(csvDownload != '' || downloadText != '') &&
                            <a class="govuk-link idsk-interactive-map__meta-data" title={downloadText} href="#">{downloadText}</a>
                        }
                        <RichText
                            className="idsk-interactive-map__meta-source"
                            key="editable"
                            tagName="span"
                            placeholder={__('Source: map overview source', 'idsk-toolkit')}
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