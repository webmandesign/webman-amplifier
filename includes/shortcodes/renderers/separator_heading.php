<?php
/**
 * Separator Heading
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1.6
 *
 * @param  string align
 * @param  string class
 * @param  string id
 * @param  string tag
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'align' => 'left',
			'class' => '',
			'id'    => '',
			'tag'   => 'h2',
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//align
		$atts['align'] = strtolower( trim( $atts['align'] ) );
		if ( ! in_array( $atts['align'], array( 'left', 'center', 'right' ) ) ) {
			$atts['align'] = 'left';
		}
		$atts['class'] .= ' text-' . $atts['align'];
	//class
		$atts['class'] = trim( 'wm-separator-heading ' . trim( $atts['class'] ) );
	//id
		$atts['id'] = trim( $atts['id'] );
		if ( $atts['id'] ) {
			$atts['id'] = ' id="' . esc_attr( $atts['id'] ) . '"';
		}
	//tag
		$atts['tag'] = strtolower( trim( $atts['tag'] ) );
		if ( ! in_array( $atts['tag'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div' ) ) ) {
			$atts['tag'] = 'h2';
		}
	//content
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );
		$atts['content'] = '<span class="text-holder">' . $atts['content'] . '</span>';
		if ( in_array( $atts['align'], array( 'left', 'center' ) ) ) {
			$atts['content'] .= '<span class="pattern-holder"></span>';
		}
		if ( in_array( $atts['align'], array( 'center', 'right' ) ) ) {
			$atts['content'] = '<span class="pattern-holder"></span>' . $atts['content'];
		}
	//class
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

//Output
	$output = '<' . esc_attr( $atts['tag'] ) . $atts['id'] . ' class="' . esc_attr( $atts['class'] ) . '">' . $atts['content'] . '</' . esc_attr( $atts['tag'] ) . '>';

?>