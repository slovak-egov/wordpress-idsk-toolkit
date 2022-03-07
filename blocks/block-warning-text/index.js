/**
 * BLOCK - warning-text
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

registerBlockType('idsk/warning-text', {
    // built-in attributes
    title: __('Information bar / Warning bar', 'idsk-toolkit'),
    description: __('Use this bar when you want to highlight or draw attention to something. Two types of bar are available.', 'idsk-toolkit'),
    icon: 'warning',
    category: 'idsk-components',
    keywords: [
        __('bar', 'idsk-toolkit'),
        __('information', 'idsk-toolkit'),
        __('warning', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        text: {
            type: 'string',
            selector: 'p'
        },
        textType: {
            type: 'boolean',
            selector: 'js-warning-text-type'
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const {
            text,
            textType
        } = attributes;

        return <div className={className}>
            <div class="govuk-clearfix"></div>
            <div class={textType ? "idsk-warning-text idsk-warning-text--info" : "idsk-warning-text"}>
                <div class="govuk-width-container">
                    <div class="idsk-warning-text__text">
                        <InspectorControls>
                            <PanelBody title={__('Type of bar', 'idsk-toolkit')}>
                                <PanelRow>
                                    <ToggleControl
                                        className="js-related-content-grid-type"
                                        checked={textType}
                                        label={textType ? __('Information bar', 'idsk-toolkit') : __('Warning bar', 'idsk-toolkit')}
                                        onChange={checked => setAttributes({ textType: checked })}
                                    />
                                </PanelRow>
                            </PanelBody>
                        </InspectorControls>
                        <RichText
                            key="editable"
                            tagName="span"
                            placeholder={__('e.g. new content on the page, new decree, strategy, etc.', 'idsk-toolkit')}
                            value={text}
                            onChange={newText => setAttributes({ text: newText })} />
                    </div>
                </div>
            </div>
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
})