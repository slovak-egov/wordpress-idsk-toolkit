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
const { InnerBlocks, useBlockProps } = wp.blockEditor;
const { __ } = wp.i18n;
const ALLOWED_BLOCKS = [
    'idsk/column',
];

registerBlockType('idsk/row', {
    // built-in attributes
    title: __('Riadok', 'idsk-toolkit'),
    description: __('Vloží blok riadku na stránku.', 'idsk-toolkit'),
    icon: 'welcome-add-page',
    category: 'idsk-grids',
    keywords: [
        __('row', 'idsk-toolkit'),
        __('riadok', 'idsk-toolkit'),
        __('stránka', 'idsk-toolkit'),
    ],
     
     // The UI for the WordPress editor
    edit({ className }) {
        return <div className={className}>
            <div class="main-govuk-grid-row">
                <div { ...useBlockProps() }>
                    <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
                </div>
            </div>
        </div>;
    },

    // Save inserted content
    save({ className }) {
        return <div className={className}>
            <div class="govuk-grid-row">
                <div { ...useBlockProps.save() }>
                    <InnerBlocks.Content />
                </div>
            </div>
        </div>;
    },
})