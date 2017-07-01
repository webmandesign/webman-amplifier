<?php
/**
 * Button
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.4.7
 *
 * @uses  $codes_globals['sizes']['values']
 *
 * @param  string class
 * @param  string color
 * @param  string icon
 * @param  string size
 * @param  string url
 * @param  string ... You can actually set up a custom attributes for this shortcode. They will be outputted as HTML attributes.
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'class' => '',
			'color' => '',
			'icon'  => '',
			'size'  => '',
			'url'   => '#',
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	//get the custom attributes in $atts['attributes']
	//parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'href' ), array( 'class' ), $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class'] = trim( 'wm-button ' . trim( $atts['class'] ) );
	//content
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );
	//color
		$atts['color'] = trim( $atts['color'] );
		if ( $atts['color'] ) {
			$atts['class'] .= ' color-' . $atts['color'];
		}
	//size
		$atts['size'] = trim( $atts['size'] );
		if ( $atts['size'] ) {
			if ( in_array( $atts['size'], array_keys( $codes_globals['sizes']['values'] ) ) ) {
				$atts['class'] .= ' size-' . $codes_globals['sizes']['values'][ $atts['size'] ];
			} else {
				$atts['class'] .= ' size-' . $atts['size'];
			}
		}
	//url
		$atts['url'] = esc_url( $atts['url'] );
	//icon
		$atts['icon'] = trim( $atts['icon'] );
		if ( $atts['icon'] ) {
			$atts['icon'] = '<span class="' . esc_attr( $atts['icon'] ) . '" aria-hidden="true"> </span>';
		}
	//class
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );


// Output

	$shortcode_output = $atts['icon'] . $atts['content'];

	if ( ! empty( $shortcode_output ) ) {
		$output = '<a href="' . esc_url( $atts['url'] ) . '" class="' . esc_attr( $atts['class'] ) . '"' . $atts['attributes'] . '>' . $shortcode_output . '</a>';
	} else {
		$output = esc_html__( 'Sorry, there is nothing to display here&hellip;', 'webman-amplifier' );
	}
