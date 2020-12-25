<?php
/**
 * Main file for the plugin.
 *
 * @package WordPress
 * Plugin Name: Wp Book
 * Description: This plugin is used to store the information about books.
 * Author:      Pranay Chahare
 * Text-domain: wp-book
 */

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
