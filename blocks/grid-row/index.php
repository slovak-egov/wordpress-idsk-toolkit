<?php
/**
 * GRID - row - register grid block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_row_grid() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }
  
    // Hook server side rendering into render callback
    register_block_type('idsk/row', array(
        'render_callback' => 'idsktk_render_row_grid'
    ));
}
add_action('init', 'idsktk_register_row_grid');

function idsktk_render_row_grid($attributes, $content) {
    return $content; // Print row data
}