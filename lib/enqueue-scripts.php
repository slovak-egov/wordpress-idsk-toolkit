<?php

/**
 *  Enqueue JavaScript and CSS
 *  for block editor only.
 */
function idsktk_enqueue_block_assets() {
  // Enqueue the bundled block JS file
  wp_enqueue_script(
    'idsk/blocks-js',
    plugin_dir_url(__DIR__) . '/assets/js/editor.blocks.js',
    ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-editor'],
    null
  );

  // Enqueue optional editor-only styles
  wp_enqueue_style(
    'idsk/editor-all',
    plugin_dir_url(__DIR__) . '/assets/css/blocks.all.css',
    [],
    null
  );
  wp_enqueue_style(
    'idsk/editor-blocks-all',
    plugin_dir_url(__DIR__) . '/assets/css/blocks.editor-all.css',
    [],
    null
  );
}

add_action('enqueue_block_editor_assets', 'idsktk_enqueue_block_assets');

/**
 * Enqueue JavaScript and CSS
 * for template
 */
function idsktk_register_template_scripts () {

  $theme_version = wp_get_theme()->get( 'Version' );

  wp_enqueue_script( 'idsk-js-search', plugin_dir_url(__DIR__).'assets/js/search.js', array (), $theme_version, TRUE );
  
}

add_action( 'wp_enqueue_scripts', 'idsktk_register_template_scripts' );