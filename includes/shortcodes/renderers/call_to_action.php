<?php
/**
 * Call to Action
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.2.9.1
 *
 * @uses  $codes_globals['colors'], $codes_globals['sizes']['values']
 *
 * @param  string button_class
 * @param  string button_color
 * @param  string button_icon
 * @param  string button_size
 * @param  string button_text
 * @param  string button_url
 * @param  string caption
 * @param  string class
 * @param  string heading_tag (heading tag option for better accessibility setup)
 * @param  string ... You can actually set up a custom attributes for this shortcode. They will be outputed as HTML attributes for the button.
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'button_class' => '',
			'button_color' => '',
			'button_icon'  => '',
			'button_size'  => '',
			'button_text'  => '',
			'button_url'   => '#',
			'caption'      => '',
			'class'        => '',
			'heading_tag'  => 'h2',
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	//get the custom attributes in $atts['attributes']
	//parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'href' ), array( 'class' ), $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class'] = trim( 'wm-call-to-action ' . trim( $atts['class'] ) );
	//content
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );
	//button_color
		$atts['button_color'] = trim( $atts['button_color'] );
		if ( $atts['button_color'] && in_array( $atts['button_color'], array_keys( $codes_globals['colors'] ) ) ) {
			$atts['button_class'] .= ' color-' . $atts['button_color'];
			$atts['class']        .= ' cta-button-color-' . $atts['button_color'];
		}
	//button_icon
		$atts['button_icon'] = trim( $atts['button_icon'] );
		if ( $atts['button_icon'] ) {
			$atts['button_icon'] = '<i class="' . esc_attr( $atts['button_icon'] ) . '"></i> ';
		}
	//button_size
		$atts['button_size'] = trim( $atts['button_size'] );
		if ( $atts['button_size'] && in_array( $atts['button_size'], array_keys( $codes_globals['sizes']['values'] ) ) ) {
			$atts['button_class'] .= ' size-' . $codes_globals['sizes']['values'][ $atts['button_size'] ];
		}
	//button_text
		$atts['button_text'] = trim( $atts['button_text'] );
	//button_url
		$atts['button_url'] = esc_url( $atts['button_url'] );
	//caption
		$atts['caption'] = trim( $atts['caption'] );
		if ( $atts['caption'] ) {
			$atts['caption'] = '<div class="wm-call-to-action-caption wm-call-to-action-element"><' . tag_escape( $atts['heading_tag'] ) . '>' . $atts['caption'] . '</' . tag_escape( $atts['heading_tag'] ) . '></div>';
		}
	//button_class
		$atts['button_class'] = trim( 'wm-button ' . trim( $atts['button_class'] ) );
	//button
		$atts['button'] = ( $atts['button_text'] ) ? ( '<div class="wm-call-to-action-button wm-call-to-action-element"><a href="' . $atts['button_url'] . '" class="' . $atts['button_class'] . '"' . $atts['attributes'] . '>' . $atts['button_icon'] . $atts['button_text'] . '</a></div>' ) : ( '' );
	//class
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

//Output
	$output = '<div class="' . esc_attr( $atts['class'] ) . '"><div class="wm-call-to-action-content wm-call-to-action-element">' . $atts['caption'] . $atts['content'] . '</div>' . $atts['button'] . '</div>';

?>