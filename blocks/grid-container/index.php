<?php
/**
 * GRID - container - register grid block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_container_grid() {
    // Only load if Gutenberg is available.
    if (!function_exists('register_block_type')) {
        return;
    }
  
    // Hook server side rendering into render callback
    register_block_type('idsk/container');
}
add_action('init', 'idsktk_register_container_grid');