/**
 * Date validation function
 * @param {string} year 
 * @param {string} month 0 based
 * @param {string} day 
 * @returns boolean
 */
function isValidDate(year, month, day) {
    month -= 1;
    var d = new Date(year, month, day);
    if (d.getFullYear() == year && d.getMonth() == month && d.getDate() == day) {
        return true;
    }
    return false;
}

/**
 * Search validation and WordPress query trigger
 * @param {string} attr 
 * @param {string} value 
 * @returns on incorrect date format
 */
function startSearch(attr, value) {
    // get actual search query
    var search = document.location.search;
    var args = search.substring(1).split("&");
    // set helpers
    var search_query = [];
    var indexed = -1;
    var tag_remove = false;

    // fill search_query
    args.forEach( (val, index) => {
        var args_split = val.split("=");
        // decode special characters
        args_split[0] = decodeURIComponent(args_split[0]);
        // save index if attr exist in query and is not tag
        //	 										                        save index for order
        if ( ( args_split[0] == attr && attr != 'tags[]' ) || ( args_split[0] == 'orderby' && attr == 'order' )) {
            indexed = index;
        }

        // save index for tag with selected value to remove
        if (attr == 'tags[]' && args_split[0] == 'tags[]' && args_split[1] == value) {
            indexed = index;
            tag_remove = true;
        }
        // push values to search_query 
        else {
            search_query[index] = [args_split[0], decodeURIComponent(args_split[1])];
        }
    } );

    if (indexed == -1) {
        indexed = search_query.length;
    }
    
    // sanitize order attr
    if (attr == 'order' && ( value != 'DESC' && value != 'ASC' )) {
        attr = 'orderby';
    }

    // sanitize dates
    if (attr == 'datum-od' || attr == 'datum-do') {
        var valid = true;
        var dateFormatRegex = /^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20)\d\d$/;
        var yearFormatRegex = /^(19|20)\d\d$/;
        var date = value.split('.');
        var dateEmpty = false;

        // get date form group
        var dateInput = document.getElementById(attr);
        var formGroup = dateInput.closest('.govuk-form-group');

        // check for empty values
        if (value) {
            date.forEach( (val) => { 
                if (!val) {
                    dateEmpty = true;
                }
            });
        }
        
        if ( ( date.length == 1 && value && !yearFormatRegex.test(value) ) || ( date.length == 3 && !dateFormatRegex.test(value) && !isValidDate(date[2], date[1], date[0]) ) || dateEmpty || ![1,3].includes(date.length) ) {
            formGroup.classList.add('govuk-form-group--error');
            formGroup.querySelector('#error-public_timestamp').classList.remove('govuk-visually-hidden');
            dateInput.classList.add('govuk-input--error');
            valid = false;
        } else {
            formGroup.classList.remove('govuk-form-group--error');
            formGroup.querySelector('#error-public_timestamp').classList.add('govuk-visually-hidden');
            dateInput.classList.remove('govuk-input--error');
        }

        if (!valid) {
            return;
        }
    }

    // update query
    if (tag_remove) {
        search_query.splice(indexed, 1);
    } else {
        search_query[indexed] = [attr, value];
    }

    var new_query = '?';

    search_query.reduce((acc, cur, index) => {
        new_query += cur[0]+'='+cur[1];
        
        if (index == search_query.length - 1) {
            // do nothing on last
        } else {
            new_query += '&';
            index++;
        }
    }, {});
    
    // run new query
    document.location.search = new_query;
}

/**
 * Remove and WordPress query trigger
 * @param {string} source 
 */
function remove( source ) {
    // get actual search query
    var search = document.location.search;
    var args = search.substring(1).split("&");
    var indexed = -1;
    
    args.forEach( (val, index) => {
        var args_split = val.split("=");
        // decode special characters
        args_split[0] = decodeURIComponent(args_split[0]);
        
        if ( ( args_split[0] == source ) ||
            ( source == 'tema' && args_split[0] == 'cat' ) ||
            ( source == 'podtema' && args_split[0] == 'scat' ) ||
            ( source.substring(0,4) == 'tag-' && args_split[0] == 'tags[]' && args_split[1] == source.substring(4) ) ) {
            indexed = index;
        }
    } );
    
    // update query
    if ( indexed > -1 ) {
        args.splice(indexed, 1);
    }
    
    var new_query = '?';

    args.forEach( (val, index) => {
        
        if (index == args.length - 1) {
            new_query += val;
        } else {
            new_query += val+'&';
        }

    } );
    
    // run new query
    document.location.search = new_query;
}

/**
 * Remove all and WordPress query trigger
 * @param {event} e 
 */
function removeAll() {
    
    var new_query = '?s=';
    
    // run new query
    document.location.search = new_query;
}

/**
 * Add remove function for filters in filter container
 */
setTimeout(function() {
    var picked_cats = Array.from(document.getElementsByClassName( 'idsk-search-results__picked-topic' ));
    var picked_tags = Array.from(document.getElementsByClassName( 'idsk-search-results__picked-content-type' ));
    var picked_dates = Array.from(document.getElementsByClassName( 'idsk-search-results__picked-date' ));
    var picked_els = picked_cats.concat(picked_tags).concat(picked_dates);

    picked_els.forEach( function(e) {
        e.addEventListener('click', function(event) {
            event.preventDefault();
            remove(e.getAttribute('data-source'));
        });
    });

    var turn_off_filter = Array.from(document.getElementsByClassName( 'idsk-search-results__button--turn-filters-off' ));
    turn_off_filter.forEach( function(e) {
        e.addEventListener('click', function(event) {
            event.preventDefault();
            removeAll();
        });
    });
}, 500);