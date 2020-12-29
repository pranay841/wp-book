<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/pranay841/
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 * @author     Pranay Chahare <pranaychahare84@gmail.com>
 */
class Wp_Book_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->load_files();

	}

	/**
	 * Function to load dependency files.
	 */
	public function load_files() {

		/**
		*Class used for creating widget.
		*/
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wb-book-category.php';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Callback function to trigger add_meta_box() .
	 */
	public function wb_add_meta_box_func() {
		add_meta_box( 'wb_book_info', __( 'Book Information', 'wp-book' ), array( $this, 'wb_book_info_callback' ), 'Book' );
	}
	/**
	 * Callback function to create custom meta boxes of author name,price,publisher,year,edition and url.
	 *
	 * @param object $post current post is passed as parameter.
	 */
	public function wb_book_info_callback( $post ) {

		wp_nonce_field( 'wb_save_info', 'wb_save_info_nonce' );

		$wb_author_value         = get_metadata( 'book', $post->ID, 'wb_meta_author_name_key', true );
		$wb_price_value          = get_metadata( 'book', $post->ID, 'wb_meta_price_key', true );
		$wb_publisher_name_value = get_metadata( 'book', $post->ID, 'wb_meta_publisher_name_key', true );
		$wb_year_value           = get_metadata( 'book', $post->ID, 'wb_meta_year_key', true );
		$wb_edition_value        = get_metadata( 'book', $post->ID, 'wb_meta_edition_key', true );
		$wb_url_value            = get_metadata( 'book', $post->ID, 'wb_meta_url_key', true );
		$options                 = get_option( 'booksmenu_options' );
		$wb_currency_value       = $options['currency'];

		echo '<label for = "wb_meta_author_name" > ' . esc_html_e( 'Author Name:', 'wp-book' ) . ' </label>';
		echo '<input id = "wb_meta_author_name" name = "wb_meta_author_name" value = "' . esc_attr( $wb_author_value ) . '"><br/><br/>';

		echo '<label for = "wb_meta_price" > ' . esc_html_e( 'Price', 'wp-book' ) . '( <span>' . esc_html( $wb_currency_value ) . '</span> ): </label>';
		echo '<input id = "wb_meta_price" name = "wb_meta_price" value = "' . esc_attr( $wb_price_value ) . '"><br/><br/>';

		echo '<label for = "wb_meta_publisher_name" > ' . esc_html_e( 'Publisher:', 'wp-book' ) . ' </label>';
		echo '<input id = "wb_meta_publisher_name" name = "wb_meta_publisher_name" value = "' . esc_attr( $wb_publisher_name_value ) . '"><br/><br/>';

		echo '<label for = "wb_meta_year" > ' . esc_html_e( 'Year:', 'wp-book' ) . ' </label>';
		echo '<input id = "wb_meta_year" name = "wb_meta_year" value = "' . esc_attr( $wb_year_value ) . '"><br/><br/>';

		echo '<label for = "wb_meta_edition" > ' . esc_html_e( 'Edition:', 'wp-book' ) . ' </label>';
		echo '<input id = "wb_meta_edition" name = "wb_meta_edition" value = "' . esc_attr( $wb_edition_value ) . '"><br/><br/>';

		echo '<label for = "wb_meta_url" > ' . esc_html_e( 'URL:', 'wp-book' ) . ' </label>';
		echo '<input id = "wb_meta_url" name = "wb_meta_url" value = "' . esc_attr( $wb_url_value ) . '"><br/><br/>';

	}

	/**
	 * Function to update the values inserted for custom meta box.
	 *
	 * @param POST_ID $post_id is a parameter passed that has the id of the current post.
	 */
	public function wb_save_book_info( $post_id ) {
		$options = get_option( 'booksmenu_options' );
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
			update_metadata( 'book', $post_id, 'wb_currency', isset( $options['currency'] ) ? $options['currency'] : 'Ruppes' );
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

	/**
	 * Callback to filter the query to get the boook posts and set the posts per page value as per set in options table.
	 *
	 * @param Query $query it contains the posts that we can access to get the desired output.
	 */
	public function wb_control_post( $query ) {

		if ( $query->is_main_query() && is_home() ) {
			$options = get_option( 'booksmenu_options' );

			$query->set( 'post_type', 'book' );

			$query->set( 'posts_per_page', isset( $options['numofposts'] ) ? $options['numofposts'] : 5 );
			return $query;
		}
	}

	/**
	 * Callback function to add_shortode 'book'.
	 */
	public function wb_register_shortcode() {
		add_shortcode( 'book', array( $this, 'wb_book_shortcode_cb' ) );
	}

	/**
	 * Callback function to handle the input by the user.
	 *
	 * This function has a dynamic args array that is altered as per input given by the user and that is passed to the
	 * query to get the posts satisfying those condition.
	 *
	 * @param Attributes $atts this contains values of all the attributes passed by the user with book shortcode.
	 * @global Wpdb $wpdb is a global class to access database.
	 */
	public function wb_book_shortcode_cb( $atts ) {
		global $wpdb;
		$result_array        = array();
		$result_output       = '';
		$book_id_given       = false;
		$ids_of_common_meta  = array();
		$attributes_provided = false;

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
				$attributes_provided = true;
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
		if ( ! $attributes_provided ) {

			return;
		}

		if ( $book_id_given && ! empty( $ids_of_common_meta ) && ! in_array( $args['post__in'][1], $ids_of_common_meta, true ) ) {
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

	/**
	 * Callabck function to register the custom widget that displays books of particular category provided by user.
	 */
	public function wb_register_book_category_widget_cb() {
		$book_widget = new Wb_Book_Category();
		register_widget( $book_widget );
	}

	/**
	 * Callback function to register a dashboard widget that shows top book categories.
	 */
	public function wb_add_dashboard_widget_cb() {
		wp_add_dashboard_widget( 'wb_top_category', __( 'Top Book Categories', 'wp-book' ), array( $this, 'wb_register_category_cb' ), );
	}

	/**
	 * Callback function to display top 5 book categories.
	 */
	public function wb_register_category_cb() {

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



}
