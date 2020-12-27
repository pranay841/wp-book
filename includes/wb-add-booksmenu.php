<?php
/**
 * File to create a custom settings for book.
 *
 * @package WordPress
 */

/**
 * Using admin_menu hook to trigger a callback that adds menu page for book settings :Booksmenu.
 */
add_action( 'admin_menu', 'wb_add_setting_page' );
/**
 * Callback function to create a menu page.
 */
function wb_add_setting_page() {

	add_menu_page(
		'Booksmenu',
		'Booksmenu',
		'manage_options',
		'booksmenu',
		'wb_booksmenu_main_cb'
	);
}
/**
 * Callback function to add settings section and fields.
 */
function wb_booksmenu_main_cb() {
	?>
<form id="booksmenu_form" method="post" action="options.php">
	<?php
	settings_fields( 'booksmenu' );
	do_settings_sections( 'booksmenu' );
	submit_button( 'Save Settings' );
	?>
</form>
	<?php
}

/**
*Using admin_init hook to trigger a call back that registers setting and section and fields to it.
*/
add_action( 'admin_init', 'wb_booksmenu_settings_setup' );
/**
 * Callback function to resister settings and section and fields to it.
 */
function wb_booksmenu_settings_setup() {

	register_setting( 'booksmenu', 'booksmenu_options' );

	add_settings_section( 'wb_booksmenu_section_id', __( 'Settings for Book Post', 'wp-book' ), 'wb_booksmenu_section_cb', 'booksmenu' );

	add_settings_field(
		'wb_booksmenu_field_posts_flow_id',
		__( 'Control Posts Flow', 'wp-book' ),
		'wb_booksmenu_field_posts_flow_cb',
		'booksmenu',
		'wb_booksmenu_section_id',
	);

	add_settings_field( 'wb_booksmenu_field_currency_id', __( 'Set Currency', 'wp-book' ), 'wb_booksmenu_field_currency_cb', 'booksmenu', 'wb_booksmenu_section_id' );
}

/**
 * Callback of setting section .
 */
function wb_booksmenu_section_cb() {
}
/**
 * Callback for settings field, used to get the posts per page value.
 */
function wb_booksmenu_field_posts_flow_cb() {

	$options = get_option( 'booksmenu_options' );

	?>
<span><?php esc_html_e( 'Number of posts per page:', 'wp-book' ); ?></span>
<input id="name_id" name='booksmenu_options[numofposts]' value=<?php isset( $options['numofposts'] ) ? print( esc_attr( $options['numofposts'] ) ) : print( 5 ); ?>>
	<?php
}
/**
 * Callback for settings field, used to get the currency type.
 */
function wb_booksmenu_field_currency_cb() {

	$options = get_option( 'booksmenu_options' );
	if ( ! isset( $options['currency'] ) ) {
		$options['currency'] = 'Ruppes';
		update_option( 'booksmenu_options', $options );
	}
	?>
<span><?php esc_html_e( 'Currency', 'wp-book' ); ?></span>
<select name='booksmenu_options[currency]'>
	<option value='Rupees' <?php selected( $options['currency'], 'Rupees', true ); ?>>Rupees</option>
	<option value='Dollar'  <?php selected( $options['currency'], 'Dollar', true ); ?>>Dollar</option>
	<option value='Euros'   <?php selected( $options['currency'], 'Euros', true ); ?>>Euros</option>
</select>
	<?php

}

/**
*Using pre_get_posts hook to trigger callback that return filtered query.
*/
add_filter( 'pre_get_posts', 'wb_control_post' );
/**
 * Callback to filter the query to get the boook posts and set the posts per page value as per set in options table.
 *
 * @param Query $query it contains the posts that we can access to get the desired output.
 */
function wb_control_post( $query ) {

	if ( $query->is_main_query() && is_home() ) {
		$options = get_option( 'booksmenu_options' );

		$query->set( 'post_type', 'book' );

		$query->set( 'posts_per_page', isset( $options['numofposts'] ) ? $options['numofposts'] : 5 );
		return $query;
	}
}
