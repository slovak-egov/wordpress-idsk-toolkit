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
	SelectControl,
	TextControl,
	ToggleControl,
	ToolbarDropdownMenu
} = wp.components;
const { Component } = wp.element;
const {
	__,
	sprintf
} = wp.i18n;
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
		withTitle: {
			type: 'boolean',
			selector: 'js-table-title',
			default: false
		},
		withFilters: {
			type: 'boolean',
			selector: 'js-table-filters',
			default: false
		},
		withFilterCategories: {
			type: 'boolean',
			selector: 'js-table-filters-categories',
			default: false
		},
		filterCategories: {
			type: 'array'
		},
		withHeading: {
			type: 'boolean',
			selector: 'js-table-heading',
			default: false
		},
		headingSort: {
			type: 'boolean',
			selector: 'js-table-heading-sort',
			default: false
		},
		allowPrint: {
			type: 'boolean',
			selector: 'js-table-allow-print',
			default: false
		},
		tableHeight: {
			type: 'number',
			selector: 'js-table-height',
			default: 0
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
		titleHeading: {
			type: 'string',
			selector: 'js-table-title-head'
		},
		titleDesc: {
			type: 'string',
			selector: 'js-table-title-desc'
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
				withTitle: this.props.attributes.withTitle || false,
				withFilters: this.props.attributes.withFilters || false,
				withFilterCategories: this.props.attributes.withFilterCategories || false,
				filterCategories: this.props.attributes.filterCategories || [],
				withHeading: this.props.attributes.withHeading || false,
				headingSort: this.props.attributes.headingSort || false,
				allowPrint: this.props.attributes.allowPrint || false,
				tableHeight: this.props.attributes.tableHeight || 0,
				defaultCols: this.props.attributes.defaultCols || 2,
				defaultRows: this.props.attributes.defaultRows || 2,
				tabHead: this.props.attributes.tabHead || [],
				tabBody: this.props.attributes.tabBody || [],
				titleHeading: this.props.attributes.titleHeading || '',
				titleDesc: this.props.attributes.titleDesc || '',
				sourceLink: this.props.attributes.sourceLink || '',
				selectedCell: undefined
			};

			this.updateSelectedCell   = this.updateSelectedCell.bind(this);
			this.onCreateTable        = this.onCreateTable.bind(this);
			this.createTable          = this.createTable.bind(this);
			this.emptyColumn          = this.emptyColumn.bind(this);
			this.emptyRow             = this.emptyRow.bind(this);
			this.insertRow            = this.insertRow.bind(this);
			this.deleteRow            = this.deleteRow.bind(this);
			this.insertColumn         = this.insertColumn.bind(this);
			this.deleteColumn         = this.deleteColumn.bind(this);
			this.changeColumnAlign    = this.changeColumnAlign.bind(this);
			this.onChange             = this.onChange.bind(this);
			this.editItem             = this.editItem.bind(this);
			this.renderTableSection   = this.renderTableSection.bind(this);
			this.getTable             = this.getTable.bind(this);
			this.addFilterCategory    = this.addFilterCategory.bind(this);
			this.removeFilterCategory = this.removeFilterCategory.bind(this);
			this.getFilterContent     = this.getFilterContent.bind(this);
			this.renderFilter         = this.renderFilter.bind(this);
			this.getFilters           = this.getFilters.bind(this);
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
			let column = {
				content: '',
				tag: 'td',
				class: ''
			}

			if (section === 'head') {
				column['tag'] = 'th'
				column['filterType'] = column['filterCategory'] = ''
			}

			return column
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
		 * @param {string} key - Items key.
		 * @param {string} value - New value.
		 */
		editItem(section, { rowIndex = -1, columnIndex = -1 }, key, value) {
			const sect = this.props.attributes[section]
			const content = JSON.parse(JSON.stringify(sect))

			if (content.length === 0) return

			if (rowIndex !== -1) {
				if (columnIndex !== -1) {
					content[rowIndex][columnIndex][key] = value
				} else {
					content[rowIndex][key] = value
				}
			} else {
				content[key] = value
			}

			// Makes `switch` type of filter unique.
			if (key === 'filterType' && value === 'switch') {
				const filterName = content[rowIndex][columnIndex]['content']

				sect[rowIndex].map(( column, columnIndex ) => (
					column.filterType === 'switch' && column.content !== filterName && (
						content[rowIndex][columnIndex]['filterType'] = ''
					)
				))
			}

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
			const defaultFormats = wp.data.select( 'core/rich-text' ).getFormatTypes().map((format) => format.name)

			return (
				<TagName className={`idsk-table__${section}`}>
					{items.map(( row, rowIndex) => (
						<tr className="idsk-table__row" key={rowIndex}>
							{row.map(( col, columnIndex ) => {
								const TagCol = col.tag
								return <TagCol
									className={(!!isHead ? 'idsk-table__header ' : 'idsk-table__cell ') + col.class}
									scope={!!isHead ? 'col' : undefined}
								>
									<RichText
										tagName='span'
										className={(!!isHead ? 'th-span' : '')}
										onChange={value => this.editItem(!!isHead ? 'tabHead' : 'tabBody', {rowIndex, columnIndex}, 'content', value)}
										value={col.content}
										placeholder={!!isHead ? __( 'Heading', 'idsk-toolkit' ) : __( 'Value', 'idsk-toolkit' )}
										unstableOnFocus={() => this.updateSelectedCell({ section, rowIndex, columnIndex })}
										allowedFormats={!!isHead ? [] : defaultFormats}
									/>
									{!!isHead && !!this.props.attributes.headingSort &&
										<button className="arrowBtn">
											<span className="sr-only">
												{__( 'Unordered column - will use ascending order.', 'idsk-toolkit' )}
											</span>
										</button>
									}
								</TagCol>
							})}
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

		/**
		 * Adds empty filter category.
		 *
		 * @param {Event} e - Event.
		 */
		addFilterCategory(e) {
			e.preventDefault()

			const { filterCategories } = this.props.attributes

			const emptyFilter = {
				id: nanoid(),
				text: ''
			}

			let newFilters = [emptyFilter]

			if ( !!filterCategories ) {
				newFilters = [...filterCategories, emptyFilter]
			}

			return this.onChange('filterCategories', newFilters)
		}

		/**
		 * Removes filter category.
		 *
		 * @param {Event} e - Event.
		 * @param {number} index - Category index.
		 */
		removeFilterCategory(e, index) {
			e.preventDefault()

			const filterCategories = JSON.parse(JSON.stringify(this.props.attributes.filterCategories))

			filterCategories.splice(index, 1)

			return this.onChange('filterCategories', filterCategories)
		}

		/**
		 * Get options for filter.
		 *
		 * @param {string} label - Filter name.
		 * @param {number} columnIndex - Column index.
		 * @param {boolean} select - Sorts options and adds empty value.
		 * @returns {Array} - Array of options for filter.
		 */
		getFilterContent(label, columnIndex, select = false) {
			const { tabBody } = this.props.attributes
			let content = []

			tabBody.map(( row ) => (
				content.indexOf(row[columnIndex].content) < 0 &&
					content.push(row[columnIndex].content)
			))

			if (!!select) {
				content.sort(( a, b ) => a.localeCompare(b))
				content.splice(
					0,
					0,
					sprintf(
						/* translators: %s: Option name */
						__( 'Select %s', 'idsk-toolkit' ),
						label.toLowerCase()
					)
				)
			}

			return content
		}

		/**
		 * Render single filter.
		 *
		 * @param {string} name - Filter name.
		 * @param {string} type - Filter type.
		 * @param {number} columnIndex - Column index for `select` type.
		 */
		renderFilter(name, type, columnIndex = 0) {
			switch (type) {
				case 'input':
					return <div className="govuk-grid-column-one-third-from-desktop">
						<div className="govuk-form-group">
							<label className="govuk-label">
								{name}
							</label>
							<input
								className="govuk-input"
								type="text"
								id={name.toLowerCase()}
								name={name.toLowerCase()}
								placeholder={name}
								aria-label={name}
							/>
						</div>
					</div>
				case 'select':
					const filterContent = this.getFilterContent(name, columnIndex, true)
					return <div className="govuk-grid-column-one-third-from-desktop">
						<div className="govuk-form-group">
							<label className="govuk-label">
								{name}
							</label>
							<select className="govuk-select" id={name.toLowerCase()} name={name.toLowerCase()}>
								{filterContent.map(( text ) => <option value={text.toLowerCase()}>{text}</option>)}
							</select>
						</div>
					</div>
				case 'switch':
					return <div className="govuk-radios__item">
						<input className="govuk-radios__input" type="radio" name={name.toLowerCase()} defaultChecked="" />
						<label className="govuk-label govuk-radios__label">{name}</label>
					</div>
				default:
					break;
			}
		}

		/**
		 * Renders table filter section.
		 */
		getFilters() {
			const { tabHead, withFilterCategories, filterCategories } = this.props.attributes

			if (!!withFilterCategories) {
				return (
					!!filterCategories && filterCategories.map(( item ) => (
						<div className="idsk-table-filter__category">
							<div className="idsk-table-filter__title govuk-heading-s">{item.text}</div>
							<button className="govuk-body govuk-link idsk-filter-menu__toggle" type="button">
								{__( 'Collapse filter section', 'idsk-toolkit' )}
							</button>
							<div className="idsk-table-filter__content">
								<div className="govuk-grid-row idsk-table-filter__filter-inputs">
									{tabHead[0].map(( column, columnIndex ) =>
										column.filterCategory === item.id &&
											column.filterType !== '' && column.filterType !=='switch' &&
												this.renderFilter(column.content, column.filterType, columnIndex)
									)}
								</div>
							</div>
						</div>
					))
				)
			} else {
				return <div className="govuk-grid-row idsk-table-filter__filter-inputs">
					{tabHead[0].map(( column, columnIndex ) =>
						column.filterType !== '' && column.filterType !=='switch' &&
							this.renderFilter(column.content, column.filterType, columnIndex)
					)}
				</div>
			}
		}

		render() {
			// Pull out the props we'll use.
			const { attributes, className, setAttributes } = this.props
			const { selectedCell } = this.state

			// Pull out specific attributes for clarity below.
			const {
				blockId,
				withTitle,
				withFilters,
				withFilterCategories,
				filterCategories,
				withHeading,
				headingSort,
				allowPrint,
				tableHeight,
				defaultCols,
				defaultRows,
				tabHead,
				tabBody,
				titleHeading,
				titleDesc,
				sourceLink
			} = attributes

			if (!blockId) {
				setAttributes({ blockId: nanoid() })
			}

			let switchFilters
			!!tabHead && tabHead[0].map((column, columnIndex) => (
				column.filterType === 'switch' && (
					switchFilters = this.getFilterContent(column.content, columnIndex)
				)
			))

			let filterCatsOptions = [{
				label: __( 'Without category', 'idsk-toolkit' ),
				value: ''
			}]
			!!filterCategories && filterCategories.map(( item ) =>
				filterCatsOptions.push({
					label: item.text,
					value: item.id
				})
			)

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
								label={__( 'Column count', 'idsk-toolkit' )}
								value={defaultCols}
								onChange={value => this.onChange('defaultCols', value)}
								min="1"
								className="blocks-table__placeholder-input"
							/>
							<TextControl
								type="number"
								label={__( 'Row count', 'idsk-toolkit' )}
								value={defaultRows}
								onChange={value => this.onChange('defaultRows', value)}
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
							<PanelBody title={__( 'Table settings', 'idsk-toolkit' )}>
								<ToggleControl
									className="js-table-title"
									checked={withTitle}
									label={__( 'Show title', 'idsk-toolkit' )}
									onChange={checked => this.onChange('withTitle', checked)}
								/>
								<ToggleControl
									className="js-table-filters"
									checked={withFilters}
									label={__( 'Show filters', 'idsk-toolkit' )}
									onChange={checked => this.onChange('withFilters', checked)}
								/>
								<ToggleControl
									className="js-table-heading"
									checked={withHeading}
									label={__( 'Show table head', 'idsk-toolkit' )}
									onChange={checked => this.onChange('withHeading', checked)}
								/>
								<ToggleControl
									className="js-table-heading-sort"
									checked={headingSort}
									label={__( 'Allow sorting', 'idsk-toolkit' )}
									onChange={checked => this.onChange('headingSort', checked)}
								/>
								<ToggleControl
									className="js-table-allow-print"
									checked={allowPrint}
									label={__( 'Allow print', 'idsk-toolkit' )}
									onChange={checked => this.onChange('allowPrint', checked)}
								/>
								<hr />
								<TextControl
									className="js-table-height"
									type="number"
									label={__( 'Table height (px)', 'idsk-toolkit' )}
									help={__( '0px - Table will be displayed in its entirety.', 'idsk-toolkit' )}
									value={tableHeight}
									onChange={value => this.onChange('tableHeight', parseInt(value))}
									min="0"
								/>
							</PanelBody>

							<PanelBody title={__( 'Filter types', 'idsk-toolkit' )}>
								<p>{__( 'Note: When filter option "Switch" is chosen, table column for this filter will not be displayed on the website. Only one filter of this type can be chosen.', 'idsk-toolkit' )}</p>
								{tabHead[0].map(( column, columnIndex ) => (
									<>
										<SelectControl
											value={column.filterType}
											label={column.content}
											options={[
												{
													label: __( 'Off', 'idsk-toolkit' ),
													value: ''
												},
												{
													label: __( 'Text input', 'idsk-toolkit' ),
													value: 'input'
												},
												{
													label: __( 'Select', 'idsk-toolkit' ),
													value: 'select'
												},
												{
													label: __( 'Switch', 'idsk-toolkit' ),
													value: 'switch'
												},
											]}
											onChange={value => this.editItem('tabHead', { rowIndex: 0, columnIndex }, 'filterType', value)}
										/>
										<SelectControl
											value={column.filterCategory}
											options={filterCatsOptions}
											onChange={value => this.editItem('tabHead', { rowIndex: 0, columnIndex }, 'filterCategory', value)}
										/>
									</>
								))}
							</PanelBody>

							<PanelBody title={__( 'Filter categories', 'idsk-toolkit' )}>
								<ToggleControl
									className="js-table-filters-categories"
									checked={withFilterCategories}
									label={__( 'Group in categories', 'idsk-toolkit' )}
									onChange={checked => this.onChange('withFilterCategories', checked)}
								/>
								{!!filterCategories && filterCategories.map(( item, index ) =>
									<div key={index}>
										<TextControl
											key={index}
											label={__( 'Category name', 'idsk-toolkit' )}
											value={item.text}
											onChange={value => this.editItem('filterCategories', {rowIndex: index}, 'text', value)}
										/>
										<input
											className="button-secondary button"
											type="submit"
											value={__( 'Delete category', 'idsk-toolkit' )}
											onClick={(e) => this.removeFilterCategory(e, index)}
										/>
										<div className="govuk-clearfix"></div>
										<hr/>
									</div>
								)}
								<br/>
								<input
									className="button-primary button"
									type="submit"
									value={__( 'Add category', 'idsk-toolkit' )}
									onClick={(e) => this.addFilterCategory(e)}
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

						{(!!withTitle || !!switchFilters) &&
							<div className="idsk-table__heading">
								{!!withTitle &&
									<div>
										<RichText
											tagName="h2"
											className="js-table-title-head govuk-heading-l govuk-!-margin-bottom-4"
											onChange={value => this.onChange('titleHeading', value)}
											value={titleHeading}
											placeholder={__( 'Heading', 'idsk-toolkit' )}
										/>
										<RichText
											tagName="p"
											className="js-table-title-desc govuk-body"
											onChange={value => this.onChange('titleDesc', value)}
											value={titleDesc}
											placeholder={__( 'Description', 'idsk-toolkit' )}
										/>
									</div>
								}

								{!!switchFilters &&
									<div className="idsk-table__heading-extended">
										<div className="govuk-form-group">
											<div className="govuk-radios govuk-radios--inline">
												{switchFilters.map((text) => this.renderFilter(text, 'switch'))}
											</div>
										</div>
									</div>
								}
							</div>
						}

						{!!withFilters &&
							<div data-module="idsk-table-filter" id={'table-'+blockId+'-filter'} className="idsk-table-filter">
								<div className="idsk-table-filter__panel idsk-table-filter__inputs">
									<div className="idsk-table-filter__title govuk-heading-m">{__( 'Filter content', 'idsk-toolkit' )}</div>
									<button className="govuk-body govuk-link idsk-filter-menu__toggle" type="button">
										{__( 'Collapse filter content', 'idsk-toolkit' )}
									</button>

									<form className="idsk-table-filter__content" action="#">
										{this.getFilters()}
										<button type="button" className="idsk-button submit-table-filter" disabled="disabled">
											{sprintf(
												/* translators: %s: Number of active filters */
												__( 'Filter (%s)', 'idsk-toolkit' ),
												'0'
											)}
										</button>
									</form>
								</div>
							</div>
						}

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
