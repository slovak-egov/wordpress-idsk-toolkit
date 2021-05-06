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
 * Version:           1.1.0
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

// Add backend styles for Gutenberg.
add_action('enqueue_block_editor_assets', 'gutenberg_editor_assets');

function gutenberg_editor_assets() {
    // Load the theme styles within Gutenberg.
    wp_enqueue_style('my-gutenberg-editor-styles', get_template_directory_uri().'/assets/css/gutenberg-editor-styles.css', FALSE);
}

// Registering blocks
/**
 * Block, ACF functions
 */
require plugin_dir_path(__FILE__) . '/inc/register-blocks.php';
require plugin_dir_path(__FILE__) . '/inc/acf-settings.php';

/* Custom gutenberg IDSK blocks */
require plugin_dir_path(__FILE__) . '/blocks/index.php';

// Enqueue JS and CSS
require plugin_dir_path(__FILE__) . '/lib/enqueue-scripts.php';