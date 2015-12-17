<?php
/**
 * Message box
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.2.9.1
 *
 * @uses  $this->$codes_globals['colors'], $codes_globals['sizes']['values']
 *
 * @param  string class
 * @param  string color
 * @param  string heading_tag (heading tag option for better accessibility setup)
 * @param  string icon
 * @param  string size
 * @param  string title
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'class'       => '',
			'color'       => '',
			'heading_tag' => 'h3',
			'icon'        => '',
			'size'        => '',
			'title'       => ''
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class'] = trim( 'wm-message ' . trim( $atts['class'] ) );
	//content
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );
		$iconated = ( 0 === strpos( $atts['content'], '<i class="icon-' ) ) ? ( ' iconated' ) : ( '' );
		$atts['content'] = '<div class="wm-message-content wm-message-element' . esc_attr( $iconated ) . '">' . $atts['content'] . '</div>';
	//color
		$atts['color'] = trim( $atts['color'] );
		if ( $atts['color'] && in_array( $atts['color'], array_keys( $codes_globals['colors'] ) ) ) {
			$atts['class'] .= ' color-' . $atts['color'];
		}
	//icon
		$atts['icon'] = trim( $atts['icon'] );
		if ( $atts['icon'] ) {
			$atts['class'] .= ' ' . esc_attr( $atts['icon'] );
		}
	//size
		$atts['size'] = trim( $atts['size'] );
		if ( $atts['size'] && in_array( $atts['size'], array_keys( $codes_globals['sizes']['values'] ) ) ) {
			$atts['class'] .= ' size-' . $codes_globals['sizes']['values'][ $atts['size'] ];
		}
	//title
		$atts['title'] = trim( $atts['title'] );
		if ( $atts['title'] ) {
			$atts['title'] = strip_tags( $atts['title'], $this->inline_tags );
			$atts['title'] = '<' . tag_escape( $atts['heading_tag'] ) . ' class="wm-message-title wm-message-element">' . $atts['title'] . '</' . tag_escape( $atts['heading_tag'] ) . '>';
		}
	//class
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

//Output
	$output = '<div class="' . esc_attr( $atts['class'] ) . '">' . $atts['title'] . $atts['content'] . '</div>';

?>