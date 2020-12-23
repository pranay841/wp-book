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
