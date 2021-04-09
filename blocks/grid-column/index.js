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
const { InnerBlocks, useBlockProps } = wp.blockEditor;
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
        }
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { classShort } = attributes;
        let getClass = 'full';
        
        if (className.includes('is-style')) {
            getClass =  className.replace('wp-block-idsk-column is-style-','');
        } else {
            className += ' is-style-full';
        }
        setAttributes({ classShort: getClass });

        return <div className={className}>
            <div class={"main-govuk-grid-column-" + classShort}>
                <div { ...useBlockProps() }>
                    <InnerBlocks />
                </div>
            </div>
        </div>;
    },
    
    // Save inserted content
    save({ attributes, className }) {
        return <div className={className}>
            <div class={"govuk-grid-column-" + attributes.classShort}>
                <div { ...useBlockProps.save() }>
                    <InnerBlocks.Content />
                </div>
            </div>
        </div>;
    },
})