/**
 * BLOCK - tab
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

// Used to make item ids
import { nanoid } from "nanoid"
const { registerBlockType } = wp.blocks
const { InnerBlocks, InspectorControls } = wp.blockEditor
const { PanelBody, TextControl } = wp.components
const { Component } = wp.element
const { select } = wp.data
const { __ } = wp.i18n

registerBlockType('idsk/tab', {
    // built-in attributes
    title: __('Záložka', 'idsk-toolkit'),
    description: __('Zobrazuje záložku s vlastným obsahom.', 'idsk-toolkit'),
    icon: 'table-row-after',
    category: 'idsk-components',
    keywords: [
        __('záložky', 'idsk-toolkit'),
        __('taby', 'idsk-toolkit'),
    ],
    parent: [ 'idsk/tabs' ],

    // Custom attributes
    attributes: {
        heading: {
            type: 'string'
        },
        blockId: {
            type: 'string'
        },
        tabItem: {
            type: 'string'
        }
    },
     
    // The UI for the WordPress editor
    edit: class Tabs extends Component {
        constructor() {
            super(...arguments)
        }

        componentDidUpdate(prevProps, prevState) {
            if (prevProps.attributes.heading !== this.props.attributes.heading) {
                // Get direct parent block
                const parentBlocks = select( 'core/block-editor' ).getBlockParents(this.props.clientId)
                const parentClientId = parentBlocks[parentBlocks.length-1]
                const parentBlock = select( 'core/block-editor' ).getBlock( parentClientId );
                let parentHeadings = parentBlock.attributes.headings
                let parentBlockIds = parentBlock.attributes.blockIds
                let onPosition = parentBlockIds.length

                parentBlockIds.map((blockId, index) => {
                    if (blockId == this.props.attributes.blockId) {
                        onPosition = index
                        this.props.setAttributes({ tabItem: onPosition })
                    }
                })

                // update (not save) heading to parent on indexed position by id
                parentHeadings[onPosition] = this.props.attributes.heading
            }
        }
          
        render() {
            const { attributes, setAttributes, className } = this.props
            const { heading, blockId } = attributes;

            if (!blockId) {
                setAttributes( { blockId: nanoid() } )
            }

            return <div className={className}>
                <InspectorControls>
                    <PanelBody title={__('Názov záložky', 'idsk-toolkit')}>
                        <TextControl
                            label={__('Zadajte názov záložky', 'idsk-toolkit')}
                            value={heading}
                            onChange={value => setAttributes({heading: value})}
                        />
                    </PanelBody>
                </InspectorControls>

                <ul class="idsk-tabs__list">
                    <li class="idsk-tabs__list-item idsk-tabs__list-item--selected">
                        {heading}
                    </li>
                </ul>

                <ul class="idsk-tabs__list--mobile" role="tablist">
                    <li class="idsk-tabs__list-item--mobile" role="presentation">
                        <section class="idsk-tabs__panel">
                            <div class="idsk-tabs__panel-content">
                                <InnerBlocks />
                            </div>
                        </section>
                    </li>
                </ul>

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