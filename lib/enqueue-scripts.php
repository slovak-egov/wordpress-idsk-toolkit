<?php

/**
 *  Enqueue JavaScript and CSS
 *  for block editor only.
 */
function idsktk_enqueue_block_assets() {
  $deps = ['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components'];
  
  if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
    array_push($deps, 'wp-editor');
  } else {
    array_push($deps, 'wp-block-editor');
  }

  // Enqueue the bundled block JS file
  wp_enqueue_script(
    'idsk/blocks-js',
    plugin_dir_url(__DIR__) . '/assets/js/editor.blocks.js',
    $deps,
    null
  );
  wp_localize_script(
    'idsk/blocks-js',
    'pluginData',
    array(
      'dir' => plugin_dir_url(__DIR__)
    )
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
 * for template.
 */
function idsktk_register_template_scripts () {

  $theme_version = wp_get_theme()->get( 'Version' );

  wp_enqueue_script( 'idsk-js-search', plugin_dir_url(__DIR__).'assets/js/search.js', array (), $theme_version, TRUE );
  
}

add_action( 'wp_enqueue_scripts', 'idsktk_register_template_scripts' );

/**
 * Enqueue JavaScript
 * for cookies.
 */
function idsktk_cookies_script() {
  global $idskCookie;

  $theme_version = wp_get_theme()->get( 'Version' );

  if ( idsktk_is_search_engine() ) {
    $idskCookie = 1;
  }

  $idskCookieData = array(
    'cookieSet'     => ( $idskCookie || idsktk_cookies_allowed() ),
    'cookieExpire'  => idsktk_cookie_expire()
  );

  wp_enqueue_script( 'idsk-js-cookies', plugin_dir_url(__DIR__).'assets/js/cookies.js', array(), $theme_version, TRUE );
  wp_localize_script( 'idsk-js-cookies', 'idsk_cookie_data', $idskCookieData );
}

add_action( 'wp_enqueue_scripts', 'idsktk_cookies_script' );

/**
 * Enqueue JavaScript
 * for admin.
 * 
 * @param int $hook Hook suffix for the current admin page.
 */
function idsktk_admin_enqueue_scripts( $hook ) {
  if ( $hook != 'post.php' && $hook != 'post-new.php' ) {
    return;
  }

  wp_enqueue_script( 'idsk-js-meta-boxes', plugin_dir_url(__DIR__).'assets/js/meta-boxes.js', array (), null, TRUE );
}

add_action( 'admin_enqueue_scripts', 'idsktk_admin_enqueue_scripts' );