<?php
/**
 * File to create a custom post type 'book'.
 *
 * @package WordPress
 */

/**
 * Occurs at the initialisation.
 */

add_action( 'init', 'wb_add_book_type' );

/**
 * Callback function to create a post type of 'book'.
 */
function wb_add_book_type() {
	$args = array(
		'labels'       => array(
			'name'          => __( 'Books', 'wp-book' ),
			'singular_name' => __( 'Book', 'wp-book' ),
		),
		'public'       => true,
		'has_archive'  => true,
		'show_in_rest' => true,
	);
	register_post_type( 'book', $args );
}
