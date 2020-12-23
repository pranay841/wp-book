<?php
/**
 * File to create a custom meta boxes for books.
 *
 * @package WordPress
 */

/**
 * Using add_meta_boxes hook to trigger a callback function that creates custom meta boxes.
 */

add_action( 'add_meta_boxes', 'wb_add_meta_box_func' );

/**
 * Callback function to trigger add_meta_box() .
 */
function wb_add_meta_box_func() {
	add_meta_box( 'wb_book_info', 'Book Information', 'wb_book_info_callback', 'Book' );
}
/**
 * Callback function to create custom meta boxes of author name,price,publisher,year,edition and url.
 *
 * @param object $post current post is passed as parameter.
 */
function wb_book_info_callback( $post ) {

	wp_nonce_field( 'wb_save_info', 'wb_save_info_nonce' );

	$wb_author_value         = get_metadata( 'book', $post->ID, 'wb_meta_author_name_key', true );
	$wb_price_value          = get_metadata( 'book', $post->ID, 'wb_meta_price_key', true );
	$wb_publisher_name_value = get_metadata( 'book', $post->ID, 'wb_meta_publisher_name_key', true );
	$wb_year_value           = get_metadata( 'book', $post->ID, 'wb_meta_year_key', true );
	$wb_edition_value        = get_metadata( 'book', $post->ID, 'wb_meta_edition_key', true );
	$wb_url_value            = get_metadata( 'book', $post->ID, 'wb_meta_url_key', true );

	echo '<label for = "wb_meta_author_name" > Author Name: </label>';
	echo '<input id = "wb_meta_author_name" name = "wb_meta_author_name" value = "' . esc_attr( $wb_author_value ) . '"><br/>';

	echo '<label for = "wb_meta_price" > Price: </label>';
	echo '<input id = "wb_meta_price" name = "wb_meta_price" value = "' . esc_attr( $wb_price_value ) . '"><br/>';

	echo '<label for = "wb_meta_publisher_name" > Publisher: </label>';
	echo '<input id = "wb_meta_publisher_name" name = "wb_meta_publisher_name" value = "' . esc_attr( $wb_publisher_name_value ) . '"><br/>';

	echo '<label for = "wb_meta_year" > Year: </label>';
	echo '<input id = "wb_meta_year" name = "wb_meta_year" value = "' . esc_attr( $wb_year_value ) . '"><br/>';

	echo '<label for = "wb_meta_edition" > Edition: </label>';
	echo '<input id = "wb_meta_edition" name = "wb_meta_edition" value = "' . esc_attr( $wb_edition_value ) . '"><br/>';

	echo '<label for = "wb_meta_url" > URL: </label>';
	echo '<input id = "wb_meta_url" name = "wb_meta_url" value = "' . esc_attr( $wb_url_value ) . '"><br/>';

}
/**
*Using save_post hook to save values inserted into custom meta box.
*/

add_action( 'save_post', 'wb_save_book_info' );

/**
 * Function to update the values inserted for custom meta box.
 *
 * @param POST_ID $post_id is a parameter passed that has the id of the current post.
 */
function wb_save_book_info( $post_id ) {
	if ( ! isset( $_POST['wb_save_info_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_key( $_POST['wb_save_info_nonce'] ), 'wb_save_info' ) ) {
		return;
	}
	if ( ! empty( $_POST['wb_meta_author_name'] ) ) {
		$wb_author_name = sanitize_text_field( wp_unslash( $_POST['wb_meta_author_name'] ) );
		update_metadata( 'book', $post_id, 'wb_meta_author_name_key', $wb_author_name );
	}

	if ( ! empty( $_POST['wb_meta_price'] ) ) {
		$wb_price = sanitize_text_field( wp_unslash( $_POST['wb_meta_price'] ) );
		update_metadata( 'book', $post_id, 'wb_meta_price_key', $wb_price );
	}

	if ( ! empty( $_POST['wb_meta_publisher_name'] ) ) {
		$wb_publisher_name = sanitize_text_field( wp_unslash( $_POST['wb_meta_publisher_name'] ) );
		update_metadata( 'book', $post_id, 'wb_meta_publisher_name_key', $wb_publisher_name );
	}

	if ( ! empty( $_POST['wb_meta_year'] ) ) {
		$wb_year = sanitize_text_field( wp_unslash( $_POST['wb_meta_year'] ) );
		update_metadata( 'book', $post_id, 'wb_meta_year_key', $wb_year );
	}

	if ( ! empty( $_POST['wb_meta_edition'] ) ) {
		$wb_edition = sanitize_text_field( wp_unslash( $_POST['wb_meta_edition'] ) );
		update_metadata( 'book', $post_id, 'wb_meta_edition_key', $wb_edition );
	}

	if ( ! empty( $_POST['wb_meta_url'] ) ) {
		$wb_url = sanitize_text_field( wp_unslash( $_POST['wb_meta_url'] ) );
		update_metadata( 'book', $post_id, 'wb_meta_url_key', $wb_url );
	}

}
