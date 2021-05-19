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
    title: __('Vsadený text', 'idsk-toolkit'),
    description: __('Pre upriamenie pozornosti na dôležitý obsah stránky je vhodné používať ohraničený vsadený text.', 'idsk-toolkit'),
    icon: 'align-pull-left',
    category: 'idsk-components',
    keywords: [
        __('text', 'idsk-toolkit'),
        __('vsadený', 'idsk-toolkit'),
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
                    placeholder={__('Vsadený text na doplnenie.', 'idsk-toolkit')}
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