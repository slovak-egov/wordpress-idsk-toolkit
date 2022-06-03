<?php
/**
 * Custom gutenberg blocks.
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Allowed Gutenberg blocks.
 *
 * @param array $allowed_blocks Array of block type slugs.
 *
 * @return array
 */
function idsktk_allowed_block_types( $allowed_blocks ) {
	return array(
		'core/html',
		'core/paragraph',
		'core/spacer',
		'core/shortcode',
		'core/freeform',
		'core/image',
		'idsk/related-content',
		'idsk/warning-text',
		'idsk/crossroad',
		'idsk/address',
		'idsk/intro',
		'idsk/timeline',
		'idsk/stepper',
		'idsk/card',
		'idsk/row',
		'idsk/column',
		'idsk/map-component',
		'idsk/accordion',
		'idsk/announce',
		'idsk/button',
		'idsk/container',
		'idsk/heading',
		'idsk/details',
		'idsk/inset-text',
		'idsk/lists',
		'idsk/tab',
		'idsk/tabs',
		'idsk/stepper-banner',
		'idsk/separator',
		'idsk/posts',
		'idsk/table',
	);
}

if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
	add_filter( 'allowed_block_types', 'idsktk_allowed_block_types' );
} else {
	add_filter( 'allowed_block_types_all', 'idsktk_allowed_block_types' );
}

/**
 * Custom block categories.
 *
 * @param array                   $categories Array of categories for block types.
 * @param WP_Block_Editor_Context $post       The current block editor context.
 *
 * @return array
 */
function idsktk_gov_page_block_category( $categories, $post ) {
	return array_reverse(
		array_merge(
			$categories,
			array(
				array(
					'slug'  => 'idsk-components',
					'title' => __( 'ID-SK Components', 'idsk-toolkit' ),
				),
			),
			array(
				array(
					'slug'  => 'idsk-grids',
					'title' => __( 'ID-SK Website layout', 'idsk-toolkit' ),
				),
			)
		)
	);
}

if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
	add_filter( 'block_categories', 'idsktk_gov_page_block_category', 10, 2 );
} else {
	add_filter( 'block_categories_all', 'idsktk_gov_page_block_category', 10, 2 );
}
