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
    title: __('Súvisiaci obsah', 'idsk'),
    description: __('Súvisiaci obsah slúži na to, aby ste používateľovi zobrazili odkazy na podobné, súvisiace témy.', 'idsk'),
    icon: 'admin-links',
    category: 'idsk-components',
    keywords: [
        __('Súvisiaci', 'idsk'),
        __('obsah', 'idsk'),
        __('related', 'idsk'),
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
        function onChangeTitle(newTitle) {
            setAttributes({ title: newTitle });
        }

        function onChangeBody(newBody) {
            setAttributes({ body: newBody });
        }

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Rozloženie obsahu')}>
                    <PanelRow>
                        <ToggleControl
                            className="js-related-content-grid-type"
                            checked={gridType}
                            label={gridType ? "rozloženie 2/3 obsahu" : "rozloženie 1/3 obsahu"}
                            onChange={checked => setAttributes({ gridType: checked })}
                        />
                    </PanelRow>
                </PanelBody>
            </InspectorControls>

            <div>
                {/* TODO: nejak premysliet toto tu.. */}
                {/* <div class={gridType ? 'govuk-grid-column-two-thirds' : 'govuk-grid-column-one-third'}> */}
                <div class="idsk-related-content" data-module="idsk-related-content">
                    <hr class="idsk-related-content__line" aria-hidden="true" />
                    <RichText
                        class="idsk-related-content__heading govuk-heading-s"
                        key="editable"
                        tagName="h4"
                        placeholder={__('Súvisiace témy (⅔)', 'idsk')}
                        value={title}
                        onChange={onChangeTitle} />
                    <RichText
                        class="idsk-related-content__list govuk-list"
                        key="editable"
                        tagName="ul"
                        multiline="li"
                        placeholder="Súvisiaca téma č. 1"
                        value={body}
                        onChange={onChangeBody} />
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