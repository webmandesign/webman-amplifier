<?php
/**
 * Button
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.2.9.1
 *
 * @uses  $codes_globals['colors'], $codes_globals['sizes']['values']
 *
 * @param  string class
 * @param  string color
 * @param  string icon
 * @param  string size
 * @param  string url
 * @param  string ... You can actually set up a custom attributes for this shortcode. They will be outputed as HTML attributes.
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
		if ( $atts['color'] && in_array( $atts['color'], array_keys( $codes_globals['colors'] ) ) ) {
			$atts['class'] .= ' color-' . $atts['color'];
		}
	//size
		$atts['size'] = trim( $atts['size'] );
		if ( $atts['size'] && in_array( $atts['size'], array_keys( $codes_globals['sizes']['values'] ) ) ) {
			$atts['class'] .= ' size-' . $codes_globals['sizes']['values'][ $atts['size'] ];
		}
	//url
		$atts['url'] = esc_url( $atts['url'] );
	//icon
		$atts['icon'] = trim( $atts['icon'] );
		if ( $atts['icon'] ) {
			$atts['icon'] = '<i class="' . esc_attr( $atts['icon'] ) . '"></i> ';
		}
	//class
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

//Output
	$output = '<a href="' . esc_url( $atts['url'] ) . '" class="' . esc_attr( $atts['class'] ) . '"' . $atts['attributes'] . '>' . $atts['icon'] . $atts['content'] . '</a>';

?>