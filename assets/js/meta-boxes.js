const metaBoxAdd = Array.from(document.getElementsByClassName( 'idsk-meta-add' ));
const metaBoxRemove = Array.from(document.getElementsByClassName( 'idsk-meta-remove' ));

metaBoxAdd.forEach( function(e) {
    e.addEventListener('click', function() {
        const metaBoxGroup = document.getElementById(e.closest('.postbox').getAttribute('id'));
        const metaBoxItems = metaBoxGroup.querySelectorAll('.idsk-meta-single');
        const lastItemPosition = metaBoxItems.length - 1;
        const newItem = metaBoxItems[lastItemPosition].cloneNode(true);

        setInputs(newItem);

        metaBoxItems[lastItemPosition].insertAdjacentElement('afterend', newItem);
    });
});

metaBoxRemove.forEach( function(e) {
    e.addEventListener('click', function() {
        removeElement(e);
    });
});

/**
 * Remove element
 * @param {object} el 
 */
function removeElement(el) {
    const metaBoxGroup = document.getElementById(el.closest('.postbox').getAttribute('id'));
    const metaBoxItems = metaBoxGroup.querySelectorAll('.idsk-meta-single');

    if (metaBoxItems.length == 1) {
        const newItem = metaBoxItems[0].cloneNode(true);

        setInputs(newItem);

        metaBoxItems[0].insertAdjacentElement('afterend', newItem);
    }

    el.closest('.idsk-meta-single').remove();
}

/**
 * Set inputs data
 * @param {object} el
 */
function setInputs(el) {
    el.querySelectorAll('label, input, textarea, select, .idsk-meta-remove').forEach( function(e) {
        // Update attributes
        setAtt(e, 'id');
        setAtt(e, 'name');
        setAtt(e, 'for');
        // Clear inputs
        if (e.hasAttribute('value')) {
            e.setAttribute('value', '');
            e.value = '';
        }
        if (e.tagName == 'TEXTAREA') {
            e.value = '';
        }
        if (e.tagName == 'SELECT') {
            e.options[e.selectedIndex].removeAttribute('selected');
        }
        // Add listener for remove button
        if (e.classList.contains('idsk-meta-remove')) {
            e.addEventListener('click', function() {
                removeElement(e);
            });
        }
    });
}

/**
 * Set attributes
 * @param {object} el 
 * @param {string} attr 
 */
function setAtt(el, attr) {
    let oldIndex = 0;
    let newIndex = 0;

    if (el.hasAttribute(attr)) {
        const attribute = el.getAttribute(attr);
        oldIndex = Number(attribute.substring( attribute.indexOf('[') + 1, attribute.indexOf(']') ));
        newIndex = oldIndex + 1;

        el.setAttribute(attr, attribute.replace('['+oldIndex+']', '['+newIndex+']'));
    }
}