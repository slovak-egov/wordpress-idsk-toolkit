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

registerBlockType('idsk/address', {
    // built-in attributes
    title: __('Address', 'idsk-toolkit'),
    description: __('Shows address with minimap. Two displays are available.', 'idsk-toolkit'),
    icon: 'location-alt',
    category: 'idsk-components',
    keywords: [
        __('address', 'idsk-toolkit'),
        __('map', 'idsk-toolkit'),
        __('event', 'idsk-toolkit'),
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
        mapIframeTitle: {
            type: 'string',
            selector: 'js-address-map-iframe-title'
        }
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
                globalApi: false,
                mapIframeTitle: this.props.attributes.mapIframeTitle
            };

            this.gridCheck = this.gridCheck.bind(this);
            this.mapCoordsShow = this.mapCoordsShow.bind(this);
            this.onChange = this.onChange.bind(this);
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
        onChange(attribute, value) {
            return (
                this.props.setAttributes(
                    { [attribute]: value }
                )
            )
        }
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { title, titleSmall, body, gridType, mapCoords, mapApi, mapIframeTitle } = attributes

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Content layout', 'idsk-toolkit')}>
                        <PanelRow>
                            <ToggleControl
                                className="js-address-grid-type"
                                checked={gridType}
                                label={gridType ? __('1/3 width', 'idsk-toolkit') : __('Entire width', 'idsk-toolkit')}
                                onChange={checked => setAttributes({ gridType: checked })}
                            />
                        </PanelRow>
                    </PanelBody>
                    <PanelBody title={__('Map coordinates', 'idsk-toolkit')}>
                        <TextControl
                            className="js-address-map-iframe-title"
                            label={__('Enter map iframe title', 'idsk-toolkit')}
                            value={mapIframeTitle}
                            onChange={value => setAttributes({ mapIframeTitle: value })}
                        />
                        <TextControl
                            className="js-address-map"
                            label={__('Enter place address', 'idsk-toolkit')}
                            value={mapCoords}
                            onChange={value => setAttributes({ mapCoords: value })}
                        />
                        {(!this.state.globalApi || this.state.globalApi == false) &&
                        <TextControl
                            className="js-address-map-api"
                            label={__('Enter API key for Google Maps', 'idsk-toolkit')}
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
                                className="govuk-heading-m"
                                key="editable"
                                tagName="h2"
                                placeholder={__('Main title', 'idsk-toolkit')}
                                value={title}
                                onChange={value => this.onChange('title', value)} />
                            <RichText
                                className="govuk-heading-s"
                                key="editable"
                                tagName="h3"
                                placeholder={__('Subtitle', 'idsk-toolkit')}
                                value={titleSmall}
                                onChange={value => this.onChange('titleSmall', value)} />
                            <RichText
                                className="govuk-body"
                                key="editable"
                                tagName="p"
                                multiline={true}
                                placeholder={__('Caption', 'idsk-toolkit')}
                                value={body}
                                onChange={value => this.onChange('body', value)} />
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