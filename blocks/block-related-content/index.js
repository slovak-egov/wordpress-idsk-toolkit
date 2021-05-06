/**
 * BLOCK - related-content
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const { registerBlockType } = wp.blocks; // the same notation as: import registerBlockType from wp.blocks;
const {
    RichText,
    InnerBlocks,
    InspectorControls
} = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    ToggleControl
} = wp.components;
const { __ } = wp.i18n;
const ALLOWED_BLOCKS = [
    'core/html',
    'core/paragraph',
    'core/spacer',
    'core/separator',
    'core/shortcode',
    'core/freeform',
];

registerBlockType('idsk/related-content', {
    // built-in attributes
    title: __('Súvisiaci obsah', 'idsk-toolkit'),
    description: __('Súvisiaci obsah slúži na to, aby ste používateľovi zobrazili odkazy na podobné, súvisiace témy.', 'idsk-toolkit'),
    icon: 'admin-links',
    category: 'idsk-components',
    keywords: [
        __('Súvisiaci', 'idsk-toolkit'),
        __('obsah', 'idsk-toolkit'),
        __('related', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        title: {
            type: 'string',
            selector: 'h4'
        },
        body: {
            type: 'string',
            selector: 'idsk-related-content__list'
        },
        gridType: {
            type: 'boolean',
            selector: 'js-related-content-grid-type',
            default: true
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const {
            title,
            body,
            gridType
        } = attributes;

        // custom functions
        function onChange(attribute, value) {
            setAttributes({ [attribute]: value })
        }

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Rozloženie obsahu', 'idsk-toolkit')}>
                    <PanelRow>
                        <ToggleControl
                            className="js-related-content-grid-type"
                            checked={gridType}
                            label={gridType ? __('rozloženie 2/3 obsahu', 'idsk-toolkit') : __('rozloženie 1/3 obsahu', 'idsk-toolkit')}
                            onChange={checked => setAttributes({ gridType: checked })}
                        />
                    </PanelRow>
                </PanelBody>
            </InspectorControls>

            <div class="govuk-grid-row">
                {/* TODO: nejak premysliet toto tu.. */}
                {/* <div class={gridType ? 'govuk-grid-column-two-thirds' : 'govuk-grid-column-one-third'}> */}
                <div class="idsk-related-content" data-module="idsk-related-content">
                    <hr class="idsk-related-content__line" aria-hidden="true" />
                    <RichText
                        className="idsk-related-content__heading govuk-heading-s"
                        key="editable"
                        tagName="h4"
                        placeholder={__('Súvisiace témy (⅔)', 'idsk-toolkit')}
                        value={title}
                        onChange={value => onChange('title', value)} />
                    <RichText
                        className="idsk-related-content__list govuk-list"
                        key="editable"
                        tagName="ul"
                        multiline="li"
                        placeholder={__('Súvisiaca téma č. 1', 'idsk-toolkit')}
                        value={body}
                        onChange={value => onChange('body', value)} />
                    <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
                </div>
            </div>
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
});