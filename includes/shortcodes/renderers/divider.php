<?php
/**
 * Divider
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1
 *
 * @uses   $codes_globals['divider_appearance']
 *
 * @param  string class
 * @param  string space_after
 * @param  string space_before
 * @param  string style
 * @param  string type Legacy attribute
 * @param  string appearance Introduced not to conflict with Beaver Builder
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'appearance'   => '',
			'class'        => '',
			'space_after'  => '-',
			'space_before' => '-',
			'style'        => '',
			'type'         => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class'] = trim( 'wm-divider ' . trim( $atts['class'] ) );
	//space_after
		if ( '-' !== $atts['space_after'] ) {
			$atts['style'] .= 'margin-bottom:' . intval( $atts['space_after'] ). 'px;';
		}
	//space_before
		if ( '-' !== $atts['space_before'] ) {
			$atts['style'] .= 'margin-top:' . intval( $atts['space_before'] ) . 'px;';
		}
	//style
		if ( $atts['style'] ) {
			$atts['style'] = ' style="' . esc_attr( $atts['style'] ) . '"';
		}
	//type
		//Fix for Beaver Builder
			if ( $atts['appearance'] ) {
				$atts['type'] = $atts['appearance'];
			}
		$atts['type'] = trim( $atts['type'] );
		if ( in_array( $atts['type'], array_keys( $codes_globals['divider_appearance'] ) ) ) {
			$atts['class'] .= ' type-' . $atts['type'];
		}
	//class
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( $atts['class'] ) );

//Output
	$output = '<hr class="' . $atts['class'] . '"' . $atts['style'] . ' />';

?>