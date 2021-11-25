const cookieSet = idsk_cookie_data.cookieSet;
const cookieExpire = idsk_cookie_data.cookieExpire;
const cookie_banners = Array.from(document.getElementsByClassName( 'idsk-cookie-banner' ));
const cookie_message = Array.from(document.getElementsByClassName( 'idsk-cookies-message' ));
const cookies_accept_btn = Array.from(document.getElementsByClassName( 'idsk-cookies-accept' ));
const cookies_reject_btn = Array.from(document.getElementsByClassName( 'idsk-cookies-reject' ));
const cookies_close_btn = Array.from(document.getElementsByClassName( 'idsk-cookies-hide' ));

/**
 * Hide banner if cookie is set
 */
if ( getCookie('idskCookies') || cookieSet == 1 ) {
    cookie_banners.forEach( function(e) { toogleHidden(e) } );
}

/**
 * Accept button
 */
cookies_accept_btn.forEach( function(e) {
    const cookies_allowed = Array.from(document.getElementsByClassName( 'idsk-cookies-allow' ));
    let cookies_ids = [];

    e.addEventListener('click', function() {
        cookies_allowed.forEach(function(cookie) {
            if (cookie.checked == true && cookie.getAttribute('id') != 'idskCookies') {
                cookies_ids.push(cookie.getAttribute('id'));
            }
        });

        idskCookieConsent(cookies_ids);

        if (e.classList.contains('idsk-cookies-accept-form')) {
            location.reload();
        }
    });
});

/**
 * Reject button
 */
cookies_reject_btn.forEach( function(e) {
    e.addEventListener('click', function() {
        idskCookieDissent();
    });
});

/**
 * Close button
 */
cookies_close_btn.forEach( function(e) {
    e.addEventListener('click', function() {
        location.reload();
    });
});

/**
 * Toogle attribute hidden
 * @param {object} el
 */
function toogleHidden(el) {
    if (!el.hasAttribute('hidden') || el.getAttribute('hidden') === 'false') {
        el.setAttribute('hidden', 'true');
    } else {
        el.removeAttribute('hidden');
    }
}

/**
 * Cookie consent
 * @param {array} cids Cookies IDs
 */
function idskCookieConsent(cids = []) {
    const cookies_accepted = Array.from(document.getElementsByClassName( 'idsk-cookies-accepted' ));

    deleteCookies();
    createCookie('accepted');

    cids.forEach(function(id) {
        createCookie('accepted', id);
    });

    cookie_message.forEach( function(e) { toogleHidden(e) } );
    cookies_accepted.forEach( function(e) { toogleHidden(e) } );
}

/**
 * Cookie dissent
 */
function idskCookieDissent() {
    const cookies_rejected = Array.from(document.getElementsByClassName( 'idsk-cookies-rejected' ));

    deleteCookies();
    createCookie('rejected');

    cookie_message.forEach( function(e) { toogleHidden(e) } );
    cookies_rejected.forEach( function(e) { toogleHidden(e) } );
}

/**
 * Create cookie
 * @param {string} value
 * @param {string} cname Cookie name
 */
function createCookie(value, cname = '') {
    const today = new Date();
    const expire = new Date();
    const name = 'idskCookies' + ( cname != '' ? '_' + cname : '' );

    if (cookieExpire > 0) {
        expire.setTime(today.getTime() + (cookieExpire * 24 * 60 * 60 * 1000) );
        cookieParams = name + "=" + value + "; expires=" + expire.toUTCString() + "; path=/";
    } else {
        cookieParams = name + "=" + value + "; path=/";
    }
    document.cookie = cookieParams;
}

/**
 * Get cookie
 * @param {string} cname Cookie name
 * @returns {string}
 */
function getCookie(cname) {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(';');

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];

        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }

        if (cookie.indexOf(name) == 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }

    return "";
}

/**
 * Delete cookies
 */
function deleteCookies() {
    document.cookie.split(";").forEach(function(cookie) { 
        document.cookie = cookie.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
    });
}