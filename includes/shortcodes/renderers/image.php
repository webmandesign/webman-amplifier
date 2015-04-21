<?php
/**
 * Image
 *
 * Visual Composer plugin helper shortcode.
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1.6
 *
 * @param  string class
 * @param  absint height
 * @param  string link
 * @param  string margin
 * @param  string src
 * @param  string title
 * @param  absint width
 * @param  string ... You can actually set up a custom attributes for this shortcode. They will be outputed as HTML attributes if link is set.
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'class'  => '',
			'height' => '',
			'link'   => '',
			'margin' => '',
			'src'    => '',
			'title'  => '',
			'width'  => '',
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	//get the custom attributes in $atts['attributes']
	//parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'href' ), array(), $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = '';
	//class
		$atts['class'] = trim( apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', 'wm-image ' . trim( $atts['class'] ), $atts ) );
	//margin
		$atts['margin'] = trim( $atts['margin'] );
		if ( $atts['margin'] ) {
			$atts['margin'] = ' style="margin: ' . esc_attr( $atts['margin'] ) . ';"';
		}
	//width
		if ( trim( $atts['width'] ) ) {
			$atts['width'] = absint( $atts['width'] );
		}
	//height
		if ( trim( $atts['height'] ) ) {
			$atts['height'] = absint( $atts['height'] );
		}
	//title
		$atts['title'] = esc_attr( trim( $atts['title'] ) );
	//src
		$atts['src'] = trim( $atts['src'] );
		if ( is_numeric( $atts['src'] ) ) {
			$image_size      = apply_filters( 'wmhook_shortcode_' . $shortcode . '_image_size', 'full', $atts );
			$attr            = array( 'title' => esc_attr( get_the_title( absint( $atts['src'] ) ) ) );
			$atts['content'] = wp_get_attachment_image( absint( $atts['src'] ), $image_size, false, $attr );
			if ( trim( image_hwstring( $atts['width'], $atts['height'] ) ) ) {
				$atts['content'] = preg_replace( '/(width|height)="\d*"\s/', '', $atts['content'] );
				$atts['content'] = str_replace( '<img ', '<img ' . trim( image_hwstring( $atts['width'], $atts['height'] ) ), $atts['content'] );
			}
			if ( $atts['margin'] ) {
				$atts['content'] = str_replace( ' />', $atts['margin'] . ' />', $atts['content'] );
			}
		} else {
			$atts['content'] = '<img src="' . esc_url( $atts['src'] ) . '" title="' . esc_attr( $atts['title'] ) . '" alt="' . esc_attr( $atts['title'] ) . '"' . trim( image_hwstring( $atts['width'], $atts['height'] ) ) . ' />';
		}
	//link
		$atts['link'] = trim( $atts['link'] );
		if ( $atts['link'] ) {
			$atts['content'] = '<a href="' . esc_url( $atts['link'] ) . '"' . $atts['attributes'] . '>' . $atts['content'] . '</a>';
		}
	//content filters
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $atts['content'], $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );

//Output
	$output = '<div class="' . esc_attr( $atts['class'] ) . '">' . $atts['content'] . '</div>';

?>