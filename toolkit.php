<?php
/**
 * ID-SK Toolkit
 *
 * @package           IdskToolkit
 * @author            SlovenskoIT a.s.
 * @copyright         2021 SlovenskoIT a.s.
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       ID-SK Toolkit
 * Description:       Features toolkit for ID-SK theme.
 * Version:           1.6.0
 * Requires at least: 5.4
 * Requires PHP:      7.0
 * Author:            SlovenskoIT a.s.
 * Author URI:        https://slovenskoit.sk
 * Text Domain:       idsk-toolkit
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

include 'inc/block-editor-adjustments.php';

remove_filter('widget_text_content', 'wpautop');

function idsktk_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'idsktk_mime_types');

// Translations
function idsktk_load_textdomain() {
    load_plugin_textdomain( 'idsk-toolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'idsktk_load_textdomain' );

// Custom metaboxes
require plugin_dir_path(__FILE__) . '/inc/register-meta.php';

// Customizer options
require plugin_dir_path(__FILE__) . '/lib/template-customizer.php';

/**
 * Custom REST API - restricted
 *
 */
function idsktk_get_theme_settings() {
    $data = array(
        "gmap_api" => get_theme_mod('idsktk_main_settings_map_api'),
    );
   
    if ( empty( $data ) ) {
        return new WP_Error( 'no_data', 'No data found', array( 'status' => 404 ) );
    }
   
    return new WP_REST_Response( $data );
}

function idsktk_rest_perm_callback() {
    return current_user_can( 'edit_posts' );
}
function idsktk_rest_api_init() {
    register_rest_route( 'idsk/v1', '/settings', array(
        'methods' => 'GET',
        'callback' => 'idsktk_get_theme_settings',
        'permission_callback' => 'idsktk_rest_perm_callback'
    ) );
}
add_action( 'rest_api_init', 'idsktk_rest_api_init' );

/**
 * Custom search properties
 */
// Custom search query vars
function idsktk_query_vars( $qvars ) {
    $qvars[] = 'scat';
    $qvars[] = 'tags';
    $qvars[] = 'datum-od';
    $qvars[] = 'datum-do';
    return $qvars;
}
add_filter( 'query_vars', 'idsktk_query_vars' );

/**
 * Custom search
 */
function idsktk_advanced_search_query( $query ) {

    if ( ! is_admin() && $query->is_search && $query->is_main_query() ) {

        // Store query params
        $search_string = get_query_var( 's' );
        $order = get_query_var( 'order' );
        $order_by = get_query_var( 'orderby' );
        $category = get_query_var( 'cat' );
        $sub_category = get_query_var( 'scat' );
        $date_from = get_query_var( 'datum-od' );
        $date_to = get_query_var( 'datum-do' );
        // Get tags array
        $tags = get_query_var( 'tags' );
        // Query arrays
        $tax_query = array();
        $date_query = array();

        // Set up query params
        $query->set('posts_per_page', -1);

        if ( !empty( $search_string ) ) {
            $query->set('s', $search_string);
        }

        if ( !empty( $order ) ) {
            $query->set('order', $order);
        } elseif ( empty( $order ) && empty( $order_by ) ) {
            $query->set('order', 'DESC');
        }

        if ( !empty( $order_by ) ) {
            $query->set('orderby', $order_by);
        }

        // Search categories
        if ( !empty($category) || !empty($sub_category) ) {
            $tax_query = array(
                !empty($category) ?
                    array(
                        'taxonomy' 			=> 'category',
                        'field'				=> 'id',
                        'terms'				=> $category
                    ) : '',
                !empty($sub_category) ?
                    array(
                        'taxonomy' 			=> 'category',
                        'field'				=> 'id',
                        'terms'				=> $sub_category
                    ) : ''
            );
            $query->set('tax_query', $tax_query);
        }
        
        // Search tags
        if ( !empty( $tags ) && $tags[0] != '' ) {
            $query->set('tag__and', $tags);
        }

        // Search by updated
        if ( !empty($date_from) || !empty($date_to) ) {
            $date_query = array(
                'column' => 'post_modified',
            );

            if (!empty($date_from)) {
                $df = explode('.', $date_from);

                if (count($df) == 1) {
                    $date_query['after'] = array(
                        'year'  => $df[0]
                    );
                } elseif (count($df) == 3) {
                    $date_query['after'] = array(
                        'year'  => $df[2],
                        'month' => $df[1],
                        'day'   => $df[0],
                    );
                }
            }
            
            if (!empty($date_to)) {
                $dt = explode('.', $date_to);
                
                if (count($dt) == 1) {
                    $date_query['before'] = array(
                        'year'  => $dt[0]
                    );
                } elseif (count($dt) == 3) {
                    $date_query['before'] = array(
                        'year'  => $dt[2],
                        'month' => $dt[1],
                        'day'   => $dt[0],
                    );
                }
            }
        }

        // Set date_query
        if( count( $date_query ) > 0 ){
            $query->set('date_query', $date_query);
        }

    }

}
add_action( 'pre_get_posts', 'idsktk_advanced_search_query' );

// Add backend styles for Gutenberg.
add_action('enqueue_block_editor_assets', 'idsktk_gutenberg_editor_assets');

function idsktk_gutenberg_editor_assets() {
    // Load the theme styles within Gutenberg.
    wp_enqueue_style('my-gutenberg-editor-styles', plugin_dir_url(__FILE__).'/assets/css/gutenberg-editor-styles.css', FALSE);
}

// Registering blocks
/**
 * Blocks, patterns
 */
require plugin_dir_path(__FILE__) . '/inc/register-blocks.php';
require plugin_dir_path(__FILE__) . '/inc/register-patterns.php';

/* Custom gutenberg IDSK blocks */
require plugin_dir_path(__FILE__) . '/blocks/index.php';

/**
 * Cookies
 */
require plugin_dir_path(__FILE__) . '/inc/cookies-frontend.php';

// Enqueue JS and CSS
require plugin_dir_path(__FILE__) . '/lib/enqueue-scripts.php';