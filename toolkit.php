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
 * Description:       Súbor nástrojov funkcionalít k ID-SK téme.
 * Version:           1.4.2
 * Requires at least: 5.4
 * Requires PHP:      7.0
 * Author:            SlovenskoIT a.s.
 * Author URI:        https://slovenskoit.sk
 * Text Domain:       idsk-toolkit
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

include 'inc/custom-shortcodes.php';
include 'inc/frontend.php';
include 'inc/block-editor-adjustments.php';

remove_filter('widget_text_content', 'wpautop');

function idsk_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'idsk_mime_types');

// Register Custom Post Type
function idsktk_post_type() {
    $labels = array(
        'name'                  => _x( 'Aktuality inštitúcií', 'Post Type General Name', 'idsk-toolkit' ),
        'singular_name'         => _x( 'Aktuality inštitúcií', 'Post Type Singular Name', 'idsk-toolkit' ),
        'menu_name'             => __( 'Aktuality inštitúcií', 'idsk-toolkit' ),
        'name_admin_bar'        => __( 'Aktuality inštitúcií', 'idsk-toolkit' ),
        'all_items'             => __( 'Zobraziť všetky', 'idsk-toolkit' ),
        'add_new_item'          => __( 'Pridať nový', 'idsk-toolkit' ),
        'add_new'               => __( 'Pridať nový', 'idsk-toolkit' ),
        'new_item'              => __( 'Pridať nový', 'idsk-toolkit' ),
        'edit_item'             => __( 'Editovať', 'idsk-toolkit' ),
        'update_item'           => __( 'Aktualizovať', 'idsk-toolkit' ),
        'view_item'             => __( 'Zobraziť', 'idsk-toolkit' ),
        'view_items'            => __( 'Zobraziť', 'idsk-toolkit' ),
        'search_items'          => __( 'Hľadať', 'idsk-toolkit' ),
        'not_found'             => __( 'Nenájdený', 'idsk-toolkit' ),
        'not_found_in_trash'    => __( 'Nenájdený v koši', 'idsk-toolkit' ),
        'featured_image'        => __( 'Obrázok', 'idsk-toolkit' ),
        'set_featured_image'    => __( 'Vložiť obrázok', 'idsk-toolkit' ),
        'remove_featured_image' => __( 'Vymazať obrázok', 'idsk-toolkit' ),
        'use_featured_image'    => __( 'Použiť obrázok', 'idsk-toolkit' ),
    );
    $args = array(
        'label'                 => __( 'Aktuality inštitúcií', 'idsk-toolkit' ),
        'description'           => __( 'Aktuality inštitúcií', 'idsk-toolkit' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes', 'post-formats' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-aside',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => false,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    register_post_type( 'aktuality_institucii', $args );

}
add_action( 'init', 'idsktk_post_type', 0 );

// Register Custom Taxonomy
function idsktk_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Kategórie aktualít', 'Taxonomy General Name', 'idsk-toolkit' ),
        'singular_name'              => _x( 'Kategórie', 'Taxonomy Singular Name', 'idsk-toolkit' ),
        'menu_name'                  => __( 'Kategórie aktualít', 'idsk-toolkit' ),
        'all_items'                  => __( 'Zobraziť všetky', 'idsk-toolkit' ),
        'new_item_name'              => __( 'Názov', 'idsk-toolkit' ),
        'add_new_item'               => __( 'Pridať nový', 'idsk-toolkit' ),
        'edit_item'                  => __( 'Upraviť', 'idsk-toolkit' ),
        'update_item'                => __( 'Aktualizovať', 'idsk-toolkit' ),
        'view_item'                  => __( 'Zobraziť', 'idsk-toolkit' ),
        'add_or_remove_items'        => __( 'Pridať alebo zmazať', 'idsk-toolkit' ),
        'search_items'               => __( 'Vyhľadať', 'idsk-toolkit' ),
        'not_found'                  => __( 'Nenájdený', 'idsk-toolkit' ),
        'no_terms'                   => __( 'Nenájdený', 'idsk-toolkit' ),
        'items_list'                 => __( 'Zoznam', 'idsk-toolkit' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => false,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'kategorie_aktuality_institucii', array( 'aktuality_institucii' ), $args );
}
add_action( 'init', 'idsktk_taxonomy', 0 );


/**
 * get values of meta boxes
 *
 * @param $value
 * @return bool|mixed|string
 */
function idsktk_back_button_get_meta ( $value ) {
    global $post;

    $field = get_post_meta( $post->ID, $value, TRUE );
    if ( !empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return FALSE;
    }
}

/**
 * add metaboxes
 */
function idsktk_back_button_add_meta_box () {
    add_meta_box(
        'idsktk_back_button',
        __( 'Tlačidlo späť', 'idsk-toolkit' ),
        'idsktk_back_button_html',
        'page',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'idsktk_back_button_add_meta_box' );

/**
 * display metaboxes
 *
 * @param $post
 */
function idsktk_back_button_html ( $post ) {
    wp_nonce_field( '_idsktk_back_button_nonce', 'idsktk_back_button_nonce' ); ?>

    <p>
        <label for="idsktk_back_button_text"><?php esc_html_e( 'Text pre tlačidlo späť', 'idsk-toolkit' ); ?></label>
        <input type="text" name="idsktk_back_button_text" id="idsktk_back_button_text"
                value="<?php echo esc_attr( idsktk_back_button_get_meta( 'idsktk_back_button_text' ) ); ?>">
    </p>
    <p>
    <label for="idsktk_back_button_url"><?php esc_html_e( 'URL pre tlačidlo späť (ak ostane prázdne, späť sa nezobrazí)', 'idsk-toolkit' ); ?></label>
    <input type="text" name="idsktk_back_button_url" id="idsktk_back_button_url"
            value="<?php echo esc_url( idsktk_back_button_get_meta( 'idsktk_back_button_url' ) ); ?>">
    </p><?php
}

/**
 * save metaboxes
 *
 * @param $post_id
 */
function idsktk_back_button_save ( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( !isset( $_POST['idsktk_back_button_nonce'] ) || !wp_verify_nonce( $_POST['idsktk_back_button_nonce'], '_idsktk_back_button_nonce' ) )
        return;
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

    if ( isset( $_POST['idsktk_back_button_text'] ) )
        update_post_meta( $post_id, 'idsktk_back_button_text', esc_attr( $_POST['idsktk_back_button_text'] ) );
    if ( isset( $_POST['idsktk_back_button_url'] ) )
        update_post_meta( $post_id, 'idsktk_back_button_url', esc_url( $_POST['idsktk_back_button_url'] ) );
}
add_action( 'save_post', 'idsktk_back_button_save' );

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
function idsk_query_vars( $qvars ) {
    $qvars[] = 'scat';
    $qvars[] = 'tags';
    $qvars[] = 'datum-od';
    $qvars[] = 'datum-do';
    return $qvars;
}
add_filter( 'query_vars', 'idsk_query_vars' );

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
add_action('enqueue_block_editor_assets', 'gutenberg_editor_assets');

function gutenberg_editor_assets() {
    // Load the theme styles within Gutenberg.
    wp_enqueue_style('my-gutenberg-editor-styles', plugin_dir_url(__FILE__).'/assets/css/gutenberg-editor-styles.css', FALSE);
}

// Registering blocks
/**
 * Block, ACF functions
 */
require plugin_dir_path(__FILE__) . '/inc/register-blocks.php';

/* Custom gutenberg IDSK blocks */
require plugin_dir_path(__FILE__) . '/blocks/index.php';

// Enqueue JS and CSS
require plugin_dir_path(__FILE__) . '/lib/enqueue-scripts.php';