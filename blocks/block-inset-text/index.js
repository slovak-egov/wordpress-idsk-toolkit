/**
 * BLOCK - inset-text
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const { RichText } = wp.blockEditor;
const { __ } = wp.i18n;

registerBlockType('idsk/inset-text', {
    // built-in attributes
    title: __('Inset text', 'idsk-toolkit'),
    description: __('To draw attention to important content on the page, it is good to use bordered inset text.', 'idsk-toolkit'),
    icon: 'align-pull-left',
    category: 'idsk-components',
    keywords: [
        __('text', 'idsk-toolkit'),
        __('inset', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        text: {
            type: 'string',
            selector: 'js-inset-text'
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { text } = attributes;

        return <div className={className}>
            <div class="govuk-inset-text">
                <RichText
                    key="editable"
                    className="js-inset-text"
                    tagName="span"
                    placeholder={__('Inset text to be added.', 'idsk-toolkit')}
                    value={text}
                    onChange={value => setAttributes({ text: value })} />
            </div>
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
})