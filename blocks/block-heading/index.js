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
    title: __('Heading', 'idsk-toolkit'),
    description: __('Shows heading with title.', 'idsk-toolkit'),
    icon: 'heading',
    category: 'idsk-components',
    keywords: [
        __('heading', 'idsk-toolkit'),
        __('title', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        anchor: { 
            type: 'string', 
            selector: 'js-heading-anchor', 
        },
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
        const { headingType, headingClass, headingText, isCaption, captionText, anchor } = attributes;

        function getHeading() {
            return <RichText
                key="editable"
                className="js-heading-text"
                tagName="span"
                placeholder={__('Heading', 'idsk-toolkit')}
                value={headingText}
                onChange={value => setAttributes({ headingText: value })} />
        }

        function checkHeading(type) {
            switch(type) {
                case 'h2':
                    return <h2 id={anchor} class={"govuk-heading-"+headingClass}>{getHeading()}</h2>;
                case 'h3':
                    return <h3 id={anchor} class={"govuk-heading-"+headingClass}>{getHeading()}</h3>;
                case 'h4':
                    return <h4 id={anchor} class={"govuk-heading-"+headingClass}>{getHeading()}</h4>;
                case 'h5':
                    return <h5 id={anchor} class={"govuk-heading-"+headingClass}>{getHeading()}</h5>;
                case 'h6':
                    return <h6 id={anchor} class={"govuk-heading-"+headingClass}>{getHeading()}</h6>;
                default:
                    return <h1 id={anchor} class={"govuk-heading-"+headingClass}>{getHeading()}</h1>;

            }
        }

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Heading settings', 'idsk-toolkit')}>
                    <PanelRow>
                        <ToggleControl
                            className="js-heading-caption"
                            checked={isCaption}
                            label={__('Display title above heading', 'idsk-toolkit')}
                            onChange={checked => setAttributes({ isCaption: checked })}
                        />
                    </PanelRow>
                    <RadioControl
                        className="js-heading-type"
                        label={__('Heading level', 'idsk-toolkit')}
                        selected={ headingType }
                        options={ [
                            { 
                                label: __('(H1) Heading 1', 'idsk-toolkit'),
                                value: 'h1' 
                            },
                            { 
                                label: __('(H2) Heading 2', 'idsk-toolkit'),
                                value: 'h2' 
                            },
                            { 
                                label: __('(H3) Heading 3', 'idsk-toolkit'),
                                value: 'h3'
                            },
                            { 
                                label: __('(H4) Heading 4', 'idsk-toolkit'),
                                value: 'h4'
                            },
                            { 
                                label: __('(H5) Heading 5', 'idsk-toolkit'),
                                value: 'h5'
                            },
                            { 
                                label: __('(H6) Heading 6', 'idsk-toolkit'),
                                value: 'h6'
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { headingType: option } ) } }
                    />
                    <RadioControl
                        className="js-heading-class"
                        label={__('Heading style', 'idsk-toolkit')}
                        selected={ headingClass }
                        options={ [
                            { 
                                label: __('(XL) 48 px Bold heading', 'idsk-toolkit'),
                                value: 'xl' 
                            },
                            { 
                                label: __('(L) 36 px Bold heading', 'idsk-toolkit'),
                                value: 'l' 
                            },
                            { 
                                label: __('(M) 24 px Bold heading', 'idsk-toolkit'),
                                value: 'm'
                            },
                            { 
                                label: __('(S) 19 px Bold heading', 'idsk-toolkit'),
                                value: 's'
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { headingClass: option } ) } }
                    />
                    <TextControl
                        className="js-heading-anchor"
                        key="editable"
                        label={__('HTML anchor', 'idsk-toolkit')}
                        help={__('Enter a word or two, no spaces, and create a unique web address just for this block, called an "anchor". Then you will be able to link directly to this part of your page.', 'idsk-toolkit')}
                        value={anchor}
                        onChange={value => setAttributes({ anchor: value })} 
                    />
                </PanelBody>
            </InspectorControls>

            {!!isCaption &&
                <span class={"govuk-caption-"+headingClass}>
                    <RichText
                        key="editable"
                        className="js-heading-caption-text"
                        tagName="span"
                        placeholder={__('Title', 'idsk-toolkit')}
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