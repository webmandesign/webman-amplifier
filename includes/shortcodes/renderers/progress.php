<?php
/**
 * Progress bar
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @uses   $codes_globals['colors']
 *
 * @param  string class
 * @param  string color
 * @param  integer progress
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'class'    => '',
			'color'    => '',
			'progress' => 66,
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class']         = trim( 'wm-progress ' . trim( $atts['class'] ) );
		$atts['class_caption'] = trim( 'wm-progress-caption' );
		$atts['class_bar']     = trim( 'wm-progress-bar' );
	//color
		$atts['color'] = trim( $atts['color'] );
		if ( in_array( $atts['color'], array_keys( $codes_globals['colors'] ) ) ) {
			$atts['class']     .= ' container-color-' . $atts['color'];
			$atts['class_bar'] .= ' color-' . $atts['color'];
		}
	//content
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
		$atts['content'] = '<div class="' . $atts['class_caption'] . '">' . $atts['content'] . '</div>';
	//progress
		$atts['progress'] = absint( $atts['progress'] );
		if ( 100 < $atts['progress'] ) {
			$atts['progress'] = 66;
		}
	//class
		$atts['class']     = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( $atts['class'] ) );
		$atts['class_bar'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_bar_classes', esc_attr( $atts['class_bar'] ) );

//Output
	$output = '<div class="' . $atts['class'] . '" title="' . $atts['progress'] . '%" data-progress="' . $atts['progress'] . '">' . $atts['content'] . '<div class="' . $atts['class_bar'] . '" style="width:' . $atts['progress'] . '%;"></div></div>';

?>