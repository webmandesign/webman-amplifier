<?php
/**
 * Columns
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.0.9
 *
 * @param  string bg_attachment
 * @param  string bg_color
 * @param  string bg_image
 * @param  string bg_position
 * @param  string bg_repeat
 * @param  string bg_size
 * @param  string class (Use "no-margin" class to remove margins between columns)
 * @param  string font_color
 * @param  string id
 * @param  string padding
 * @param  boolean last
 * @param  string width
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'bg_attachment' => '',
			'bg_color'      => '',
			'bg_image'      => '',
			'bg_position'   => '',
			'bg_repeat'     => '',
			'bg_size'       => '',
			'class'         => '',
			'font_color'    => '',
			'id'            => '',
			'padding'       => '',
			'last'          => false,
			'width'         => '1/1',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//attributes
		$atts['attributes'] = array( 'spacer' => '', 'style' => '' );
	//content
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//bg_color
		$atts['bg_color'] = trim( $atts['bg_color'] );
		if ( $atts['bg_color'] ) {
			$atts['attributes']['style'] .= ' background-color: ' . esc_attr( $atts['bg_color'] ) . ';';

			if ( absint( apply_filters( WMAMP_HOOK_PREFIX . 'color_brightness_treshold', WMAMP_COLOR_BRIGHTNESS_TRESHOLD ) ) > wma_color_brightness( $atts['bg_color'] ) ) {
				$atts['class'] .= ' colorset-bg-dark';
			} else {
				$atts['class'] .= ' colorset-bg-light';
			}
		}
	//bg_image
		$atts['bg_image'] = trim( $atts['bg_image'] );
		if ( is_numeric( $atts['bg_image'] ) ) {
			$image_size = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_image_size', 'full' );
			$image      = wp_get_attachment_image_src( absint( $atts['bg_image'] ), $image_size );

			if ( is_array( $image ) && isset( $image[0] ) && $image[0] ) {
				$atts['attributes']['style'] .= ' background-image: url(' . esc_url( $image[0] ) . ');';
			}
		} elseif ( $atts['bg_image'] ) {
			$atts['attributes']['style'] .= ' background-image: url(' . esc_url( $atts['bg_image'] ) . ');';
		}
	//bg_attachment
		$atts['bg_attachment'] = trim( $atts['bg_attachment'] );
		if ( $atts['bg_attachment'] && $atts['bg_image'] ) {
			$atts['bg_attachment'] = ' background-attachment: ' . esc_attr( $atts['bg_attachment'] ) . ';';
			$atts['attributes']['style'] .= apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_bg_attachment', $atts['bg_attachment'], $atts );
		}
	//bg_position
		$atts['bg_position'] = trim( $atts['bg_position'] );
		if ( $atts['bg_image'] ) {
			if ( $atts['bg_position'] ) {
				$atts['bg_position'] = ' background-position: ' . esc_attr( $atts['bg_position'] ) . ';';
			} else {
				$atts['bg_position'] = ' background-position: 50% 50%;';
			}
			$atts['attributes']['style'] .= apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_bg_position', $atts['bg_position'], $atts );
		}
	//bg_repeat
		$atts['bg_repeat'] = trim( $atts['bg_repeat'] );
		if ( $atts['bg_repeat'] && $atts['bg_image'] ) {
			$atts['bg_repeat'] = ' background-repeat: ' . esc_attr( $atts['bg_repeat'] ) . ';';
			$atts['attributes']['style'] .= apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_bg_repeat', $atts['bg_repeat'], $atts );
		}
	//bg_size
		$atts['bg_size'] = trim( $atts['bg_size'] );
		if ( $atts['bg_size'] && $atts['bg_image'] ) {
			$atts['bg_size'] = ' background-size: ' . esc_attr( $atts['bg_size'] ) . ';';
			$atts['attributes']['style'] .= apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_bg_size', $atts['bg_size'], $atts );
		}
	//font_color
		$atts['font_color'] = trim( $atts['font_color'] );
		if ( $atts['font_color'] ) {
			$atts['attributes']['style'] .= ' color: ' . esc_attr( $atts['font_color'] ) . ';';

			if ( absint( apply_filters( WMAMP_HOOK_PREFIX . 'color_brightness_treshold', WMAMP_COLOR_BRIGHTNESS_TRESHOLD ) ) > wma_color_brightness( $atts['font_color'] ) ) {
				$atts['class'] .= ' colorset-text-dark';
			} else {
				$atts['class'] .= ' colorset-text-light';
			}
		}
	//id
		$atts['id'] = trim( $atts['id'] );
		if ( $atts['id'] ) {
			$atts['attributes']['id'] = 'id="' . esc_attr( $atts['id'] ) . '"';
		}
	//padding
		$atts['padding'] = trim( str_replace( ';', '', $atts['padding'] ) );
		if ( $atts['padding'] ) {
			$atts['attributes']['style'] .= ' padding: ' . esc_attr( $atts['padding'] ) . ';';
		}
	//attributes
		$atts['attributes'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_html_attributes', $atts['attributes'], $atts );
	//style
		if ( isset( $atts['attributes']['style'] ) && $atts['attributes']['style'] ) {
			$atts['attributes']['style'] = 'style="' . esc_attr( trim( $atts['attributes']['style'] ) ) . '"';
		}
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
	$output = '<div class="' . $atts['class'] . '"' . implode( ' ', $atts['attributes'] ) . '>' . $atts['content'] . '</div>';

?>