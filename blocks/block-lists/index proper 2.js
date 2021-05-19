/**
 * BLOCK - lists
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

// based on https://github.com/WordPress/gutenberg/blob/trunk/packages/rich-text/src/

// Used to make item ids
import { nanoid } from 'nanoid'
const { registerBlockType } = wp.blocks; // the notation same as: import registerBlockType from wp.blocks;
const {
    RichText,
    RichTextShortcut,
    BlockControls,
    InnerBlocks,
    InspectorControls,
    useBlockProps
} = wp.blockEditor;
const {
    PanelBody,
    RadioControl,
    ToolbarButton
} = wp.components;
const { Component } = wp.element
const { __ } = wp.i18n;

const {
	__unstableCanIndentListItems,
	__unstableCanOutdentListItems,
	__unstableIndentListItems,
	__unstableOutdentListItems,
	__unstableChangeListType,
	__unstableIsListRootSelected,
	__unstableIsActiveListType,

    // LINE_SEPARATOR,
    // getLineIndex,
    // getParentLineIndex,

	applyFormat,
    toggleFormat
} = wp.richText;

import {
    format,
    list,
    alignJustify,
    textColor,
	formatListBullets,
	formatListNumbered,
	formatIndent,
	formatOutdent,
} from '@wordpress/icons';
// const {
//     format,
//     list,
// 	formatListBullets,
// 	formatListNumbered,
// 	textColor,
// 	formatIndent,
// 	formatOutdent,
// } = wp.icons;
// const ALLOWED_BLOCKS = [
//     'idsk/lists'
// ];

registerBlockType('idsk/lists', {
    // built-in attributes
    title: __('Zoznamy', 'idsk-toolkit'),
    description: __('Zobrazuje zoznamy s možnosťami.', 'idsk-toolkit'),
    icon: 'editor-ul',
    category: 'idsk-components',
    keywords: [
        __('zoznam', 'idsk-toolkit'),
        __('zoznamy', 'idsk-toolkit'),
    ],

    // custom attributes
    attributes: {
        // blockId: {
        //     type: 'string'
        // },
        // listType: {
        //     option: '',
        //     default: '',
        //     selector: 'js-lists-type'
        // },
        // // listItem: {
        // //     type: 'string',
        // //     selector: 'js-lists-item'
        // // },
        // items: {
        //     type: 'array'
        // }
        
		ordered: {
			type: "boolean",
			default: false
		},
		values: {
			type: "string",
			source: "html",
			selector: "ol,ul",
			multiline: "li",
            // class: "govuk-list ",
            // listClass: "",
			default: ""
		},
		type: {
			type: "string"
		},
        listClass: {
            type: "string",
            default: ""
        },
		// placeholder: {
		// 	type: "string"
		// }
    },

    // The UI for the WordPress editor
    edit: class Lists extends Component {
        
        // render() {
        //     return <div>som tu</div>
        // }
        
        
        constructor() {
            super(...arguments)

            // Match current state to saved quotes (if they exist)
            // this.state = {
            //     items: this.props.attributes.items || []
            // };

            // this.addItem = this.addItem.bind(this);
            // this.removeItem = this.removeItem.bind(this);
            // this.editItem = this.editItem.bind(this);
            this.changeListType = this.changeListType.bind(this);
            this.getLineIndex = this.getLineIndex.bind(this);
            this.getParentLineIndex = this.getParentLineIndex.bind(this);
        }

        changeClass(e) {
            console.log('som v class: ')
            console.log(e)
            console.log(e.closest('ul'))
        }
        getLineIndex( { start, text }, startIndex = start ) {
            let index = startIndex;
        
            while ( index-- ) {
                if ( text[ index ] === '\u2028' ) {
                    return index;
                }
            }
        }
        getParentLineIndex( { text, replacements }, lineIndex ) {
            const startFormats = replacements[ lineIndex ] || [];
        
            let index = lineIndex;
        // console.log(startFormats);
        // console.log(index);
            while ( index-- >= 0 ) {
                if ( text[ index ] !== '\u2028' ) {
        // console.log('continue parent');
                    continue;
                }
        // console.log('parent tu');
                const formatsAtIndex = replacements[ index ] || [];
        
                if ( formatsAtIndex.length === startFormats.length - 1 ) {
                    return index;
                }
            }
        }

        changeListType( value, newFormat ) {
            console.log(newFormat);
            // console.log('\u2028');
            // if (value[0] !== LINE_SEPARATOR) {
            //     console.log('nie');
            // }
            // else {
            //     console.log('ano');
            // }

            const { text, replacements, start, end } = value;
            const startingLineIndex = this.getLineIndex( value, start );
            const startLineFormats = replacements[ startingLineIndex ] || [];
            const endLineFormats = replacements[ this.getLineIndex( value, end ) ] || [];
            const startIndex = this.getParentLineIndex( value, startingLineIndex );
            const newReplacements = replacements.slice();
            const startCount = startLineFormats.length - 1;
            const endCount = endLineFormats.length - 1;
        
            let changed;
        // console.log(startIndex);
            for ( let index = startIndex + 1 || 0; index < text.length; index++ ) {
                if ( text[ index ] !== '\u2028' ) {
                    // console.log('if 1');
                    continue;
                }
        
                if ( ( newReplacements[ index ] || [] ).length <= startCount ) {
                    // console.log('if 2');
                    break;
                }
        
                if ( ! newReplacements[ index ] ) {
                    // console.log('if 3');
                    continue;
                }
        
            // console.log(newReplacements[index]);

                changed = true;
                // toggleFormat(newReplacements, { type: 'lists-formats/bullet' });
                newReplacements[ index ] = newReplacements[ index ].map(
                    ( format, i ) => {
                        console.log(format);
                // toggleFormat(format, { type: 'lists-formats/bullet' });
                // toggleFormat(newFormat, { type: 'lists-formats/bullet' });
                console.log(newFormat);
                        return i < startCount || i > endCount ? format : newFormat;
                    }
                );
                // console.log('som az tu');
            }
        
            if ( ! changed ) {
                // console.log('nic');
                return value;
            }
    
            // toggleFormat(newReplacements, { type: 'lists-formats/bullet' });
        
            return {
                ...value,
                replacements: newReplacements,
                // activeFormats: ['lists-formats/bullet']
                // className: 'govuk-list--button'
            };
        }

        // merge( attributes, attributesToMerge ) {
        //     const { values } = attributesToMerge;

        //     if ( ! values || values === '<li></li>' ) {
        //         return attributes;
        //     }

        //     return {
        //         ...attributes,
        //         values: attributes.values + values,
        //     };
        // }
/*
        getItems() {
            const items = this.state.items

            return <>
                {!!items && items.map((item, index) =>
                    <li id={item.id || index} key={item.id || index}>
                        <RichText
                            key="editable"
                            className="js-lists-item"
                            tagName="span"
                            multiline={false}
                            placeholder={__('Položka', 'idsk-toolkit')}
                            value={item.text}
                            onChange={value => this.editItem('text', index, value)} />
                        <br/>
                        <button
                            className="button button-secondary"
                            type="submit"
                            onClick={(e) => this.removeItem(e, index)}
                        >{__('Vymazať položku', 'idsk-toolkit')}</button>
                        <InnerBlocks key={item.id || index} allowedBlocks={ALLOWED_BLOCKS} orientation="horizontal" />
                    </li>
                )}

                <p>
                    <input
                        id={this.props.attributes.blockId}
                        className="button button-primary"
                        type="submit"
                        value={__('Pridať položku', 'idsk-toolkit')}
                        onClick={(e) => this.addItem(e)}
                    />
                </p>
            </>
        }

        checkType(type) {
            if (type.includes('number')) {
                return <ol id={this.props.attributes.blockId} class={"govuk-list " + type}>{this.getItems()}</ol>
            } else {
                return <ul id={this.props.attributes.blockId} class={"govuk-list " + type}>{this.getItems()}</ul>
            }
        }*/

        // adds empty placeholder for item
        // addItem(e) {
        //     e.preventDefault()

        //     // get items from state
        //     const { items } = this.state

        //     // set up empty item
        //     const emptyItem = {
        //         id: nanoid(),
        //         text: ''
        //     }

        //     // append new emptyItem object to items
        //     const newItems = [...items, emptyItem]

        //     // save new placeholder to WordPress
        //     this.props.setAttributes({ items: newItems })

        //     // and update state
        //     return this.setState({ items: newItems })
        // }

        // // remove item
        // removeItem(e, index) {
        //     e.preventDefault()

        //     // make a true copy of items
        //     // const { items } = this.state does not work
        //     const items = JSON.parse(JSON.stringify(this.state.items))

        //     // remove specified item
        //     items.splice(index, 1)

        //     // save updated items and update state (in callback)
        //     return (
        //         this.props.setAttributes(
        //             { items: items },
        //             this.setState({ items: items })
        //         )
        //     )
        // };

        // // handler function to update item
        // editItem(key, index, value) {
        //     // make a true copy of items
        //     const items = JSON.parse(JSON.stringify(this.state.items))
        //     if (items.length === 0) return

        //     // update value
        //     items[index][key] = value

        //     // save values in WordPress and update state (in callback)
        //     return (
        //         this.props.setAttributes(
        //             { items: items },
        //             this.setState({ items: items })
        //         )
        //     )
        // };
        
        render() {
            // Pull out the props we'll use
            const { attributes, className, setAttributes, mergeBlocks, onReplace, isSelected } = this.props

            // Pull out specific attributes for clarity below
            // const { blockId, listType } = attributes
            const { ordered, values, type, listClass } = attributes
            
            // if (!blockId) {
            //     this.props.setAttributes( { blockId: nanoid() } )
            // }

            const tagName = ordered ? 'ol' : 'ul';

            const controls = ( { value, onChange, onFocus } ) => (
                <BlockControls group="block">
                    <ToolbarButton
                        icon={ alignJustify }
                        title={ __( 'Bez odrážok', 'idsk-toolkit' ) }
                        describedBy={ __( 'Konvertovať na nečíslovaný zoznam bez odrážok', 'idsk-toolkit' ) }
                        isActive={ __unstableIsActiveListType( value, '', listClass ) }
                        onClick={ () => {
                            onChange( __unstableChangeListType( value, { type: 'ul' } ) );
                            // onChange( __unstableApplyFormat( listClass ) );
                            onFocus();
    
                            if ( __unstableIsListRootSelected( value ) ) {
                                setAttributes( { 
                                    ordered: false,
                                    // listClass: ''
                                } );
                                // setAttributes( { listClass: '' } );
                            }
                        } }
                    />
                    <ToolbarButton
                        icon={ formatListBullets }
                        title={ __( 'S guličkami', 'idsk-toolkit' ) }
                        describedBy={ __( 'Konvertovať na nečíslovaný zoznam s guličkami', 'idsk-toolkit' ) }
                        isActive={ __unstableIsActiveListType( value, 'govuk-list--bullet', listClass ) }
                        onClick={ () => {
                            // console.log(value)
                            // console.log(__unstableIsListRootSelected(value))
                            // console.log( wp.data.select( 'core/rich-text' ).getFormatTypes() );
                            console.log( this.changeListType( value, { type: 'ul' } ) );
                            onChange( this.changeListType( value, { type: 'ul' } ) );
                            // onChange( toggleFormat(value, { type: 'lists-formats/bullet' }) )
                            // this.changeClass(value);
                            // this.changeClass(e);
                            // toggleFormat(value, { type: 'lists-formats/bullet' });
                            // applyFormat(value, { type: 'lists-formats/bullet' });
                            // onChange( applyFormat(value, { className: 'govuk-list govuk-list--bullet' } ) );
                            // onChange( applyFormat( __unstableChangeListType( value, { type: 'ul' } ), { className: 'govuk-list govuk-list--bullet' } ) );
                            onFocus();
    
                            if ( __unstableIsListRootSelected( value ) ) {
                                setAttributes( { 
                                    ordered: false,
                                    // listClass: 'govuk-list--bullet'
                                } );
                                // setAttributes( { listClass: 'govuk-list--bullet' } );
                            }
                        } }
                    />
                    <ToolbarButton
                        icon={ formatListNumbered }
                        title={ __( 'Číslovaný', 'idsk-toolkit' ) }
                        describedBy={ __( 'Konvertovať na číslovaný zoznam s číslami', 'idsk-toolkit' ) }
                        // isActive={ __unstableIsActiveListType( value, 'ol', tagName ) }
                        isActive={ __unstableIsActiveListType( value, 'govuk-list--number', listClass ) }
                        onClick={ () => {
                            onChange( __unstableChangeListType( value, { type: 'ol', className: 'govuk-list--number' } ) );
                            onFocus();
    
                            if ( __unstableIsListRootSelected( value ) ) {
                                setAttributes( { 
                                    ordered: true,
                                    // listClass: 'govuk-list--number'
                                } );
                                // setAttributes( { listClass: 'govuk-list--number' } );
                            }
                        } }
                    />
                    {/* <ToolbarButton
                        icon={ textColor }
                        title={ __( 'S písmenami', 'idsk-toolkit' ) }
                        describedBy={ __( 'Konvertovať na číslovaný zoznam s písmenami', 'idsk-toolkit' ) }
                        isActive={ __unstableIsActiveListType( value, 'ol', tagName, listClass ) }
                        onClick={ () => {
                            onChange( __unstableChangeListType( value, { type: 'ol' }, listClass ) );
                            onFocus();

                            if ( __unstableIsListRootSelected( value ) ) {
                                setAttributes( { ordered: true } );
                                setAttributes( { listClass: 'govuk-list--alpha' } );
                            }
                        } }
                    /> */}
                    <ToolbarButton
                        icon={ formatOutdent }
                        title={ __( 'Outdent' ) }
                        describedBy={ __( 'Outdent list item' ) }
                        shortcut={ __( 'Backspace', 'keyboard key' ) }
                        isDisabled={ ! __unstableCanOutdentListItems( value ) }
                        onClick={ () => {
                            onChange( __unstableOutdentListItems( value ) );
                            onFocus();
                        } }
                    />
                    <ToolbarButton
                        icon={ formatIndent }
                        title={ __( 'Indent' ) }
                        describedBy={ __( 'Indent list item' ) }
                        shortcut={ __( 'Space', 'keyboard key' ) }
                        isDisabled={ ! __unstableCanIndentListItems( value ) }
                        onClick={ () => {
                            onChange( __unstableIndentListItems( value, { type: tagName, className: "govuk-list govuk-list--number" } ) );
                            onFocus();
                        } }
                    />
                </BlockControls>
            );
        
            // const blockProps = useBlockProps();

            return <div className={className}>
                <RichText
                    identifier="values"
                    multiline="li"
                    tagName={ tagName }
                    className={"govuk-list " + listClass}
                    onChange={ ( nextValues ) =>
                        setAttributes( { values: nextValues } )
                    }
                    value={ values }
                    aria-label={ __( 'List text' ) }
                    placeholder={ __( 'List' ) }
                    // onMerge={ mergeBlocks }
                    // onSplit={ ( value ) =>
                    //     createBlock( name, { ...attributes, values: value, listClass: listClass } )
                    // }
                    // __unstableOnSplitMiddle={ () =>
                    //     createBlock( 'core/paragraph' )
                    // }
                    // onReplace={ onReplace }
                    // onRemove={ () => onReplace( [] ) }
                    type={ type }
                    // listClass={listClass}
                    { ...useBlockProps }
                >
                    { controls }
                </RichText>
            </div>;

            // return <div id={blockId} className={className}>
            //     <InspectorControls key={blockId}>
            //         <PanelBody title={__('Nastavenie zoznamu', 'idsk-toolkit')}>
            //             <RadioControl
            //                 id={blockId}
            //                 className="js-lists-type"
            //                 label={__('Typ zoznamu', 'idsk-toolkit')}
            //                 selected={ listType }
            //                 options={ [
            //                     { 
            //                         label: __('Bez odrážok', 'idsk-toolkit'),
            //                         value: '' 
            //                     },
            //                     { 
            //                         label: __('Guličky', 'idsk-toolkit'),
            //                         value: 'govuk-list--bullet'
            //                     },
            //                     { 
            //                         label: __('Čísla', 'idsk-toolkit'),
            //                         value: 'govuk-list--number' 
            //                     },
            //                 ] }
            //                 onChange={ ( option ) => { setAttributes( { listType: option } ) } }
            //             />
            //         </PanelBody>
            //     </InspectorControls>
            //     <div id={blockId}>
            //         {this.checkType(listType)}
            //     </div>

            // </div>;
        }
    },
    save( { attributes } ) {
        const { ordered, values, type, listClass } = attributes;
        const TagName = ordered ? 'ol' : 'ul';
        // listClass = "govuk-list " + listClass;
    
        return (
            <TagName { ...useBlockProps.save( { type, className: "govuk-list "+attributes.listClass } ) }>
                <RichText.Content value={ values } multiline="li" />
            </TagName>
        );
    }











/*

    edit({ attributes, setAttributes, className }) {
        const { listType, listItem } = attributes;

        function getItems() {
            return <>            
                <RichText
                    key="editable"
                    className="js-lists-item"
                    tagName="div"
                    multiline="li"
                    placeholder={__('Položka', 'idsk-toolkit')}
                    value={listItem}
                    onChange={value => setAttributes({ listItem: value })} />
                <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} />
            </>
        }

        function checkType(type) {
            if (type.includes('number')) {
                return <ol class={"govuk-list " + type}>{getItems()}</ol>
            } else {
                return <ul class={"govuk-list " + type}>{getItems()}</ul>
            }
        }

        return <div className={className}>
            <InspectorControls>
                <PanelBody title={__('Nastavenie zoznamu', 'idsk-toolkit')}>
                    <RadioControl
                        className="js-lists-type"
                        label={__('Typ zoznamu', 'idsk-toolkit')}
                        selected={ listType }
                        options={ [
                            { 
                                label: __('Bez odrážok', 'idsk-toolkit'),
                                value: '' 
                            },
                            { 
                                label: __('Guličky', 'idsk-toolkit'),
                                value: 'govuk-list--bullet'
                            },
                            { 
                                label: __('Čísla', 'idsk-toolkit'),
                                value: 'govuk-list--number' 
                            },
                        ] }
                        onChange={ ( option ) => { setAttributes( { listType: option } ) } }
                    />
                </PanelBody>
            </InspectorControls>

            {checkType(listType)}
        </div>;
    },
*/
    // No save, dynamic block
    // save() {
    //     return null
    // },
})