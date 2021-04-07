<?php
/**
 * GRID - column - register column block
 *
 * @link https://slovenskoit.sk
 *
 * @package WordPress
 * @subpackage ID-SK
 * @since ID-SK 1.0
 */

function idsktk_register_column_grid() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
      return;
  }

  // Hook server side rendering into render callback
  register_block_type('idsk/column', array(
      'render_callback' => 'idsktk_render_column_grid'
  ));
}
add_action('init', 'idsktk_register_column_grid');
    
function idsktk_render_column_grid($attributes, $content) {
  return $content; // Print column data
}