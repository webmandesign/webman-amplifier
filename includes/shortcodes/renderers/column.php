<?php
/**
 * Columns
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  string class (Use "no-margin" class to remove margins between columns)
 * @param  boolean last
 * @param  string width
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'class' => '',
			'last'  => false,
			'width' => '1/1',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//class
		$atts['class'] = trim( 'wm-column ' . trim( $atts['class'] ) );
	//last
		$atts['class'] .= ( trim( $atts['last'] ) ) ? ( ' last' ) : ( '' );
	//width
		$atts['width']  = trim( str_replace( '/', '-', $atts['width'] ) );
		$atts['class'] .= ( $atts['width'] ) ? ( ' width-' . sanitize_html_class( $atts['width'] ) ) : ( ' width-1-2' );
	//class
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( $atts['class'] ) );

//Output
	$output = '<div class="' . $atts['class'] . '">' . $atts['content'] . '</div>';

?>