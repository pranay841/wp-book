<?php
/**
 * File to create a custom taxonomies for book.
 *
 * @package WordPress
 */

/**
 * Occurs at the initialisation,to create custom taxonomies.
 */
add_action( 'init', 'wb_add_tax' );

/**
 * Callback function to add custom taxonomy.
 */
function wb_add_tax() {
	$category_labels = array(
		'name'                       => _x( 'Book Categories', 'taxonomy general name', 'wp-book' ),
		'singular_name'              => _x( 'Book Category', 'taxonomy singular name', 'wp-book' ),
		'search_items'               => __( 'Search Books', 'wp-book' ),
		'popular_items'              => __( 'Popular Books', 'wp-book' ),
		'all_items'                  => __( 'All Books', 'wp-book' ),
		'parent_item'                => __( 'Parent Book', 'wp-book' ),
		'parent_item_colon'          => __( 'Parent Book:', 'wp-book' ),
		'edit_item'                  => __( 'Edit Book', 'wp-book' ),
		'update_item'                => __( 'Update Book', 'wp-book' ),
		'add_new_item'               => __( 'Add New Book', 'wp-book' ),
		'new_item_name'              => __( 'New Book Name', 'wp-book' ),
		'separate_items_with_commas' => __( 'Separate Books with commas', 'wp-book' ),
		'add_or_remove_items'        => __( 'Add or remove books', 'wp-book' ),
		'choose_from_most_used'      => __( 'Choose from the most used books', 'wp-book' ),
		'not_found'                  => __( 'No books found.', 'wp-book' ),
		'menu_name'                  => __( 'Book Categories', 'wp-book' ),
	);
	$category_args   = array(
		'label'             => __( 'Book Category', 'wp-book' ),
		'labels'            => $category_labels,
		'public'            => true,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,

	);

	register_taxonomy( 'Book Category', 'book', $category_args );

	$tag_labels = array(
		'name'                       => _x( 'Book Tags', 'taxonomy general name', 'wp-book' ),
		'singular_name'              => _x( 'Book Tag', 'taxonomy singular name', 'wp-book' ),
		'search_items'               => __( 'Search Books', 'wp-book' ),
		'popular_items'              => __( 'Popular Books', 'wp-book' ),
		'all_items'                  => __( 'All Books', 'wp-book' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Book', 'wp-book' ),
		'update_item'                => __( 'Update Book', 'wp-book' ),
		'add_new_item'               => __( 'Add New Book', 'wp-book' ),
		'new_item_name'              => __( 'New Book Name', 'wp-book' ),
		'separate_items_with_commas' => __( 'Separate Books with commas', 'wp-book' ),
		'add_or_remove_items'        => __( 'Add or remove books', 'wp-book' ),
		'choose_from_most_used'      => __( 'Choose from the most used books', 'wp-book' ),
		'not_found'                  => __( 'No books found.', 'wp-book' ),
		'menu_name'                  => __( 'Book Tags', 'wp-book' ),
	);
	$tag_args   = array(
		'labels'            => $tag_labels,
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,

	);
		register_taxonomy( 'Book Tag', 'book', $tag_args );
}
