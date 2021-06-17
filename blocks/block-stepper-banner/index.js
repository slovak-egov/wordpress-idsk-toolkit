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
    description: __('Banner použite na začiatku stránky s konkrétnym obsahom (po kliknutí na odkaz v stepperi), aby používateľ vedel, že tento obsah patrí pod danú životnú situáciu/návod.', 'idsk-toolkit'),
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
                                placeholder={__('napr. Súčasť životnej situácie', 'idsk-toolkit')}
                                value={textHeading}
                                onChange={newText => setAttributes({ textHeading: newText })} />
                            <RichText
                                key="editable"
                                className="govuk-heading-m"
                                tagName="h3"
                                placeholder={__('napr. Narodenie dieťaťa: krok za krokom', 'idsk-toolkit')}
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