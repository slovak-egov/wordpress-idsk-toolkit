/**
 * GRID - column full
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const { registerBlockType, registerBlockStyle } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
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

// registering custom styles for block
registerBlockStyle('idsk/column', {
    name: 'full',
    label: __('Stĺpec - 1/1', 'idsk-toolkit'),
    isDefault: true
});
registerBlockStyle('idsk/column', {
    name: 'one-half',
    label: __('Stĺpec - 1/2', 'idsk-toolkit'),
    isDefault: false
});
registerBlockStyle('idsk/column', {
    name: 'one-quarter',
    label: __('Stĺpec - 1/4', 'idsk-toolkit'),
    isDefault: false
});
registerBlockStyle('idsk/column', {
    name: 'one-third',
    label: __('Stĺpec - 1/3', 'idsk-toolkit'),
    isDefault: false
});
registerBlockStyle('idsk/column', {
    name: 'three-quarters',
    label: __('Stĺpec - 3/4', 'idsk-toolkit'),
    isDefault: false
});
registerBlockStyle('idsk/column', {
    name: 'two-thirds',
    label: __('Stĺpec - 2/3', 'idsk-toolkit'),
    isDefault: false
});

registerBlockType('idsk/column', {
    // built-in attributes
    title: __('Stĺpec', 'idsk-toolkit'),
    description: __('Vloží stĺpec v plnej šírke.', 'idsk-toolkit'),
    icon: 'columns',
    category: 'idsk-grids',
    keywords: [
        __('stĺpec', 'idsk-toolkit'),
        __('stránka', 'idsk-toolkit'),
    ],
    parent: [ 'idsk/row' ],
    
    // custom attributes
    attributes: {
        classShort: {
            type: 'string'
        },
        bgColor: {
            option: '',
            default: '',
            selector: 'js-column-color'
        },
        paddingTop: {
            option: '',
            default: '',
            selector: 'js-column-pt'
        },
        paddingBottom: {
            option: '',
            default: '',
            selector: 'js-column-pb'
        },
        paddingLeft: {
            option: '',
            default: '',
            selector: 'js-column-pl'
        },
        paddingRight: {
            option: '',
            default: '',
            selector: 'js-column-pr'
        }
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { classShort, bgColor, paddingTop, paddingBottom, paddingLeft, paddingRight } = attributes;
        let getClass = 'full';
        
        if (className.includes('is-style')) {
            getClass =  className.replace('wp-block-idsk-column is-style-','');
        } else {
            className += ' is-style-full';
        }
        setAttributes({ classShort: getClass });

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Nastavenie stĺpca', 'idsk-toolkit')}>
                    <RadioControl
                        className="js-column-color"
                        label={__('Farba pozadia', 'idsk-toolkit')}
                        selected={ bgColor }
                        options={ [
                            { 
                                label: __('Bez pozadia', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('Modré', 'idsk-toolkit'),
                                value: 'app-pane-blue' 
                            },
                            { 
                                label: __('Svetlo šedé', 'idsk-toolkit'),
                                value: 'app-pane-lgray'
                            },
                            { 
                                label: __('Šedé', 'idsk-toolkit'),
                                value: 'app-pane-gray'
                            }
                        ] }
                        onChange={ ( option ) => { setAttributes( { bgColor: option } ) } }
                    />
                    <RadioControl
                        className="js-column-pt"
                        label={__('Odsadenie zhora', 'idsk-toolkit')}
                        selected={ paddingTop }
                        options={ [
                            { 
                                label: __('Bez odsadenia', 'idsk-toolkit'),
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
                        className="js-column-pb"
                        label={__('Odsadenie zdola', 'idsk-toolkit')}
                        selected={ paddingBottom }
                        options={ [
                            { 
                                label: __('Bez odsadenia', 'idsk-toolkit'),
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
                    <RadioControl
                        className="js-column-pl"
                        label={__('Odsadenie zľava', 'idsk-toolkit')}
                        selected={ paddingLeft }
                        options={ [
                            { 
                                label: __('Bez odsadenia', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('0px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-0' 
                            },
                            { 
                                label: __('5px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-1' 
                            },
                            { 
                                label: __('10px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-2' 
                            },
                            { 
                                label: __('15px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-3' 
                            },
                            { 
                                label: __('20px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-4' 
                            },
                            { 
                                label: __('25px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-5' 
                            },
                            { 
                                label: __('30px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-6' 
                            },
                            { 
                                label: __('40px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-7' 
                            },
                            { 
                                label: __('50px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-8' 
                            },
                            { 
                                label: __('60px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-left-9' 
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { paddingLeft: option } ) } }
                    />
                    <RadioControl
                        className="js-column-pr"
                        label={__('Odsadenie zprava', 'idsk-toolkit')}
                        selected={ paddingRight }
                        options={ [
                            { 
                                label: __('Bez odsadenia', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('0px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-0' 
                            },
                            { 
                                label: __('5px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-1' 
                            },
                            { 
                                label: __('10px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-2' 
                            },
                            { 
                                label: __('15px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-3' 
                            },
                            { 
                                label: __('20px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-4' 
                            },
                            { 
                                label: __('25px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-5' 
                            },
                            { 
                                label: __('30px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-6' 
                            },
                            { 
                                label: __('40px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-7' 
                            },
                            { 
                                label: __('50px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-8' 
                            },
                            { 
                                label: __('60px', 'idsk-toolkit'),
                                value: 'govuk-!-padding-right-9' 
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { paddingRight: option } ) } }
                    />
                </PanelBody>
            </InspectorControls>

            <div class={"main-govuk-grid-column-"+classShort+" "+bgColor+" "+paddingTop+" "+paddingBottom+" "+paddingLeft+" "+paddingRight}>
                <div { ...useBlockProps() }>
                    <InnerBlocks />
                </div>
            </div>
        </div>;
    },
    
    // Save inserted content
    save({ attributes, className }) {
        return <div className={className}>
            <div class={"govuk-grid-column-"+attributes.classShort}>
                <div { ...useBlockProps.save() } className={attributes.bgColor+" "+attributes.paddingTop+" "+attributes.paddingBottom+" "+attributes.paddingLeft+" "+attributes.paddingRight}>
                    <InnerBlocks.Content />
                </div>
            </div>
        </div>;
    },
})