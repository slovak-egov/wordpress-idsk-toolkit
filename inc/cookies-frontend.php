<?php
/**
 * Cookies shortcodes and functions.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.6.0
 */

$idsk_cookie = 0;

/**
 * Cookie shortcode.
 *
 * @param array  $atts    Array of shortcode attributes.
 * @param string $content Shortcode content.
 *
 * @return string
 */
function idsktk_cookie( $atts = array(), $content = null ) {
	$cookie = shortcode_atts(
		array(
			'id'   => '',
			'type' => '',
		),
		$atts
	);

	if ( idsktk_cookies_allowed( $cookie['id'], $cookie['type'] ) ) {
		return do_shortcode( $content );
	}
}
add_shortcode( 'idsk-cookie', 'idsktk_cookie' );

/**
 * Cookie checkbox shortcode.
 *
 * @param array  $atts    Array of shortcode attributes.
 * @param string $content Shortcode content.
 *
 * @return string
 */
function idsktk_cookie_check( $atts = array(), $content = null ) {
	$cookie = shortcode_atts(
		array(
			'id'    => 'idskCookies',
			'title' => '',
		),
		$atts
	);

	$checked = 'idskCookies' !== $cookie['id'] ? idsktk_cookies_allowed( $cookie['id'] ) : true;

	$form = '<div class="govuk-form-group">
		<div class="govuk-checkboxes">
			<div class="govuk-checkboxes__item">
				<input class="govuk-checkboxes__input idsk-cookies-allow" id="' . esc_attr( $cookie['id'] ) . '" name="" type="checkbox" value="" ' . ( $checked ? 'checked=""' : '' ) . ' ' . ( 'idskCookies' === $cookie['id'] ? 'disabled=""' : '' ) . '>
				<label class="govuk-label govuk-checkboxes__label" for="' . esc_attr( $cookie['id'] ) . '">
					' . ( '' !== $cookie['title'] ? esc_html( $cookie['title'] ) : ( 'idskCookies' === $cookie['id'] ? esc_html__( 'Necessary cookies', 'idsk-toolkit' ) : '' ) ) . '
				</label>
			</div>
		</div>
	</div>';

	if ( ! is_null( $content ) && '' !== $content ) {
		$form .= '<div class="govuk-inset-text">';
		$form .= do_shortcode( $content );
		$form .= '</div>';
	}

	return $form;
}
add_shortcode( 'idsk-cookie-allow', 'idsktk_cookie_check' );

/**
 * Cookie accept button shortcode.
 *
 * @param array $atts Array of shortcode attributes.
 *
 * @return string
 */
function idsktk_cookie_accept_btn( $atts = array() ) {
	$button = shortcode_atts(
		array(
			'title' => '',
		),
		$atts
	);

	$content = '<button type="submit" class="idsk-button idsk-cookies-accept idsk-cookies-accept-form" data-module="idsk-button">
		' . ( '' !== $button['title'] ? esc_html( $button['title'] ) : esc_html__( 'Save cookies settings', 'idsk-toolkit' ) ) . '
	</button>';

	return $content;
}
add_shortcode( 'idsk-cookie-submit', 'idsktk_cookie_accept_btn' );

/**
 * Cookies list shortcode.
 *
 * @return string
 */
function idsktk_cookie_list() {
	$content = '<table class="govuk-table">
		<caption class="govuk-table__caption govuk-table__caption--m">' . esc_html__( 'Active cookies', 'idsk-toolkit' ) . '</caption>
		<thead class="govuk-table__head">
			<tr class="govuk-table__row">
				<th scope="col" class="govuk-table__header">' . esc_html__( 'Name', 'idsk-toolkit' ) . '</th>
				<th scope="col" class="govuk-table__header">' . esc_html__( 'Value', 'idsk-toolkit' ) . '</th>
			</tr>
		</thead>
		<tbody class="govuk-table__body">';

	foreach ( $_COOKIE as $key => $val ) {
		$content .= '<tr class="govuk-table__row">';
		$content .= '<th scope="row" class="govuk-table__header">' . esc_html( $key ) . '</th>';
		$content .= '<td class="govuk-table__cell">' . esc_html( $val ) . '</td>';
		$content .= '</tr>';
	}

	$content .= '</tbody>
	</table>';

	return $content;
}
add_shortcode( 'idsk-cookie-list', 'idsktk_cookie_list' );

/**
 * Check for search engines.
 *
 * @return bool
 */
function idsktk_is_search_engine() {
	$engines = array(
		'google',
		'googlebot',
		'yahoo',
		'facebook',
		'twitter',
		'slurp',
		'search.msn.com',
		'nutch',
		'simpy',
		'bot',
		'aspseek',
		'crawler',
		'msnbot',
		'libwww-perl',
		'fast',
		'baidu',
	);

	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		return false;
	}

	$agent = strtolower( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) );

	foreach ( $engines as $engine ) {
		if ( stripos( $agent, $engine ) !== false ) {
			return true;
		}
		return false;
	}
}

/**
 * Get cookie lifetime setting.
 *
 * @return int
 */
function idsktk_cookie_expire() {
	$count = get_theme_mod( 'idsktk_cookies_settings_expiration' ) > 0 ? get_theme_mod( 'idsktk_cookies_settings_expiration' ) : 0;

	switch ( get_theme_mod( 'idsktk_cookies_settings_expiration_type' ) ) {
		case 'day':
			$multi = 1;
			break;
		case 'month':
			$multi = 30;
			break;
		default:
			$multi = 1;
			break;
	}

	return $count * $multi;
}

/**
 * Check if cookies are allowed.
 *
 * @param string $name  Cookie name.
 * @param string $value Cookie type.
 *
 * @return bool
 */
function idsktk_cookies_allowed( $name = '', $value = '' ) {
	global $idsk_cookie;

	if ( ! get_theme_mod( 'idsktk_cookies_settings_banner_heading' ) ) {
		return true;
	}

	$cname = 'idskCookies' . ( '' !== $name ? '_' . $name : '' );

	if ( isset( $_COOKIE[ $cname ] ) || $idsk_cookie ) {
		if ( '' !== $value ) {
			return $value === $_COOKIE[ $cname ] ? true : false;
		}
		return true;
	} else {
		return false;
	}
}
