<?php
/**
 * Enqueue custom JavaScript and CSS.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Custom blocks assets.
 */
function idsktk_enqueue_block_assets() {
	global $idsktk_version;

	$deps = array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components' );

	if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
		array_push( $deps, 'wp-editor' );
	} else {
		array_push( $deps, 'wp-block-editor' );
	}

	// Enqueue the bundled block JS file.
	wp_enqueue_script(
		'idsk-blocks-js',
		plugins_url( 'assets/js/editor.blocks.js', __DIR__ ),
		$deps,
		$idsktk_version,
		true
	);
	wp_localize_script(
		'idsk-blocks-js',
		'pluginData',
		array(
			'dir' => plugin_dir_url( __DIR__ ),
		)
	);
	wp_set_script_translations( 'idsk-blocks-js', 'idsk-toolkit' );

	// Enqueue optional editor-only styles.
	wp_enqueue_style(
		'idsk/editor-gutenberg-styles',
		plugin_dir_url( __DIR__ ) . '/assets/css/gutenberg-editor-styles.css',
		array(),
		$idsktk_version
	);
	wp_enqueue_style(
		'idsk/editor-all',
		plugin_dir_url( __DIR__ ) . '/assets/css/blocks.all.css',
		array(),
		$idsktk_version
	);
	wp_enqueue_style(
		'idsk/editor-blocks-all',
		plugin_dir_url( __DIR__ ) . '/assets/css/blocks.editor-all.css',
		array(),
		$idsktk_version
	);
}
add_action( 'enqueue_block_editor_assets', 'idsktk_enqueue_block_assets' );

/**
 * Advanced search assets.
 */
function idsktk_register_template_scripts() {
	global $idsktk_version;

	wp_enqueue_script(
		'idsk-js-search',
		plugin_dir_url( __DIR__ ) . 'assets/js/search.js',
		array(),
		$idsktk_version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'idsktk_register_template_scripts' );

/**
 * Cookies assets.
 */
function idsktk_cookies_script() {
	global $idsktk_version;
	global $idsk_cookie;

	if ( idsktk_is_search_engine() ) {
		$idsk_cookie = 1;
	}

	$idsk_cookie_data = array(
		'cookieSet'    => ( $idsk_cookie || idsktk_cookies_allowed() ),
		'cookieExpire' => idsktk_cookie_expire(),
	);

	wp_enqueue_script(
		'idsk-js-cookies',
		plugin_dir_url( __DIR__ ) . 'assets/js/cookies.js',
		array(),
		$idsktk_version,
		true
	);
	wp_localize_script(
		'idsk-js-cookies',
		'idsk_cookie_data',
		$idsk_cookie_data
	);
}
add_action( 'wp_enqueue_scripts', 'idsktk_cookies_script' );

/**
 * Meta boxes assets.
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function idsktk_admin_enqueue_scripts( $hook ) {
	global $idsktk_version;

	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}

	wp_enqueue_script(
		'idsk-js-meta-boxes',
		plugin_dir_url( __DIR__ ) . 'assets/js/meta-boxes.js',
		array(),
		$idsktk_version,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'idsktk_admin_enqueue_scripts' );
