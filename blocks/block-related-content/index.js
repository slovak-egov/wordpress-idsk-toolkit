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
    InnerBlocks
} = wp.blockEditor;
const { __ } = wp.i18n;
const ALLOWED_BLOCKS = [
    'core/html',
    'core/paragraph',
    'core/spacer',
    'idsk/separator',
    'core/shortcode',
    'core/freeform',
];

registerBlockType('idsk/related-content', {
    // built-in attributes
    title: __('Related content', 'idsk-toolkit'),
    description: __('Related content serves to show the user links to similar, related topics.', 'idsk-toolkit'),
    icon: 'admin-links',
    category: 'idsk-components',
    keywords: [
        __('related', 'idsk-toolkit'),
        __('content', 'idsk-toolkit'),
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
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const {
            title,
            body
        } = attributes;

        // custom functions
        function onChange(attribute, value) {
            setAttributes({ [attribute]: value })
        }

        return <div className={className}>
            <div class="idsk-related-content" data-module="idsk-related-content">
                <hr class="idsk-related-content__line" aria-hidden="true" />
                <RichText
                    className="idsk-related-content__heading govuk-heading-s"
                    key="editable"
                    tagName="h4"
                    placeholder={__('Related topics', 'idsk-toolkit')}
                    value={title}
                    onChange={value => onChange('title', value)} />
                <RichText
                    className="idsk-related-content__list govuk-list"
                    key="editable"
                    tagName="ul"
                    multiline="li"
                    placeholder={__('Related topic 1', 'idsk-toolkit')}
                    value={body}
                    onChange={value => onChange('body', value)} />
                <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
            </div>
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
});