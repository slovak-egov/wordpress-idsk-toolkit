/**
 * BLOCK - table component.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.7
 */

// Used to make item ids.
import { nanoid } from 'nanoid'
import {
	alignLeft,
	alignRight,
	tableColumnAfter,
	tableColumnBefore,
	tableColumnDelete,
	tableRowAfter,
	tableRowBefore,
	tableRowDelete,
	table
} from '@wordpress/icons';
const { registerBlockType } = wp.blocks; // The notation same as: import registerBlockType from wp.blocks;
const {
	AlignmentControl,
	BlockControls,
	InspectorControls,
	RichText
} = wp.blockEditor;
const {
	Button,
	PanelBody,
	Placeholder,
	TextControl,
	ToggleControl,
	ToolbarDropdownMenu
} = wp.components;
const { Component } = wp.element;
const { __ } = wp.i18n;
const ALIGNMENT_CONTROLS = [
	{
		icon: alignLeft,
		title: __( 'Align column left', 'idsk-toolkit' ),
		align: 'left',
	},
	{
		icon: alignRight,
		title: __( 'Align column right', 'idsk-toolkit' ),
		align: 'right',
	},
];

registerBlockType('idsk/table', {
	// Built-in attributes.
	title: __( 'Table', 'idsk-toolkit' ),
	description: __( 'Shows table with options.', 'idsk-toolkit' ),
	icon: 'editor-table',
	category: 'idsk-components',
	keywords: [
		__( 'Table', 'idsk-toolkit' ),
	],

	// Custom attributes.
	attributes: {
		blockId: {
			type: 'string'
		},
		withHeading: {
			type: 'boolean',
			selector: 'js-table-heading',
			default: false
		},
		allowPrint: {
			type: 'boolean',
			selector: 'js-table-allow-print',
			default: false
		},
		defaultRows: {
			type: 'number',
			default: 2
		},
		defaultCols: {
			type: 'number',
			default: 2
		},
		tabHead: {
			type: 'array'
		},
		tabBody: {
			type: 'array'
		},
		sourceLink: {
			type: 'string',
			selector: 'js-table-source-link'
		},
	},

	// The UI for the WordPress editor.
	edit: class Table extends Component {
		constructor() {
			super(...arguments)

			// Match current state to saved quotes (if they exist).
			this.state = {
				withHeading: this.props.attributes.withHeading || false,
				allowPrint: this.props.attributes.allowPrint || false,
				defaultCols: this.props.attributes.defaultCols || 2,
				defaultRows: this.props.attributes.defaultRows || 2,
				tabHead: this.props.attributes.tabHead || [],
				tabBody: this.props.attributes.tabBody || [],
				sourceLink: this.props.attributes.sourceLink || '',
				selectedCell: undefined
			};

			this.updateSelectedCell = this.updateSelectedCell.bind(this);
			this.onCreateTable      = this.onCreateTable.bind(this);
			this.createTable        = this.createTable.bind(this);
			this.emptyColumn        = this.emptyColumn.bind(this);
			this.emptyRow           = this.emptyRow.bind(this);
			this.insertRow          = this.insertRow.bind(this);
			this.deleteRow          = this.deleteRow.bind(this);
			this.insertColumn       = this.insertColumn.bind(this);
			this.deleteColumn       = this.deleteColumn.bind(this);
			this.changeColumnAlign  = this.changeColumnAlign.bind(this);
			this.onChange           = this.onChange.bind(this);
			this.editItem           = this.editItem.bind(this);
			this.getTable           = this.getTable.bind(this);
			this.renderTableSection = this.renderTableSection.bind(this);
		}

		/**
		 * Updates `selectedCell` in state.
		 *
		 * @param {Object} selectedCell - Object to be set for selected cell.
		 */
		updateSelectedCell(selectedCell) {
			return this.setState({ selectedCell })
		}

		/**
		 * Creates a new table based on the specified number of rows and columns.
		 *
		 * @param {Event} e - Event.
		 */
		onCreateTable(e) {
			e.preventDefault()

			const { defaultCols, defaultRows } = this.props.attributes

			return (
				this.props.setAttributes(
					{
						tabHead: this.createTable({ rows: 1, columns: defaultCols }, 'head'),
						tabBody: this.createTable({ rows: defaultRows, columns: defaultCols })
					}
				)
			)
		}

		/**
		 * Creates empty table.
		 *
		 * @param {Object} obj
		 * @param {number} obj.rows - The number of rows in the new table.
		 * @param {number} obj.columns - The number of columns in the new table.
		 * @param {string} section - Table section.
		 * @returns {Array} - Empty table array.
		 */
		 createTable( { rows, columns }, section = 'body' ) {
			const row = this.emptyRow(columns, section)
			return Array(parseInt(rows)).fill().map((key) => row)
		}

		/**
		 * Returns empty column.
		 *
		 * @param {string} section - Table section.
		 * @returns {Object} - Empty column.
		 */
		emptyColumn(section = 'body') {
			return {
				content: '',
				tag: section === 'head' ? 'th' : 'td',
				class: ''
			}
		}

		/**
		 * Returns empty row.
		 *
		 * @param {number} columns - Number of columns in row.
		 * @param {string} section - Table section.
		 * @returns {Array} - Empty row.
		 */
		emptyRow(columns, section) {
			const column = this.emptyColumn(section)
			return Array(parseInt(columns)).fill().map((key) => column)
		}

		/**
		 * Inserts a row at the currently selected row index, plus `delta`.
		 *
		 * @param {number} delta - Offset for selected row index at which to insert.
		 */
		insertRow(delta) {
			const { tabBody } = this.props.attributes
			const { selectedCell } = this.state

			// Row can be inserted only into body section.
			if (!selectedCell || selectedCell.section !== 'body') return

			const newRowIndex = selectedCell.rowIndex + delta
			
			// Keeps track of last selected row.
			if (delta === 0) {
				let newSelectedCell = selectedCell
				newSelectedCell.rowIndex += 1

				this.updateSelectedCell(newSelectedCell)
			}

			const row = this.emptyRow(tabBody[0].length)

			let newBody = tabBody.slice(0)
			newBody.splice(newRowIndex, 0, row)

			return this.props.setAttributes({ tabBody: newBody })
		}

		/**
		 * Deletes a row at the currently selected row index.
		 */
		deleteRow() {
			const { tabBody } = this.props.attributes
			const { selectedCell } = this.state

			// Row can be deleted only in body section.
			if (!selectedCell || selectedCell.section !== 'body') return

			if (selectedCell.rowIndex + 1 === tabBody.length) {
				this.updateSelectedCell()
			}

			let newBody = tabBody.slice(0)
			newBody.splice(selectedCell.rowIndex, 1)

			if (newBody.length === 0) {
				const row = this.emptyRow(tabBody[0].length)
				newBody.splice(0, 0, row)
			}

			return this.props.setAttributes({ tabBody: newBody })
		}

		/**
		 * Inserts a column at the currently selected column index, plus `delta`.
		 *
		 * @param {number} delta - Offset for selected column index at which to insert.
		 */
		insertColumn(delta) {
			const { tabHead, tabBody } = this.props.attributes
			const { selectedCell } = this.state

			if (!selectedCell) return

			const newColIndex = selectedCell.columnIndex + delta
			
			// Keeps track of last selected column.
			if (delta === 0) {
				let newSelectedCell = selectedCell
				newSelectedCell.columnIndex += 1

				this.updateSelectedCell(newSelectedCell)
			}

			let newHead = tabHead.slice(0)
			newHead[0].splice(newColIndex, 0, this.emptyColumn('head'))

			const column = this.emptyColumn()

			let newBody = tabBody.slice(0)
			newBody.map((row) => {
				row.splice(newColIndex, 0, column)
			})

			return this.props.setAttributes({ tabHead: newHead, tabBody: newBody })
		}

		/**
		 * Deletes a column at the currently selected column index.
		 */
		deleteColumn() {
			const { tabHead, tabBody } = this.props.attributes
			const { selectedCell } = this.state

			if (!selectedCell) return

			let newHead = tabHead.slice(0)
			let newBody = tabBody.slice(0)

			if (selectedCell.columnIndex + 1 === newBody[0].length) {
				this.updateSelectedCell()
			}

			newHead[0].splice(selectedCell.columnIndex, 1)
			newBody.map((row) => {
				row.splice(selectedCell.columnIndex, 1)
			})

			if (newBody[0].length === 0) {
				const column = this.emptyColumn()

				newHead[0].splice(0, 0, this.emptyColumn('head'))
				newBody.map((row) => {
					row.splice(0, 0, column)
				})
			}

			return this.props.setAttributes({ tabHead: newHead, tabBody: newBody })
		}

		/**
		 * Change column alignment.
		 *
		 * @param {string} align - Column alignment.
		 */
		changeColumnAlign(align) {
			const { tabHead, tabBody } = this.props.attributes
			const { selectedCell } = this.state

			if (!selectedCell) return

			const onIndex = selectedCell.columnIndex
			const customHeadClass = align === 'right' ? 'idsk-table__header--numeric' : ''
			const customClass = align === 'right' ? 'idsk-table__cell--numeric' : ''

			let newHead = tabHead.slice(0)
			newHead[0][onIndex].class = customHeadClass

			let newBody = tabBody.slice(0)
			newBody.map((row) => {
				row[onIndex].class = customClass
			})

			return this.props.setAttributes({ tabHead: newHead, tabBody: newBody })
		}

		/**
		 * Updates attribute value.
		 *
		 * @param {string} attribute - Attribute name.
		 * @param {string} value - Attribute value.
		 */
		onChange(attribute, value) {
			return (
				this.props.setAttributes(
					{ [attribute]: value }
				)
			)
		}

		/**
		 * Updates item in table at current row and column index.
		 *
		 * @param {string} section - Table section.
		 * @param {Object} obj
		 * @param {number} obj.rowIndex - Items row index.
		 * @param {number} obj.columnIndex - Items column index.
		 * @param {string} value - New value.
		 */
		editItem(section, { rowIndex, columnIndex }, value) {
			const content = JSON.parse(JSON.stringify(this.props.attributes[section]))

			if (content.length === 0) return

			content[rowIndex][columnIndex].content = value

			return this.onChange(`${section}`, content)
		};

		/**
		 * Renders table section.
		 *
		 * @param {string} section - Table section.
		 * @param {Array} items - Items to be rendered.
		 */
		renderTableSection( section, items ) {
			const isHead = section === 'head' ? true : false
			const TagName = `t${section}`

			return (
				<TagName className={`idsk-table__${section}`}>
					{items.map(( row, rowIndex) => (
						<tr className="idsk-table__row" key={rowIndex}>
							{row.map(( col, columnIndex) => (
								<RichText
									tagName={col.tag}
									className={(!!isHead ? 'idsk-table__header ' : 'idsk-table__cell ') + col.class}
									onChange={value => this.editItem(!!isHead ? 'tabHead' : 'tabBody', {rowIndex, columnIndex}, value)}
									scope={col.tag === 'th' ? 'col' : undefined}
									value={col.content}
									placeholder={!!isHead ? __( 'Heading', 'idsk-toolkit' ) : __( 'Value', 'idsk-toolkit' )}
									unstableOnFocus={() => this.updateSelectedCell({ section, rowIndex, columnIndex })}
								/>
							))}
						</tr>
					))}
				</TagName>
			)
		}

		/**
		 * Renders table with sections.
		 */
		getTable() {
			const { withHeading, tabHead, tabBody } = this.props.attributes

			return (
				<table className="idsk-table">
					{!!withHeading && this.renderTableSection('head', tabHead)}
					{this.renderTableSection('body', tabBody)}
				</table>
			)
		}

		render() {
			// Pull out the props we'll use.
			const { attributes, className, setAttributes } = this.props
			const { selectedCell } = this.state

			// Pull out specific attributes for clarity below.
			const { blockId, withHeading, allowPrint, defaultCols, defaultRows, tabBody, sourceLink } = attributes

			if (!blockId) {
				setAttributes({ blockId: nanoid() })
			}

			const tableControls = [
				{
					icon: tableRowBefore,
					title: __( 'Insert row before', 'idsk-toolkit' ),
					isDisabled: ! selectedCell || selectedCell.section !== 'body',
					onClick: () => this.insertRow(0),
				},
				{
					icon: tableRowAfter,
					title: __( 'Insert row after', 'idsk-toolkit' ),
					isDisabled: ! selectedCell || selectedCell.section !== 'body',
					onClick: () => this.insertRow(1),
				},
				{
					icon: tableRowDelete,
					title: __( 'Delete row', 'idsk-toolkit' ),
					isDisabled: ! selectedCell || selectedCell.section !== 'body',
					onClick: () => this.deleteRow(),
				},
				{
					icon: tableColumnBefore,
					title: __( 'Insert column before', 'idsk-toolkit' ),
					isDisabled: ! selectedCell,
					onClick: () => this.insertColumn(0),
				},
				{
					icon: tableColumnAfter,
					title: __( 'Insert column after', 'idsk-toolkit' ),
					isDisabled: ! selectedCell,
					onClick: () => this.insertColumn(1),
				},
				{
					icon: tableColumnDelete,
					title: __( 'Delete column', 'idsk-toolkit' ),
					isDisabled: ! selectedCell,
					onClick: () => this.deleteColumn(),
				},
			];

			return <div className={className}>
				{!tabBody &&
					<Placeholder
						label={__( 'Table', 'idsk-toolkit' )}
						instructions={__( 'Insert empty table.', 'idsk-toolkit' )}
					>
						<form
							className="blocks-table__placeholder-form"
							onSubmit={e => this.onCreateTable(e)}
						>
							<TextControl
								type="number"
								label={__( 'Row count', 'idsk-toolkit' )}
								value={defaultRows}
								onChange={value => this.onChange('defaultRows', value)}
								min="1"
								className="blocks-table__placeholder-input"
							/>
							<TextControl
								type="number"
								label={__( 'Column count', 'idsk-toolkit' )}
								value={defaultCols}
								onChange={value => this.onChange('defaultCols', value)}
								min="1"
								className="blocks-table__placeholder-input"
							/>
							<Button
								className="blocks-table__placeholder-button"
								variant="primary"
								type="submit"
							>
								{__( 'Create Table', 'idsk-toolkit' )}
							</Button>
						</form>
					</Placeholder>
				}

				{!!tabBody &&
					<div data-module="idsk-table" id={'table-'+blockId}>
						<InspectorControls>
							<PanelBody title={__('Table settings', 'idsk-toolkit')}>
								<ToggleControl
									className="js-table-heading"
									checked={withHeading}
									label={__('Header', 'idsk-toolkit')}
									onChange={checked => this.onChange('withHeading', checked)}
								/>
								<ToggleControl
									className="js-table-allow-print"
									checked={allowPrint}
									label={__('Allow printing', 'idsk-toolkit')}
									onChange={checked => this.onChange('allowPrint', checked)}
								/>
							</PanelBody>
						</InspectorControls>

						<BlockControls group="block">
							<AlignmentControl
								label={__( 'Change column alignment', 'idsk-toolkit' )}
								alignmentControls={ALIGNMENT_CONTROLS}
								onChange={( align ) => this.changeColumnAlign( align )}
							/>
						</BlockControls>
						<BlockControls group="other">
							<ToolbarDropdownMenu
								icon={table}
								label={__( 'Edit table', 'idsk-toolkit' )}
								controls={tableControls}
							/>
						</BlockControls>

						{this.getTable()}
						
						<div className="idsk-table__meta">
							<div className="idsk-button-group idsk-table__meta-buttons">
								{!!allowPrint &&
									<button type="button" className="idsk-button idsk-table__meta-print-button" data-module="idsk-button">
										{__( 'Print', 'idsk-toolkit' )}
									</button>
								}
							</div>

							<div className="govuk-body idsk-table__meta-source">
								<RichText
									className="js-table-source-link"
									onChange={value => this.onChange('sourceLink', value)}
									value={sourceLink}
									placeholder={__( 'Source: www.example.com', 'idsk-toolkit' )}
								/>
							</div>
						</div>
					</div>
				}
			</div>;
		}
	},
	
	// No save, dynamic block
	save() {
		return null
	},
})
