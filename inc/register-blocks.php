<?php
/**
 * Custom gutenberg blocks
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

/**
 * Allowed Gutenberg blocks
 *
 * @param $allowed_blocks
 * @return array
 */
function idsktk_allowed_block_types( $allowed_blocks ) {

    return array(
        'core/html',
        'core/paragraph',
        'core/spacer',
        'core/separator',
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
        'idsk/graph-component',
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
    );

}
add_filter( 'allowed_block_types', 'idsktk_allowed_block_types' );

/**
 * new category of blocks
 *
 * @param $categories
 * @param $post
 * @return array
 */
function idsktk_gov_page_block_category ( $categories, $post ) {
    return array_reverse(array_merge(
        $categories,
        array (
            array (
                'slug'  => 'idsk-components',
                'title' => __( 'ID-SK Komponenty', 'idsk-toolkit' ),
            ),
        ),
        array (
            array (
                'slug'  => 'idsk-grids',
                'title' => __( 'ID-SK Rozloženie stránky', 'idsk-toolkit' ),
            ),
        )
    ));
}

add_filter( 'block_categories', 'idsktk_gov_page_block_category', 10, 2 );
