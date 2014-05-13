<?php
/**
 * Icon
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @uses   $codes_globals['sizes']
 *
 * @param  string class
 * @param  string size
 * @param  string social
 * @param  string url
 * @param  string ... You can actually set up a custom attributes for this shortcode. They will be outputed as HTML attributes.
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'class'  => '',
			'icon'   => '',
			'size'   => '',
			'social' => '',
			'url'    => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	//get the custom attributes in $atts['attributes']
	//parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'href' ), array( 'class' ), $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//icon
		$atts['icon'] = trim( $atts['icon'] );
		if ( $atts['icon'] ) {
			$atts['class'] .= ' ' . $atts['icon'];
		}
	//class
		$atts['class'] = esc_attr( trim( 'wm-icon ' . trim( $atts['class'] ) ) );
	//social
		$atts['social'] = ( trim( $atts['social'] ) ) ? ( ' social-' . sanitize_html_class( strtolower( trim( $atts['social'] ) ) ) ) : ( '' );
	//social_url
		$atts['url'] = ( $atts['social'] ) ? ( esc_url( $atts['url'] ) ) : ( '' );
	//size
		$atts['size'] = trim( $atts['size'] );
		if ( in_array( $atts['size'], array_keys( $codes_globals['sizes'] ) ) ) {
			$atts['class'] .= ' size-' . $codes_globals['sizes'][$atts['size']];
		}
	//class
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', $atts['class'] );

//Output
	if ( ! $atts['social'] ) {
		$output = '<i class="' . $atts['class'] . '"' . $atts['attributes'] . '></i>';
	} else {
		$output = '<a href="' . $atts['url'] . '" class="' . str_replace( 'wm-icon', 'wm-social-icon', $atts['class'] ) . $atts['social'] . '"' . $atts['attributes'] . '><i class="' . $atts['class'] . '"></i></a>';
	}

?>