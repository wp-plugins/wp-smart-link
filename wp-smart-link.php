<?php
/**
 * Plugin Name: WP Smart Link
 * Description: An intelligent and powerful widget and shortcode that create links with amazingly little input.
 * Author: Carlo Manf
 * Author URI: http://carlomanf.id.au
 * Version: 1.0.1
 */

// The brains...
function smart_link( $instance ) {
	wp_reset_query();

	// Try the custom field first (only for singulars)
	if ( !empty( $instance[ 'field' ] ) && is_singular() ) {
		$url_array = get_post_meta( get_the_ID(), esc_sql( $instance[ 'field' ] ) );

		if ( !empty( $url_array ) )
			$url = esc_url( $url_array[ 0 ] );
	}

	// Try the post ID or slug next
	if ( !empty( $instance[ 'post' ] ) ) {

		// Try the post ID, or else the slug
		if ( intval( $instance[ 'post' ] ) )
			$post_id = $instance[ 'post' ];
		else {
			$post = get_posts( array( 'name' => $instance[ 'post' ], 'post_type' => 'any' ) );
			if ( $post )
				$post_id = $post[ 0 ]->ID;
		}

		if ( empty( $url ) && !empty( $post_id ) ) {
			$url = get_permalink( $post_id );

			// Easter egg
			if ( !empty( $url ) && empty( $instance[ 'text' ] ) )
				$instance[ 'text' ] = get_the_title( $post_id );
		}
	}

	// Try the custom URL last
	if ( empty( $url ) && !empty( $instance[ 'url' ] ) )
		$url = esc_url( $instance[ 'url' ] );

	// If there's still no URL, can't do the link
	if ( empty( $url ) )
		return;

	return sprintf(
		'<a%s href="%s">%s</a>',
		empty( $instance[ 'class' ] ) ? '' : sprintf( ' class="%s"', esc_attr( $instance[ 'class' ] ) ),
		$url,
		empty( $instance[ 'text' ] ) ? $url : wptexturize( esc_attr( $instance[ 'text' ] ) )
	);
}

// Describe the widget
class Smart_Link extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'smart_link',
			'Smart Link',
			array( 'description' => 'Outputs a smart link.' )
		);
	}

	public function widget( $args, $instance ) {
		$smart_link = smart_link( $instance );
		if ( !$smart_link )
			return;

		echo $args[ 'before_widget' ] . $smart_link . $args[ 'after_widget' ];
	}

	public function form( $instance ) {
		echo '<p>You can enter the name of a custom field that contains the URL, the ID or slug of a post to link to or a custom URL.</p>';

		$format = '<p><label for="%2$s">%1$s</label><br><input class="widefat" type="text" id="%2$s" name="%3$s" value="%4$s"></p>';

		printf( $format, 'Name of custom field', $this->get_field_id( 'field' ), $this->get_field_name( 'field' ), isset( $instance[ 'field' ] ) ? esc_attr( $instance[ 'field' ] ) : '' );
		printf( $format, 'Post ID or slug', $this->get_field_id( 'post' ), $this->get_field_name( 'post' ), isset( $instance[ 'post' ] ) ? esc_attr( $instance[ 'post' ] ) : '' );
		printf( $format, 'Custom URL', $this->get_field_id( 'url' ), $this->get_field_name( 'url' ), isset( $instance[ 'url' ] ) ? esc_attr( $instance[ 'url' ] ) : '' );
		printf( $format, 'Anchor text', $this->get_field_id( 'text' ), $this->get_field_name( 'text' ), isset( $instance[ 'text' ] ) ? esc_attr( $instance[ 'text' ] ) : '' );
		printf( $format, 'HTML class', $this->get_field_id( 'class' ), $this->get_field_name( 'class' ), isset( $instance[ 'class' ] ) ? esc_attr( $instance[ 'class' ] ) : '' );
	}
}

// Register the widget
add_action( 'widgets_init', function() {
	register_widget( 'Smart_Link' );
} );

// Register and describe the shortcode
add_shortcode( 'smart_link', 'smart_link_shortcode' );
function smart_link_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'field' => null,
		'post' => null,
		'url' => null,
		'text' => null,
		'class' => null
	), $atts, 'smart_link' );

	return smart_link( $atts );
}
