<?php
/**
 * ID-SK Toolkit
 *
 * @package           IdskToolkit
 * @author            ID-SK team <idsk@mirri.gov.sk>
 * @copyright         2025 Ministry of Investments, Regional Development and Informatization of the Slovak Republic
 * @author            SlovenskoIT a.s.
 * @copyright         2021-2024 SlovenskoIT a.s.
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       ID-SK Toolkit
 * Description:       Features toolkit for ID-SK theme.
 * Version:           1.7.3
 * Requires at least: 5.4
 * Requires PHP:      7.0
 * Author:            ID-SK team
 * Author URI:        https://idsk.gov.sk
 * Text Domain:       idsk-toolkit
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

global $idsktk_version;

if ( is_admin() ) {
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugin_data = get_plugin_data( __FILE__ );

	$idsktk_version = $plugin_data['Version'];
}

/**
 * Remove automatic paragraphs in widgets.
 */
remove_filter( 'widget_text_content', 'wpautop' );

/**
 * Required files.
 */
// Customizer options.
require plugin_dir_path( __FILE__ ) . '/lib/template-customizer.php';

// Custom blocks and patterns.
require plugin_dir_path( __FILE__ ) . '/inc/block-editor-adjustments.php';
require plugin_dir_path( __FILE__ ) . '/inc/register-blocks.php';
require plugin_dir_path( __FILE__ ) . '/inc/register-patterns.php';
require plugin_dir_path( __FILE__ ) . '/blocks/index.php';

// Custom metaboxes.
require plugin_dir_path( __FILE__ ) . '/inc/register-meta.php';

// Custom functions.
require plugin_dir_path( __FILE__ ) . '/inc/api.php';
require plugin_dir_path( __FILE__ ) . '/inc/search-advanced.php';
require plugin_dir_path( __FILE__ ) . '/inc/cookies-frontend.php';

// Enqueue JS and CSS.
require plugin_dir_path( __FILE__ ) . '/lib/enqueue-scripts.php';
