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
        'acf/section-accordion-open',
        'acf/section-accordion-open-body',
        'acf/section-accordion-close',
        'acf/section-accordion-close-body',
        'acf/section-tab-open',
        'acf/section-tab-section-open',
        'acf/section-tab-section-close',
        'acf/section-tab-close',
        'acf/section-announce',
        'acf/section-button',
        'acf/section-heading',
        'acf/section-hidden',
        'acf/section-lists',
        'acf/section-inset',
        'acf/section-row-open',
        'acf/section-row-close',
        'acf/section-col-open',
        'acf/section-col-close',
        'acf/section-container-open',
        'acf/section-container-close',
        'acf/section-news',
        'idsk/related-content',
        'idsk/warning-text',
        'idsk/crossroad',
        'idsk/address',
        'idsk/intro',
        'idsk/card',
        'davidyeiser-detailer/book-details',
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
                'slug'  => 'gov-blocks-container',
                'title' => __( 'GOV ID-SK kontajner', 'idsk-toolkit' ),
            ),
        ),
        array (
            array (
                'slug'  => 'gov-blocks-grid',
                'title' => __( 'GOV ID-SK rozloženie stránky', 'idsk-toolkit' ),
            ),
        ),
        array (
            array (
                'slug'  => 'gov-blocks-tabs',
                'title' => __( 'GOV ID-SK tab element', 'idsk-toolkit' ),
            ),
        ),
        array(
            array(
                'slug' => 'gov-blocks-accordion',
                'title' => __( 'GOV ID-SK accordion', 'idsk-toolkit' ),
            ),
        ),
        array (
            array (
                'slug'  => 'gov-blocks',
                'title' => __( 'GOV ID-SK bloky', 'idsk-toolkit' ),
            ),
        )
    ));
}

add_filter( 'block_categories', 'idsktk_gov_page_block_category', 10, 2 );

/**
 * Register ACF blocks
 */
//require plugin_dir_path(__DIR__) . '/blocks/block-example/block.php';
//require plugin_dir_path(__DIR__) . '/blocks/block-images/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-accordion/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-heading/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-announce/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-inset/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-hidden/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-button/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-lists/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-tab/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-grid/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-container/block.php';
require plugin_dir_path(__DIR__) . '/blocks/block-news/block.php';

/**
 * Light editor toolbar
 *
 * @param $toolbars
 * @return mixed
 */
function idsktk_my_toolbars( $toolbars )
{
    $toolbars['ID-GOV Toolbar' ] = array();
    $toolbars['ID-GOV Toolbar' ][1] = array( 'bold' , 'italic' , 'underline', 'link' );

    return $toolbars;
}
add_filter( 'acf/fields/wysiwyg/toolbars' , 'idsktk_my_toolbars'  );
