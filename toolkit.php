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
 * Version:           1.0.0
 * Requires at least: 5.4
 * Requires PHP:      7.0
 * Author:            SlovenskoIT a.s.
 * Author URI:        https://slovenskoit.sk
 * Text Domain:       idsk.gov.sk
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

include 'inc/custom-shortcodes.php';
include 'inc/frontend.php';
include 'inc/block-editor-adjustments.php';

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Register Custom Post Type
function idsk_post_type() {
    $labels = array(
        'name'                  => _x( 'Aktuality inštitúcií', 'Post Type General Name', 'idsk' ),
        'singular_name'         => _x( 'Aktuality inštitúcií', 'Post Type Singular Name', 'idsk' ),
        'menu_name'             => __( 'Aktuality inštitúcií', 'idsk' ),
        'name_admin_bar'        => __( 'Aktuality inštitúcií', 'idsk' ),
        'all_items'             => __( 'Zobraziť všetky', 'idsk' ),
        'add_new_item'          => __( 'Pridať nový', 'idsk' ),
        'add_new'               => __( 'Pridať nový', 'idsk' ),
        'new_item'              => __( 'Pridať nový', 'idsk' ),
        'edit_item'             => __( 'Editovať', 'idsk' ),
        'update_item'           => __( 'Aktualizovať', 'idsk' ),
        'view_item'             => __( 'Zobraziť', 'idsk' ),
        'view_items'            => __( 'Zobraziť', 'idsk' ),
        'search_items'          => __( 'Hľadať', 'idsk' ),
        'not_found'             => __( 'Nenájdený', 'idsk' ),
        'not_found_in_trash'    => __( 'Nenájdený v koši', 'idsk' ),
        'featured_image'        => __( 'Obrázok', 'idsk' ),
        'set_featured_image'    => __( 'Vložiť obrázok', 'idsk' ),
        'remove_featured_image' => __( 'Vymazať obrázok', 'idsk' ),
        'use_featured_image'    => __( 'Použiť obrázok', 'idsk' ),
    );
    $args = array(
        'label'                 => __( 'Aktuality inštitúcií', 'idsk' ),
        'description'           => __( 'Aktuality inštitúcií', 'idsk' ),
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
add_action( 'init', 'idsk_post_type', 0 );

// Register Custom Taxonomy
function idsk_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Kategórie aktualít', 'Taxonomy General Name', 'idsk' ),
        'singular_name'              => _x( 'Kategórie', 'Taxonomy Singular Name', 'idsk' ),
        'menu_name'                  => __( 'Kategórie aktualít', 'idsk' ),
        'all_items'                  => __( 'Zobraziť všetky', 'idsk' ),
        'new_item_name'              => __( 'Názov', 'idsk' ),
        'add_new_item'               => __( 'Pridať nový', 'idsk' ),
        'edit_item'                  => __( 'Upraviť', 'idsk' ),
        'update_item'                => __( 'Aktualizovať', 'idsk' ),
        'view_item'                  => __( 'Zobraziť', 'idsk' ),
        'add_or_remove_items'        => __( 'Pridať alebo zmazať', 'idsk' ),
        'search_items'               => __( 'Vyhľadať', 'idsk' ),
        'not_found'                  => __( 'Nenájdený', 'idsk' ),
        'no_terms'                   => __( 'Nenájdený', 'idsk' ),
        'items_list'                 => __( 'Zoznam', 'idsk' ),
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
add_action( 'init', 'idsk_taxonomy', 0 );

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