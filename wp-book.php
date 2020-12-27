<?php
/**
 * Main file for the plugin.
 *
 * @package WordPress
 * Plugin Name: Wp Book
 * Description: This plugin is used to store the information about books.
 * Author:      Pranay Chahare
 * Text-domain: wp-book
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
*Using register_activation_hook to trigger callback that will flush rewrite rules.
*/
register_activation_hook( __FILE__, 'wb_activate_cb' );

/**
 * Callback function to flush rewrite rules.
 */
function wb_activate_cb() {
	flush_rewrite_rules();
}

/**
*Using register_deactivation_hook to trigger callback that will flush rewrite rules.
*/
register_deactivation_hook( __FILE__, 'wb_deactivate_cb' );

/**
 * Callback function to flush rewrit rules on plugin deactivation.
 */
function wb_deactivate_cb() {
	flush_rewrite_rules();
}

/**
*Using plugins_loaded hook to trigger a callback that loads plugin text domain.
*/
add_action( 'plugins_loaded', 'wb_load_text_domain_cb' );

/**
 * Callback to load plugin textdomain.
 */
function wb_load_text_domain_cb() {

	load_plugin_textdomain( 'wp-book', false, dirname( __FILE__ ) . '/languages/' );
}

// loads wp-add-book-type file from includes folder.
require dirname( __FILE__ ) . '/includes/wb-add-book-type.php';

// loads wp-add-taxonomies file from includes folder.
require dirname( __FILE__ ) . '/includes/wb-add-taxonomies.php';

// loads wp-add-meta-box file from includes folder.
require dirname( __FILE__ ) . '/includes/wb-add-meta-box.php';

// loads wp-add-custom-meta-table file from includes folder.
require dirname( __FILE__ ) . '/includes/wb-add-custom-meta-table.php';

// loads wp-add-booksmenu file from includes folder.
require dirname( __FILE__ ) . '/includes/wb-add-booksmenu.php';

// loads wp-add-shortcodes file from includes folder.
require dirname( __FILE__ ) . '/includes/wb-add-shortcodes.php';

// loads wb-add-category-widget file from includes folder.
require dirname( __FILE__ ) . '/includes/class-wb-book-category.php';

// loads wb-add-desktop-widget file from includes folder.
require dirname( __FILE__ ) . '/includes/wb-add-desktop-widget.php';
