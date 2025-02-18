/**
 * BLOCK - announce
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    InspectorControls
} = wp.blockEditor;
const {
    PanelBody,
    PanelRow,
    ToggleControl
} = wp.components;
const { __ } = wp.i18n;

registerBlockType('idsk/announce', {
    // built-in attributes
    title: __('Announcement', 'idsk-toolkit'),
    description: __('Shows announcement with warning.', 'idsk-toolkit'),
    icon: 'megaphone',
    category: 'idsk-components',
    keywords: [
        __('announce', 'idsk-toolkit'),
        __('warning', 'idsk-toolkit'),
        __('text', 'idsk-toolkit'),
        __('announcement', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        text: {
            type: 'string',
            selector: 'strong'
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { text } = attributes;

        return <div className={className}>
            <div class="govuk-warning-text">
                <span class="govuk-warning-text__icon" aria-hidden="true">!</span>
                <RichText
                    key="editable"
                    className="govuk-warning-text__text"
                    tagName="strong"
                    placeholder={__('e.g. You may be fined if you fail to register.', 'idsk-toolkit')}
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