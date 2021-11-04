/**
 * BLOCK - tabs
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

// Used to make item ids
const { registerBlockType } = wp.blocks
const { InnerBlocks, InspectorControls } = wp.blockEditor
const { PanelBody, TextControl } = wp.components
const { Component } = wp.element
const { select } = wp.data
const { __ } = wp.i18n
const ALLOWED_BLOCKS = [
    'idsk/tab',
];


registerBlockType('idsk/tabs', {
    // built-in attributes
    title: __('Záložky', 'idsk-toolkit'),
    description: __('Zobrazuje záložky s vlastným obsahom.', 'idsk-toolkit'),
    icon: 'table-row-after',
    category: 'idsk-components',
    keywords: [
        __('záložky', 'idsk-toolkit'),
        __('taby', 'idsk-toolkit'),
    ],

    // Custom attributes
    attributes: {
        heading: {
            type: 'string',
            default: ''
        },
        headings: {
            type: 'array',
            default: []
        },
        blockIds: {
            type: 'array',
            default: []
        }
    },
    
    // The UI for the WordPress editor
    edit: class Tabs extends Component {
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            this.state = {
                headings: this.props.attributes.headings || [],
                blockIds: this.props.attributes.blockIds || []
            };
        }

        componentDidUpdate(prevProps, prevState) {
            var myID = this.props.clientId;
            var tabs_title = [];
            var tabs_ids = [];
            this.myBlock = select('core/block-editor').getBlock(myID);
            this.myBlock.innerBlocks.map(block => {
                tabs_title.push( block.attributes.heading );
                tabs_ids.push( block.attributes.blockId )
            });
            // update changed headings
            if (!lodash.isEqual(prevProps.attributes.headings, tabs_title)) {
                this.props.setAttributes({ headings: tabs_title });
            }
            // save block ids
            if (!lodash.isEqual(prevProps.attributes.blockIds, tabs_ids)) {
                this.props.setAttributes({ blockIds: tabs_ids });
            }
        }

        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes } = this.props

            // Pull out specific attributes for clarity below
            const { heading, headings } = attributes

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Názov komponentu záložky', 'idsk-toolkit')}>
                        <TextControl
                            label={__('Zadajte názov komponentu so záložkami', 'idsk-toolkit')}
                            value={heading}
                            onChange={value => setAttributes({ heading: value })}
                        />
                    </PanelBody>
                    <PanelBody title={__('Zoznam záložiek', 'idsk-toolkit')}>
                        {!!headings && headings.map(heading => 
                            <p>{heading}</p>
                        )}
                    </PanelBody>
                </InspectorControls>

                <div class="idsk-tabs" data-module="idsk-tabs">
                    <h2 class="idsk-tabs__title">{heading}</h2>
                    <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
                </div>
            </div>;
        }
    },

    // Save inserted content
    save: props => {
        return (
            <InnerBlocks.Content />
        )
    }
    
})