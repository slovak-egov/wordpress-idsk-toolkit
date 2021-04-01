/**
 * BLOCK - address
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const apiFetch = wp.apiFetch;
const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    InnerBlocks,
    InspectorControls
} = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    TextControl,
    ToggleControl
} = wp.components;
const { Component } = wp.element
const { __ } = wp.i18n;
const classes = 'block-editor-rich-text__editable rich-text'; // default gutenberg <RichText> classes for displaying placeholders 

registerBlockType('idsk/address', {
    // built-in attributes
    title: __('Adresa', 'idsk'),
    description: __('Zobrazuje adresu s minimapou. K dispozícii sú dve možné zobrazenia.', 'idsk'),
    icon: 'location-alt',
    category: 'idsk-components',
    keywords: [
        __('adresa', 'idsk'),
        __('mapa', 'idsk'),
        __('podujatie', 'idsk'),
    ],

    // custom attributes
    attributes: {
        title: {
            type: 'string',
            selector: 'h2'
        },
        titleSmall: {
            type: 'string',
            selector: 'h3'
        },
        body: {
            type: 'string',
            selector: 'govuk-body'
        },
        gridType: {
            type: 'boolean',
            selector: 'js-address-grid-type',
            default: true
        },
        mapCoords: {
            type: 'string',
            selector: 'js-address-map'
        },
        mapApi: {
            type: 'string',
            selector: 'js-address-map-api'
        },
    },

    // The UI for the WordPress editor
    edit: class Address extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                gridType: this.props.attributes.gridType,
                mapCoords: this.props.attributes.mapCoords,
                mapApi: this.props.attributes.mapApi,
                globalApi: false
            };

            this.gridCheck = this.gridCheck.bind(this);
            this.mapCoordsShow = this.mapCoordsShow.bind(this);
            this.onChangeTitle = this.onChangeTitle.bind(this);
            this.onChangeTitleSmall = this.onChangeTitleSmall.bind(this);
            this.onChangeBody = this.onChangeBody.bind(this);
        }

        // Fetch additional theme settings
        async componentDidMount() {
            const response = await apiFetch( { path: '/idsk/v1/settings' } );
            const apiSettings = await response;

            if (apiSettings.gmap_api != '') {
                this.setState({ 
                    mapApi: apiSettings.gmap_api,
                    globalApi: true 
                });
            }
        }

        gridCheck() {
            let grid = 'idsk-address';

            if (!this.props.attributes.gridType) {
                grid += ' idsk-address--full-width';
            }

            return grid;
        };
        
        mapCoordsShow() {
            let coords = 'https://www.google.com/maps/embed/v1/place?q='

            if (this.props.attributes.mapCoords) {
                coords += this.props.attributes.mapCoords;
            } else { // if empty return default map view
                coords += '0,0';
            }

            if (this.props.attributes.mapApi) {
                coords += '&key='+this.props.attributes.mapApi;
            } else if (this.state.globalApi == true) { // if empty return default map api
                coords += '&key='+this.state.mapApi;
            }

            return coords;
        }
        
        // custom functions
        onChangeTitle(newTitle) {
            // save values in WordPress and update state (in callback)
            return (
                this.props.setAttributes(
                    { title: newTitle }
                )
            )
        };

        onChangeTitleSmall(newTitle) {
            return (
                this.props.setAttributes(
                    { titleSmall: newTitle }
                )
            )
        };

        onChangeBody(newBody) {
            return (
                this.props.setAttributes(
                    { body: newBody }
                )
            )
        };
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { title, titleSmall, body, gridType, mapCoords, mapApi } = attributes

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Rozloženie obsahu')}>
                        <PanelRow>
                            <ToggleControl
                                className="js-address-grid-type"
                                checked={gridType}
                                label={gridType ? "1/3 šírky" : "Celá šírka"}
                                onChange={checked => setAttributes({ gridType: checked })}
                            />
                        </PanelRow>
                    </PanelBody>
                    <PanelBody title={__('Súradnice mapy')}>
                        <TextControl
                            className="js-address-map"
                            label={__('Zadajte adresu miesta', 'idsk')}
                            value={mapCoords}
                            onChange={value => setAttributes({ mapCoords: value })}
                        />
                        {(!this.state.globalApi || this.state.globalApi == false) &&
                        <TextControl
                            className="js-address-map-api"
                            label={__('Zadajte API kľúč pre Google Mapy', 'idsk')}
                            value={mapApi}
                            onChange={value => setAttributes({ mapApi: value })}
                        /> 
                        }
                    </PanelBody>
                </InspectorControls>

                <div data-module="idsk-address" class={this.gridCheck()}>
                    <hr class="idsk-address__separator-top" />
                    <div class="idsk-address__content">
                        <div class="idsk-address__description">
                            
                            <RichText
                                class={classes + " govuk-heading-m"}
                                key="editable"
                                tagName="h2"
                                placeholder={__('Hlavný nadpis', 'idsk')}
                                value={title}
                                onChange={value => this.onChangeTitle(value)} />
                            <RichText
                                class={classes + " govuk-heading-s"}
                                key="editable"
                                tagName="h3"
                                placeholder={__('Vedľajší nadpis', 'idsk')}
                                value={titleSmall}
                                onChange={value => this.onChangeTitleSmall(value)} />
                            <RichText
                                class={classes + " govuk-body"}
                                key="editable"
                                tagName="p"
                                multiline={true}
                                placeholder={__('Popis', 'idsk')}
                                value={body}
                                onChange={value => this.onChangeBody(value)} />
                        </div>
                        <iframe 
                            class="idsk-address__map"
                            loading="lazy"
                            allowfullscreen
                            src={this.mapCoordsShow()}>
                        </iframe>
                    </div>
                    <hr class="idsk-address__separator-bottom" />
                </div>

            </div>;
        }
    },

    // No save, dynamic block
    save() {
        return null
    },
})