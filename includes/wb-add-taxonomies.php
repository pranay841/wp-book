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
		'search_items'               => __( 'Search Book Categories', 'wp-book' ),
		'popular_items'              => __( 'Popular Book Categories', 'wp-book' ),
		'all_items'                  => __( 'All Book Categories', 'wp-book' ),
		'parent_item'                => __( 'Parent Book Category', 'wp-book' ),
		'parent_item_colon'          => __( 'Parent Book Category:', 'wp-book' ),
		'edit_item'                  => __( 'Edit Book Category', 'wp-book' ),
		'update_item'                => __( 'Update Book Category', 'wp-book' ),
		'add_new_item'               => __( 'Add New Book Category', 'wp-book' ),
		'new_item_name'              => __( 'New Book Category Name', 'wp-book' ),
		'separate_items_with_commas' => __( 'Separate Book Categories with commas', 'wp-book' ),
		'add_or_remove_items'        => __( 'Add or remove book categories', 'wp-book' ),
		'choose_from_most_used'      => __( 'Choose from the most used book categories', 'wp-book' ),
		'not_found'                  => __( 'Not found.', 'wp-book' ),
		'menu_name'                  => __( 'Book Categories', 'wp-book' ),
	);
	$category_args   = array(
		'label'             => __( 'Book Category', 'wp-book' ),
		'labels'            => $category_labels,
		'public'            => true,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,

	);

	register_taxonomy( 'Book Category', 'book', $category_args );

	$tag_labels = array(
		'name'                       => _x( 'Book Tags', 'taxonomy general name', 'wp-book' ),
		'singular_name'              => _x( 'Book Tag', 'taxonomy singular name', 'wp-book' ),
		'search_items'               => __( 'Search Book Tags', 'wp-book' ),
		'popular_items'              => __( 'Popular Book Tags', 'wp-book' ),
		'all_items'                  => __( 'All Book Tags', 'wp-book' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Book Tag', 'wp-book' ),
		'update_item'                => __( 'Update Book Tag', 'wp-book' ),
		'add_new_item'               => __( 'Add New Book Tag', 'wp-book' ),
		'new_item_name'              => __( 'New Book Tag Name', 'wp-book' ),
		'separate_items_with_commas' => __( 'Separate Book Tags with commas', 'wp-book' ),
		'add_or_remove_items'        => __( 'Add or remove book tags', 'wp-book' ),
		'choose_from_most_used'      => __( 'Choose from the most used book tags', 'wp-book' ),
		'not_found'                  => __( 'Not found.', 'wp-book' ),
		'menu_name'                  => __( 'Book Tags', 'wp-book' ),
	);
	$tag_args   = array(
		'labels'            => $tag_labels,
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,

	);
		register_taxonomy( 'Book Tag', 'book', $tag_args );
}
