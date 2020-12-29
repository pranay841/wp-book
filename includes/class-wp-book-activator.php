<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/pranay841/
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Pranay Chahare <pranaychahare84@gmail.com>
 */
class Wp_Book_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
			flush_rewrite_rules();
	}

	/**
	 * Callback function to create a custom table using dbDelta().
	 *
	 * @global WPDB $wpdb global database class.
	 */
	public static function wb_add_book_meta_table() {

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

}
