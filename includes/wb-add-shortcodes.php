<?php
/**
 * File to add shortcodes for books.
 *
 * @package WordPress
 */

/**
 * USing init hook to trigger a callcack that will register a shortcode.
 */
add_action( 'init', 'wb_register_shortcode' );

/**
 * Callback function to add_shortode 'book'.
 */
function wb_register_shortcode() {
	add_shortcode( 'book', 'wb_book_shortcode_cb' );
}

/**
 * Callback function to handle the input by the user.
 *
 * This function has a dynamic args array that is altered as per input given by the user ans that is passed to the
 * query to get the posts satisfying those condition.
 *
 * @param Attributes $atts this contains values of all the attributes passed by the user with book shortcode.
 * @global Wpdb $wpdb is a global class to access database.
 */
function wb_book_shortcode_cb( $atts ) {
	global $wpdb;
	$result_array       = array();
	$result_output      = '';
	$book_id_given      = false;
	$ids_of_common_meta = array();

	$a = shortcode_atts(
		array(
			'id'          => '',
			'author_name' => '',
			'year'        => '',
			'category'    => '',
			'tag'         => '',
			'publisher'   => '',
		),
		$atts
	);

	$args = array(
		'post_type' => 'book',
		'post__in'  => array( null ),
		'tax_query' => array(                                                       // phpcs:ignore
			'relation' => 'AND',
		),
	);

	foreach ( $a as $key => $value ) {
		if ( '' !== $value ) {
			if ( 'id' === $key ) {
				$args['post__in'][] = $value;
				$book_id_given      = true;

			}

			if ( 'category' === $key || 'tag' === $key ) {

				$args['tax_query'][] = array(
					'taxonomy' => ( 'category' === $key ) ? 'Book Category' : 'Book Tag',
					'field'    => 'slug',
					'terms'    => $value,
				);
			}

			if ( 'author_name' === $key || 'year' === $key || 'publisher' === $key ) {

				$wb_meta_key = 'author_name' === $key ? 'wb_meta_author_name_key' : ( 'publisher' === $key ? 'wb_meta_publisher_name_key' : 'wb_meta_year_key' );

				$returned_ids_array = $wpdb->get_results( $wpdb->prepare( "select book_id from $wpdb->bookmeta where meta_key=%s and meta_value = %s", $wb_meta_key, $value ), ARRAY_N );// db call ok;no-cache ok.
				$temp_id_store      = array(); // storing the values retrived for meta query temporarily.
				foreach ( $returned_ids_array as $inner_array ) {
					foreach ( $inner_array as $book_id ) {

							$temp_id_store[] = $book_id;

					}
				}
				if ( empty( $ids_of_common_meta ) ) {
					$ids_of_common_meta = $temp_id_store;

				} else {
					$ids_of_common_meta = array_intersect( $ids_of_common_meta, $temp_id_store );// previous values that have the current key value match as well will remain.
				}
			}
		};

	}

	if ( $book_id_given && ! in_array( $args['post__in'][1], $ids_of_common_meta, true ) ) {
		return;
	}
	if ( ! $book_id_given ) {
		$args['post__in'] = array( ...$ids_of_common_meta );
	}

	$query = new Wp_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$result_array[] = array(
				'title'       => get_the_title(),
				'author_name' => get_metadata( 'book', get_the_ID(), 'wb_meta_author_name_key', true ),
				'price'       => get_metadata( 'book', get_the_ID(), 'wb_meta_price_key', true ),
				'currency'    => get_metadata( 'book', get_the_ID(), 'wb_currency', true ),
				'publisher'   => get_metadata( 'book', get_the_ID(), 'wb_meta_publisher_name_key', true ),
				'id'          => get_the_ID(),

			);

		}
	}

	wp_reset_postdata();

	foreach ( $result_array as $book_info ) {
		$result_output .= '<p> Title: ' . $book_info['title'] . ', Author: ' . $book_info['author_name'] . ', Price: ' . $book_info['price'] . '(' . $book_info['currency'] . '), Publisher: ' . $book_info['publisher'] . ' Book ID: ' . $book_info['id'] . '</p>';

	}

	return $result_output;

}
