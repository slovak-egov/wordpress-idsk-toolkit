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
