<?php
/**
 * Custom REST API.
 *
 * Restricted API for custom gutenberg blocks.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Get data from theme settings.
 *
 * @return WP_Error|WP_REST_Response
 */
function idsktk_get_theme_settings() {
	$data = array(
		'gmap_api' => get_theme_mod( 'idsktk_main_settings_map_api' ),
	);

	if ( empty( $data ) ) {
		return new WP_Error( 'no_data', 'No data found', array( 'status' => 404 ) );
	}

	return new WP_REST_Response( $data );
}

/**
 * Check for current user permission.
 *
 * @return bool
 */
function idsktk_rest_perm_callback() {
	return current_user_can( 'edit_posts' );
}

/**
 * Custom REST API initialization.
 */
function idsktk_rest_api_init() {
	register_rest_route(
		'idsk/v1',
		'/settings',
		array(
			'methods'             => 'GET',
			'callback'            => 'idsktk_get_theme_settings',
			'permission_callback' => 'idsktk_rest_perm_callback',
		)
	);
}
add_action( 'rest_api_init', 'idsktk_rest_api_init' );
