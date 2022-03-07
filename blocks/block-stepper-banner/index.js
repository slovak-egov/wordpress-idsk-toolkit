/**
 * BLOCK - stepper-banner
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

registerBlockType('idsk/stepper-banner', {
    // built-in attributes
    title: __('Stepper banner', 'idsk-toolkit'),
    description: __('Use the banner at the top of the page with specific content (after clicking on the link in the stepper) so that the user knows that this content is part of a give life event/manual.', 'idsk-toolkit'),
    icon: 'media-spreadsheet',
    category: 'idsk-components',
    keywords: [
        __('stepper', 'idsk-toolkit'),
        __('banner', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        textHeading: {
            type: 'string',
            selector: 'h2'
        },
        textBanner: {
            type: 'string',
            selector: 'h3'
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { textHeading, textBanner } = attributes;

        return <div className={className}>
            <div data-module="idsk-banner">
                <div class="idsk-banner" role="contentinfo">
                    <div class="govuk-container-width">
                        <div class="idsk-banner__content app-pane-grey">
                            <RichText
                                key="editable"
                                className="govuk-heading-s"
                                tagName="h2"
                                placeholder={__('e.g. Part of a life event', 'idsk-toolkit')}
                                value={textHeading}
                                onChange={newText => setAttributes({ textHeading: newText })} />
                            <RichText
                                key="editable"
                                className="govuk-heading-m"
                                tagName="h3"
                                placeholder={__('e.g. Birth of a child: step-by-step', 'idsk-toolkit')}
                                value={textBanner}
                                onChange={newText => setAttributes({ textBanner: newText })} />
                        </div>
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