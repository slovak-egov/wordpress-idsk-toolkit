/**
 * BLOCK - separator
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.5.0
 */

const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const { InspectorControls } = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    RadioControl,
    ToggleControl
} = wp.components;
const { __ } = wp.i18n;

registerBlockType('idsk/separator', {
    // built-in attributes
    title: __('Separator', 'idsk-toolkit'),
    description: __('Use the separator when you want to visually separate different parts of content on the page.', 'idsk-toolkit'),
    icon: 'minus',
    category: 'idsk-components',
    keywords: [
        __('separator', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        separatorType: {
            type: 'boolean',
            selector: 'js-separator-type'
        },
        marginBottom: {
            option: '',
            default: 'govuk-!-margin-bottom-6',
            selector: 'js-separator-mb'
        }
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { separatorType, marginBottom } = attributes;

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Separator settings', 'idsk-toolkit')}>
                    <PanelRow>
                        <ToggleControl
                            className="js-separator-type"
                            checked={separatorType}
                            label={separatorType ? __('Hidden on mobile devices', 'idsk-toolkit') : __('Always visible', 'idsk-toolkit')}
                            onChange={checked => setAttributes({ separatorType: checked })}
                        />
                    </PanelRow>
                    <RadioControl
                        className="js-separator-mb"
                        label={__('Margin bottom', 'idsk-toolkit')}
                        selected={ marginBottom }
                        options={ [
                            { 
                                label: __('0px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-0' 
                            },
                            { 
                                label: __('5px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-1' 
                            },
                            { 
                                label: __('10px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-2' 
                            },
                            { 
                                label: __('15px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-3' 
                            },
                            { 
                                label: __('20px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-4' 
                            },
                            { 
                                label: __('25px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-5' 
                            },
                            { 
                                label: __('30px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-6' 
                            },
                            { 
                                label: __('40px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-7' 
                            },
                            { 
                                label: __('50px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-8' 
                            },
                            { 
                                label: __('60px', 'idsk-toolkit'),
                                value: 'govuk-!-margin-bottom-9' 
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { marginBottom: option } ) } }
                    />
                </PanelBody>
            </InspectorControls>
            <hr className={(separatorType ? "idsk-hr-separator-until-tablet" : "idsk-hr-separator") +" "+ marginBottom} />
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
})