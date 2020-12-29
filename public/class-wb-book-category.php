<?php
/**
 * File to create a custom widget for book.
 *
 * @package WordPress
 */

/**
 * Extending the WP_Widget class for custom widget.
 *
 * This widget accepts the category as input ans displays the books of that particular category.
 */
class Wb_Book_Category extends WP_Widget {

	/**
	 * Constructor function for Wp_Book_Category class.
	 */
	public function __construct() {

		$widget_options = array(
			'classname'                   => 'wb_book_category_widget',
			'description'                 => __( 'This widget will show the books from the selected category.', 'wp-book' ),
			'customize_selective_refresh' => true,
		);

		parent::__construct( 'wb_book_category_widget', 'Books By Category', $widget_options );
	}

	/**
	 * Queries for the posts that have user provided category and displays the result.
	 *
	 * @param Arguments $args contains the html code for before and after of widgets and title.
	 * @param Instance  $instance contains the values that are provided by user through form.
	 */
	public function widget( $args, $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New Title', 'wp-book' );

		$filter_as = array(
			'post_type' => 'book',

			'tax_query' => array(   //phpcs:ignore
				'relation' => 'OR',
				array(
					'taxonomy' => 'Book Category',
					'field'    => 'slug',
					'terms'    => $instance['category'],
				),
				array(
					'taxonomy' => 'Book Tag',
					'field'    => 'slug',
					'terms'    => $instance['category'],
				),
			),

		);
		$query = new Wp_Query( $filter_as );

		echo $args['before_widget'];  //phpcs:ignore
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( apply_filters( 'widget_title', $instance['title'] ) ) . $args['after_title'];  //phpcs:ignore
		} else {
			echo $args['before_title'] . esc_html_e( 'Title', 'wp-book' ) . $args['after_title'];  //phpcs:ignore
		}

		$format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';
		$format = apply_filters( 'navigation_widgets_format', $format );

		if ( 'html5' === $format ) {
			$title      = trim( wp_strip_all_tags( $title ) );
			$aria_label = $title;

			echo '<nav role="navigation" aria_label="' . esc_attr( $aria_label ) . '" >';
		}
		echo '<ul>';
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<li><a href="' . esc_attr( get_permalink( get_the_ID() ) ) . '" >' . esc_html( get_the_title() ) . '</a></li>';
		}
		echo '</ul>';
		if ( 'html5' === $format ) {
			echo '</nav>';
		}

		echo $args['after_widget'];  //phpcs:ignore
	}
	/**
	 * This function displays the form to take inputs from the user.
	 *
	 * @param Instance $instance contains the information provided by the user through form input.
	 */
	public function form( $instance ) {

		$title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New Title', 'wp-book' );
		$category = ! empty( $instance['category'] ) ? $instance['category'] : __( 'none', 'wp-book' );
		?>
	<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'wp-book' ); ?></label>
	<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">

	<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php echo esc_attr__( 'Category:', 'wp-book' ); ?></label>
	<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" value="<?php echo esc_attr( $category ); ?>">

	</p>
		<?php

	}
	/**
	 * This function updates the values in the instances as per user input.
	 *
	 * @param Instance $new_instance contains the value of new inouts provided by the user.
	 * @param Instance $old_instance contains the previous values of the instance.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? sanitize_text_field( $new_instance['category'] ) : '';

		return $instance;
	}
}
