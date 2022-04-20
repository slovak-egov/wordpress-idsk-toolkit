<?php
/**
 * Gutenberg block editor adjustments.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Disable support for custom text color in WYSIWYG editor.
 *
 * @param array $buttons Second-row list of buttons.
 *
 * @return array
 */
function idsktk_remove_text_color_from_mce( $buttons ) {
	array_splice( $buttons, array_search( 'forecolor', $buttons, true ), 1 );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'idsktk_remove_text_color_from_mce' );

/**
 * Disable block editor color palette and custom colors.
 */
function idsktk_gutenberg_disable_all_colors() {
	add_theme_support( 'editor-color-palette', array() );
	add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'idsktk_gutenberg_disable_all_colors' );
