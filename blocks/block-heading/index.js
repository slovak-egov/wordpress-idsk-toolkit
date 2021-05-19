/**
 * BLOCK - heading
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    InspectorControls
} = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    RadioControl,
    TextControl,
    ToggleControl
} = wp.components;
const { __ } = wp.i18n;

registerBlockType('idsk/heading', {
    // built-in attributes
    title: __('Nadpis', 'idsk-toolkit'),
    description: __('Zobrazuje nadpis s titulkom.', 'idsk-toolkit'),
    icon: 'heading',
    category: 'idsk-components',
    keywords: [
        __('heading', 'idsk-toolkit'),
        __('nadpis', 'idsk-toolkit'),
        __('titulok', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        headingType: {
            option: '',
            default: 'h1',
            selector: 'js-heading-type'
        },
        headingClass: {
            option: '',
            default: 'xl',
            selector: 'js-heading-class'
        },
        headingText: {
            type: 'string',
            selector: 'js-heading-text'
        },
        isCaption: {
            type: 'boolean',
            selector: 'js-heading-caption',
            default: false
        },
        captionText: {
            type: 'string',
            selector: 'js-heading-caption-text'
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { headingType, headingClass, headingText, isCaption, captionText } = attributes;

        function getHeading() {
            return <RichText
                key="editable"
                className="js-heading-text"
                tagName="span"
                placeholder={__('Nadpis', 'idsk-toolkit')}
                value={headingText}
                onChange={value => setAttributes({ headingText: value })} />
        }

        function checkHeading(type) {
            switch(type) {
                case 'h2':
                    return <h2 class={"govuk-heading-"+headingClass}>{getHeading()}</h2>;
                case 'h3':
                    return <h3 class={"govuk-heading-"+headingClass}>{getHeading()}</h3>;
                case 'h4':
                    return <h4 class={"govuk-heading-"+headingClass}>{getHeading()}</h4>;
                case 'h5':
                    return <h5 class={"govuk-heading-"+headingClass}>{getHeading()}</h5>;
                case 'h6':
                    return <h6 class={"govuk-heading-"+headingClass}>{getHeading()}</h6>;
                default:
                    return <h1 class={"govuk-heading-"+headingClass}>{getHeading()}</h1>;

            }
        }

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Nastavenie nadpisu', 'idsk-toolkit')}>
                    <PanelRow>
                        <ToggleControl
                            className="js-heading-caption"
                            checked={isCaption}
                            label={__('Zobraziť titulok nad nadpisom', 'idsk-toolkit')}
                            onChange={checked => setAttributes({ isCaption: checked })}
                        />
                    </PanelRow>
                    <RadioControl
                        className="js-heading-type"
                        label={__('Úroveň nadpisu', 'idsk-toolkit')}
                        selected={ headingType }
                        options={ [
                            { 
                                label: __('(H1) Nadpis 1', 'idsk-toolkit'),
                                value: 'h1' 
                            },
                            { 
                                label: __('(H2) Nadpis 2', 'idsk-toolkit'),
                                value: 'h2' 
                            },
                            { 
                                label: __('(H3) Nadpis 3', 'idsk-toolkit'),
                                value: 'h3'
                            },
                            { 
                                label: __('(H4) Nadpis 4', 'idsk-toolkit'),
                                value: 'h4'
                            },
                            { 
                                label: __('(H5) Nadpis 5', 'idsk-toolkit'),
                                value: 'h5'
                            },
                            { 
                                label: __('(H6) Nadpis 6', 'idsk-toolkit'),
                                value: 'h6'
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { headingType: option } ) } }
                    />
                    <RadioControl
                        className="js-heading-class"
                        label={__('Štýl nadpisu', 'idsk-toolkit')}
                        selected={ headingClass }
                        options={ [
                            { 
                                label: __('(XL) 48 px Tučný nadpis', 'idsk-toolkit'),
                                value: 'xl' 
                            },
                            { 
                                label: __('(L) 36 px Tučný nadpis', 'idsk-toolkit'),
                                value: 'l' 
                            },
                            { 
                                label: __('(M) 24 px Tučný nadpis', 'idsk-toolkit'),
                                value: 'm'
                            },
                            { 
                                label: __('(S) 19 px Tučný nadpis', 'idsk-toolkit'),
                                value: 's'
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { headingClass: option } ) } }
                    />
                </PanelBody>
            </InspectorControls>

            {!!isCaption &&
                <span class={"govuk-caption-"+headingClass}>
                    <RichText
                        key="editable"
                        className="js-heading-caption-text"
                        tagName="span"
                        placeholder={__('Titulok', 'idsk-toolkit')}
                        value={captionText}
                        onChange={value => setAttributes({ captionText: value })} />
                </span>
            }
            {checkHeading(headingType)}
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
})