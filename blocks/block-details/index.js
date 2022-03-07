/**
 * BLOCK - details
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

registerBlockType('idsk/details', {
    // built-in attributes
    title: __('Hidden text', 'idsk-toolkit'),
    description: __('Shows hidden text to be expanded.', 'idsk-toolkit'),
    icon: 'arrow-right',
    category: 'idsk-components',
    keywords: [
        __('text', 'idsk-toolkit'),
        __('hidden', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        summary: {
            type: 'string',
            selector: 'govuk-details__summary-text'
        },
        details: {
            type: 'string',
            selector: 'js-details-details'
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { summary, details } = attributes;

        return <div className={className}>
            <details class="govuk-details" data-module="govuk-details" open>
                <summary class="govuk-details__summary">
                    <RichText
                        key="editable"
                        className="govuk-details__summary-text"
                        tagName="span"
                        placeholder={__('Summary caption', 'idsk-toolkit')}
                        value={summary}
                        onChange={value => setAttributes({ summary: value })} />
                </summary>
                <div class="govuk-details__text">
                    <RichText
                        key="editable"
                        className="js-details-details"
                        tagName="p"
                        placeholder={__('Content', 'idsk-toolkit')}
                        value={details}
                        onChange={value => setAttributes({ details: value })} />
                </div>
            </details>
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
})