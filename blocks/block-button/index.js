/**
 * BLOCK - button
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
    RadioControl,
    TextControl,
    ToggleControl
} = wp.components;
const { __ } = wp.i18n;

registerBlockType('idsk/button', {
    // built-in attributes
    title: __('Button', 'idsk-toolkit'),
    description: __('Shows button with a link.', 'idsk-toolkit'),
    icon: 'button',
    category: 'idsk-components',
    keywords: [
        __('button', 'idsk-toolkit'),
        __('link', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        href: {
            type: 'string',
            selector: 'js-button-href'
        },
        target: {
            type: 'boolean',
            selector: 'js-button-target',
            default: false
        },
        color: {
            option: '',
            default: '',
            selector: 'js-button-color'
        },
        arrow: {
            type: 'boolean',
            selector: 'js-button-arrow',
            default: false
        },
        text: {
            type: 'string',
            selector: 'js-button-text'
        },
    },

    // The UI for the WordPress editor
    edit({ attributes, setAttributes, className }) {
        const { href, target, color, arrow, text } = attributes;

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Button settings', 'idsk-toolkit')}>
                    <TextControl
                        className="js-button-href"
                        label={__('Button link', 'idsk-toolkit')}
                        value={href}
                        onChange={value => setAttributes({ href: value })}
                    />
                    <PanelRow>
                        <ToggleControl
                            className="js-button-target"
                            checked={target}
                            label={__('Open link in new window', 'idsk-toolkit')}
                            onChange={checked => setAttributes({ target: checked })}
                        />
                    </PanelRow>
                    <RadioControl
                        className="js-button-color"
                        label={__('Button color', 'idsk-toolkit')}
                        selected={ color }
                        options={ [
                            { 
                                label: __('Green', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('Grey', 'idsk-toolkit'),
                                value: 'govuk-button--secondary' 
                            },
                            { 
                                label: __('Red', 'idsk-toolkit'),
                                value: 'govuk-button--warning' 
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { color: option } ) } }
                    />
                    <PanelRow>
                        <ToggleControl
                            className="js-button-arrow"
                            checked={arrow}
                            label={__('Show arrow in button', 'idsk-toolkit')}
                            onChange={checked => setAttributes({ arrow: checked })}
                        />
                    </PanelRow>
                </PanelBody>
            </InspectorControls>

            <button type="submit" class={"govuk-button " + color + " " + (!!arrow && ' govuk-button--start')} data-module="govuk-button">
                <RichText
                    key="editable"
                    className="js-button-text"
                    tagName="span"
                    placeholder={__('Button text.', 'idsk-toolkit')}
                    value={text}
                    onChange={value => setAttributes({ text: value })} />
                {!!arrow &&
                    <svg class="govuk-button__start-icon" xmlns="http://www.w3.org/2000/svg" width="17.5" height="19" viewBox="0 0 33 40" role="presentation" focusable="false">
                        <path fill="currentColor" d="M0 0h13l20 20-20 20H0l20-20z"/>
                    </svg>
                }
            </button>
        </div>;
    },

    // No save, dynamic block
    save() {
        return null
    },
})