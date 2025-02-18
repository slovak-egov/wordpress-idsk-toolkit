/**
 * GRID - row
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const { 
    InspectorControls, 
    InnerBlocks, 
    useBlockProps 
} = wp.blockEditor;
const {
    PanelBody,
    RadioControl
} = wp.components;
const { __ } = wp.i18n;
const ALLOWED_BLOCKS = [
    'idsk/column',
];

registerBlockType('idsk/row', {
    // built-in attributes
    title: __('Row', 'idsk-toolkit'),
    description: __('Inserts a row block in a page.', 'idsk-toolkit'),
    icon: 'welcome-add-page',
    category: 'idsk-grids',
    keywords: [
        __('row', 'idsk-toolkit'),
        __('grid', 'idsk-toolkit'),
        __('page', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        bgColor: {
            option: '',
            default: '',
            selector: 'js-row-color'
        },
        paddingTop: {
            option: '',
            default: '',
            selector: 'js-row-pt'
        },
        paddingBottom: {
            option: '',
            default: '',
            selector: 'js-row-pb'
        }
    },
     
     // The UI for the WordPress editor
    edit({ attributes, className, setAttributes }) {
        const { bgColor, paddingTop, paddingBottom } = attributes

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Row settings', 'idsk-toolkit')}>
                    <RadioControl
                        className="js-row-color"
                        label={__('Background color', 'idsk-toolkit')}
                        selected={ bgColor }
                        options={ [
                            { 
                                label: __('No background', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('Blue', 'idsk-toolkit'),
                                value: 'app-pane-blue' 
                            },
                            { 
                                label: __('Light grey', 'idsk-toolkit'),
                                value: 'app-pane-lgray'
                            },
                            { 
                                label: __('Grey', 'idsk-toolkit'),
                                value: 'app-pane-gray'
                            }
                        ] }
                        onChange={ ( option ) => { setAttributes( { bgColor: option } ) } }
                    />
                    <RadioControl
                        className="js-row-pt"
                        label={__('Top margin', 'idsk-toolkit')}
                        selected={ paddingTop }
                        options={ [
                            { 
                                label: __('No margin', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('0px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-0' 
                            },
                            { 
                                label: __('5px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-1' 
                            },
                            { 
                                label: __('10px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-2' 
                            },
                            { 
                                label: __('15px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-3' 
                            },
                            { 
                                label: __('20px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-4' 
                            },
                            { 
                                label: __('25px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-5' 
                            },
                            { 
                                label: __('30px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-6' 
                            },
                            { 
                                label: __('40px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-7' 
                            },
                            { 
                                label: __('50px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-8' 
                            },
                            { 
                                label: __('60px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-top-9' 
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { paddingTop: option } ) } }
                    />
                    <RadioControl
                        className="js-row-pb"
                        label={__('Margin bottom', 'idsk-toolkit')}
                        selected={ paddingBottom }
                        options={ [
                            { 
                                label: __('No margin', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('0px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-0' 
                            },
                            { 
                                label: __('5px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-1' 
                            },
                            { 
                                label: __('10px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-2' 
                            },
                            { 
                                label: __('15px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-3' 
                            },
                            { 
                                label: __('20px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-4' 
                            },
                            { 
                                label: __('25px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-5' 
                            },
                            { 
                                label: __('30px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-6' 
                            },
                            { 
                                label: __('40px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-7' 
                            },
                            { 
                                label: __('50px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-8' 
                            },
                            { 
                                label: __('60px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-bottom-9' 
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { paddingBottom: option } ) } }
                    />
                </PanelBody>
            </InspectorControls>

            <div class={"main-govuk-grid-row "+bgColor+" "+paddingTop+" "+paddingBottom}>
                <div { ...useBlockProps() }>
                    <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
                </div>
            </div>
        </div>;
    },

    // Save inserted content
    save({ attributes, className }) {
        return <div className={className}>
            <div class={"govuk-grid-row "+attributes.bgColor+" "+attributes.paddingTop+" "+attributes.paddingBottom}>
                <div { ...useBlockProps.save() }>
                    <InnerBlocks.Content />
                </div>
            </div>
        </div>;
    },
})