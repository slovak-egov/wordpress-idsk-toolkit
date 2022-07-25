const tables = Array.from(document.getElementsByClassName( 'idsk-table-wrapper' ));

tables.forEach( function(table) {
	const filters = table.querySelectorAll('.govuk-radios__input, .submit-table-filter');
	const sorters = table.querySelectorAll('.arrowBtn');

	filters.forEach( function(filter) {
		filter.addEventListener('click', function() {
			filterTable(table);
		});
	});

	sorters.forEach( function(sorter) {
		sorter.addEventListener('click', function(e) {
			sortTable(e, table);
		});
	});
});

/**
 * Gets column index.
 *
 * @param {HTMLCollection} items Items collection.
 * @param {string} name Item attribute name.
 * @returns {number} Index.
 */
function getIndex(items, name) {
	let index = -1;

	for (let i = 0; i < items.length; i++) {
		const item = items[i];
		let text = item.outerText.trim();
		text = text.split(/[\n]/)[0].trim();

		if (text.toUpperCase() === name.toUpperCase()) {
			index = i;
		}
	}

	return index;
}

/**
 * Search for rows to be hidden.
 *
 * @param {HTMLCollection} rows Table rows collection.
 * @param {number} index Column index.
 * @param {Object} filter Filter content.
 * @returns {Array} Array of row indexes to be hidden.
 */
function getRowsToHide(rows, index, filter) {
	let rowIndexes = new Array;

	for (let i = 0; i < rows.length; i++) {
		const td = rows[i].getElementsByTagName("td");

		for (let j = 0; j < td.length; j++) {
			if (index === j) {
				const text = td[j].innerText.trim();

				// For `select` or `switch` filter search for exact entry, otherwise search occurrence.
				if (filter.id !== filter.name) {
					if (filter.value.toUpperCase() !== text.toUpperCase()) {
						if (rowIndexes.indexOf(i) === -1) {
							rowIndexes.push(i);
						}
					}
				} else {
					if (text.toUpperCase().indexOf(filter.value.toUpperCase()) === -1) {
						if (rowIndexes.indexOf(i) === -1) {
							rowIndexes.push(i);
						}
					}
				}
			}
		}
	}

	return rowIndexes;
}

/**
 * Filters table and add listeners for active filter buttons.
 *
 * @param {HTMLDivElement} table Table to be filtered.
 */
function filterTable(table) {
	const switchFilters = table.querySelectorAll('.govuk-radios__input');
	const inputs = table.querySelectorAll('.idsk-table-filter__inputs input');
	const selects = table.querySelectorAll('.idsk-table-filter__inputs select');
	const th = table.getElementsByClassName('th-span');
	const tr = table.getElementsByTagName('tr');
	let activeFilters = new Array;
	let rowIndexes = new Array;

	// Get active filters.
	switchFilters.forEach( function(input) {
		if (!!input.checked) {
			activeFilters.push({
				id: input.value,
				index: getIndex(th, input.getAttribute('name')),
				name: input.getAttribute('name'),
				value: input.value
			})
		}
	});

	inputs.forEach( function(input) {
		if (input.value.length > 0) {
			activeFilters.push({
				id: input.getAttribute('id'),
				index: getIndex(th, input.getAttribute('name')),
				name: input.getAttribute('name'),
				value: input.value
			})
		}
	});

	selects.forEach( function(select) {
		if (select.value) {
			activeFilters.push({
				id: select.value,
				index: getIndex(th, select.getAttribute('name')),
				name: select.getAttribute('name'),
				value: select.options[select.selectedIndex].text
			});
		}
	});

	// Get row indexes to hide.
	activeFilters.forEach( function(filter) {
		rowIndexes = rowIndexes.concat(getRowsToHide(tr, filter.index, filter));
	});

	// Filter table.
	for (let i = 0; i < tr.length; i++) {
		if (rowIndexes.indexOf(i) === -1) {
			tr[i].style.display = "";
		} else {
			tr[i].style.display = "none";
		}
	}

	// Set listeners for active filter buttons.
	setTimeout(() => {
		const cancelFilters = table.querySelectorAll('.idsk-table-filter__parameter-remove');

		cancelFilters.forEach( function(btn, index) {
			if (index === cancelFilters.length - 1) {
				btn.closest('button').addEventListener('click', function() {
					filterTable(table);
				});
			} else {
				btn.addEventListener('click', function() {
					filterTable(table);
				});
			}
		});
	}, 500);
}

/**
 * Sorts table.
 *
 * @param {PointerEvent} e Event.
 * @param {HTMLDivElement} table Table to be sorted.
 */
function sortTable(e, table) {
	const th = table.getElementsByClassName('th-span');
	const tr = table.getElementsByTagName('tr');

	// Get actual column name.
	let columnName = e.target.closest('.th-span').outerText;
	columnName = columnName.split(/[\n]/)[0];

	// Get actual column index.
	const index = getIndex(th, columnName);

	let direction = 'asc';
	let sorting = true;
	let shouldSort = false;

	// If sorting is not set or is descending, set ascending sort class.
	if (!e.target.classList.contains('sortAsc', 'sortDesc') || e.target.classList.contains('sortDesc')) {
		e.target.classList.remove('sortDesc');
		e.target.classList.add('sortAsc');
		e.target.querySelector('.sr-only').innerText = e.target.querySelector('.sr-only').getAttribute('data-text-ascending');
	} else if (e.target.classList.contains('sortAsc')) {
		direction = 'desc';
		e.target.classList.remove('sortAsc');
		e.target.classList.add('sortDesc');
		e.target.querySelector('.sr-only').innerText = e.target.querySelector('.sr-only').getAttribute('data-text-descending');
	}

	// Remove sort classes from other columns in table head.
	for (let j = 0; j < th.length; j++) {
		if (j !== index) {
			th[j].querySelector('.arrowBtn').classList.remove('sortAsc', 'sortDesc');
			th[j].querySelector('.sr-only').innerText = th[j].querySelector('.sr-only').getAttribute('data-text-unordered');
		}
	}

	let i = 0;

	// Sort table rows.
	while (sorting) {
		sorting = false;

		// First row is table head row.
		for (i = 1; i < (tr.length - 1); i++) {
			const a = tr[i].getElementsByTagName("td")[index];
			const b = tr[i + 1].getElementsByTagName("td")[index];

			if (direction === "asc") {
				if (a.innerHTML.toLowerCase() > b.innerHTML.toLowerCase()) {
					shouldSort = true;
					break;
				}
			} else if (direction === "desc") {
				if (a.innerHTML.toLowerCase() < b.innerHTML.toLowerCase()) {
					shouldSort = true;
					break;
				}
			}
		}

		if (shouldSort) {
			if (tr.length > (i + 1)) {
				tr[i].parentNode.insertBefore(tr[i + 1], tr[i]);
				sorting = true;
			}
		}
	}
}
