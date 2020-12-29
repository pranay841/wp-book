<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/pranay841/
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     Pranay Chahare <pranaychahare84@gmail.com>
 */
class Wp_Book_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Callback function to create a post type of 'book'.
	 */
	public function wb_add_book_type() {
		$args = array(
			'labels'      => array(
				'name'          => __( 'Books', 'wp-book' ),
				'singular_name' => __( 'Book', 'wp-book' ),
			),
			'public'      => true,
			'has_archive' => true,

		);
		register_post_type( 'book', $args );
	}

	/**
	 * Callback function to add custom taxonomy.
	 */
	public function wb_add_tax() {
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

		);
			register_taxonomy( 'Book Tag', 'book', $tag_args );
	}

	/**
	 * Callback function that links meta api with the custom meta table book.
	 *
	 * @global WPDB $wpdb is a global database class.
	 */
	public function wb_meta_link_wpdb() {

		global $wpdb;

		$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';

	}

	/**
	 * Callback function to create a menu page.
	 */
	public function wb_add_setting_page() {

		add_menu_page(
			'Booksmenu',
			'Booksmenu',
			'manage_options',
			'booksmenu',
			array( $this, 'wb_booksmenu_main_cb' )
		);
	}

	/**
	 * Callback function to add settings section and fields.
	 */
	public function wb_booksmenu_main_cb() {
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
	 * Callback function to resister settings and section and fields to it.
	 */
	public function wb_booksmenu_settings_setup() {

		register_setting( 'booksmenu', 'booksmenu_options' );

		add_settings_section( 'wb_booksmenu_section_id', __( 'Settings for Book Post', 'wp-book' ), array( $this, 'wb_booksmenu_section_cb' ), 'booksmenu' );

		add_settings_field(
			'wb_booksmenu_field_posts_flow_id',
			__( 'Control Posts Flow', 'wp-book' ),
			array( $this, 'wb_booksmenu_field_posts_flow_cb' ),
			'booksmenu',
			'wb_booksmenu_section_id',
		);

		add_settings_field( 'wb_booksmenu_field_currency_id', __( 'Set Currency', 'wp-book' ), array( $this, 'wb_booksmenu_field_currency_cb' ), 'booksmenu', 'wb_booksmenu_section_id' );
	}

	/**
	 * Callback of setting section .
	 */
	public function wb_booksmenu_section_cb() {
	}
	/**
	 * Callback for settings field, used to get the posts per page value.
	 */
	public function wb_booksmenu_field_posts_flow_cb() {

		$options = get_option( 'booksmenu_options' );

		?>
	<span><?php esc_html_e( 'Number of posts per page:', 'wp-book' ); ?></span>
	<input id="name_id" name='booksmenu_options[numofposts]' value=<?php isset( $options['numofposts'] ) ? print( esc_attr( $options['numofposts'] ) ) : print( 5 ); ?>>
		<?php
	}
	/**
	 * Callback for settings field, used to get the currency type.
	 */
	public function wb_booksmenu_field_currency_cb() {

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

}
