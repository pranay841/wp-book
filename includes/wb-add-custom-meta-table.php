<?php
/**
 * File to create a custom meta table for books.
 *
 * @package WordPress
 */

/**
 * Using register activation hook so that the custom table is created once the plugin is activated.
 */
register_activation_hook( __FILE__, 'wb_add_book_meta_table' );
/**
 * Callback function to create a custom table using dbDelta().
 *
 * @global WPDB $wpdb global database class.
 */
function wb_add_book_meta_table() {

	global $wpdb;
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$table_name = $wpdb->prefix . 'bookmeta';

	$charset_collate = $wpdb->get_charset_collate();

	$wb_sql = "CREATE TABLE $table_name (
		meta_id bigint(20) unsigned NOT NULL auto_increment,
		book_id bigint(20) unsigned NOT NULL default '0',
		meta_key varchar(255) default NULL,
		meta_value longtext,
		PRIMARY KEY  (meta_id),
		KEY book (book_id),
		KEY meta_key (meta_key(191))
	) $charset_collate;";

	dbDelta( $wb_sql );
}



/**
*Using plugins_loaded hook to trigger call back that links meta api with custom table.
*/
add_action( 'plugins_loaded', 'wb_meta_link_wpdb' );

/**
 * Callback function that links meta api with the custom meta table book.
 *
 * @global WPDB $wpdb is a global database class.
 */
function wb_meta_link_wpdb() {

	global $wpdb;

	$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';

}
