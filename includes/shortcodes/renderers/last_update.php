<?php
/**
 * Last update time
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  string class
 * @param  string format
 * @param  string post_type
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'class'     => '',
			'format'    => get_option( 'date_format' ),
			'post_type' => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = '';
	//class
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( trim( 'wm-last-update post-type-' . trim( $atts['post_type'] ) . ' ' . trim( $atts['class'] ) ) ) );
	//format
		$atts['format'] = ( trim( $atts['format'] ) ) ? ( trim( $atts['format'] ) ) : ( get_option( 'date_format' ) );
	//post type
		$atts['post_type'] = trim( $atts['post_type'] );
		if ( post_type_exists( $atts['post_type'] ) ) {
			$post = get_posts( array(
					'numberposts' => 1,
					'post_type'   => $atts['post_type'],
				) );
			$atts['content'] .= date( $atts['format'], strtotime( $post[0]->post_date ) );
		}
	//content filters
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $atts['content'], $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );

//Output
	$output = '<span class="' . $atts['class'] . '">' . $atts['content'] . '</span>';

?>