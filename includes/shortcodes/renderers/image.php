<?php
/**
 * Image
 *
 * Visual Composer plugin helper shortcode.
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  string class
 * @param  string link
 * @param  string title
 * @param  string url
 * @param  string ... You can actually set up a custom attributes for this shortcode. They will be outputed as HTML attributes if link is set.
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'class' => '',
			'link'  => '',
			'title' => '',
			'src'   => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	//get the custom attributes in $atts['attributes']
	//parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'href' ), array(), $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = '';
	//class
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', trim( esc_attr( 'wm-image ' . trim( $atts['class'] ) ) ) );
	//title
		$atts['title'] = esc_attr( trim( $atts['title'] ) );
	//src
		$atts['src'] = trim( $atts['src'] );
		if ( is_numeric( $atts['src'] ) ) {
			$image_size      = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_image_size', 'full' );
			$attr            = array( 'title' => esc_attr( get_the_title( absint( $atts['src'] ) ) ) );
			$atts['content'] = wp_get_attachment_image( absint( $atts['src'] ), $image_size, false, $attr );
		} else {
			$atts['content'] = '<img src="' . esc_url( $atts['src'] ) . '" title="' . $atts['title'] . '" alt="' . $atts['title'] . '" />';
		}
	//link
		$atts['link'] = trim( $atts['link'] );
		if ( $atts['link'] ) {
			$atts['content'] = '<a href="' . esc_url( $atts['link'] ) . '"' . $atts['attributes'] . '>' . $atts['content'] . '</a>';
		}
	//content filters
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $atts['content'], $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );

//Output
	$output = '<div class="' . $atts['class'] . '">' . $atts['content'] . '</div>';

?>