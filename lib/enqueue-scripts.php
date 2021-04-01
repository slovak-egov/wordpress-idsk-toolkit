<?php

/**
 *  Enqueue JavaScript and CSS
 *  for block editor only.
 */
function enqueue_block_assets() {
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

add_action('enqueue_block_editor_assets', 'enqueue_block_assets');
