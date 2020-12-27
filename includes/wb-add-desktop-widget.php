<?php
/**
 * File to create a custom post type 'book'.
 *
 * @package WordPress
 */

/**
 * Using wp_dashboard_setup hook to trigger callback that will register a dashboard widget.
 */
add_action( 'wp_dashboard_setup', 'wb_add_desktop_widget_cb' );

/**
 * Callback function to register a dashboard widget that shows top book categories.
 */
function wb_add_desktop_widget_cb() {
	wp_add_dashboard_widget( 'wb_top_category', 'Top Book Categories', 'wb_register_category_cb', );
}
/**
 * Callback function to display top 5 book categories.
 */
function wb_register_category_cb() {

	wp_list_categories(
		array(
			'taxonomy' => 'Book Category',
			'title_li' => false,
			'orderby'  => 'count',
			'order'    => 'DESC',
			'number'   => 5,
		)
	);
}
