<?php
/**
 * Item (can be accordion/tab item)
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  string icon
 * @param  string heading_tag (heading tag setup option for better SEO)
 * @param  string tags
 * @param  string title
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'icon'        => '',
			'heading_tag' => 'h3',
			'tags'        => '',
			'title'       => 'TITLE?',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Helper variables
	global $wm_shortcode_helper_variable; //Passing the parent shortcode for "wm_item" shortcodes

//Validation
	//content
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//title
		$atts['title'] = strip_tags( trim( $atts['title'] ), $this->inline_tags );
	//icon
		$atts['icon'] = trim( $atts['icon'] );
		if ( $atts['icon'] ) {
			$atts['title'] = '<i class="' . esc_attr( $atts['icon'] ) . '"></i>' . $atts['title'];
		}
	//tags
		$atts['tag_names'] = array();
		$atts['tags']      = trim( $atts['tags'] );
		$atts['tags']      = str_replace( ', ', ',', $atts['tags'] );
		$atts['tags']      = explode( ',', $atts['tags'] );
		foreach ( $atts['tags'] as $key => $tag ) {
			$tag = trim( $tag );
			if ( $tag ) {
				$atts['tag_names'][$key] = $tag;
				$atts['tags'][$key]      = 'tag-' . sanitize_html_class( $tag );
			} else {
				unset( $atts['tags'][$key] );
			}
		}
		$atts['tags'] = esc_attr( implode( ' ', $atts['tags'] ) );
	//class
		$atts['class'] = array(
				'wrapper' => 'wm-item wm-item-wrap',
				'title'   => 'wm-item-title',
				'content' => 'wm-item-content clearfix',
			);
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', $atts['class'] );

//Output
	if ( 'accordion' == $wm_shortcode_helper_variable ) {
	//Markup for "wm_accordion" parent shortcode

		$output  = "\r\n" . '<div class="' .  esc_attr( trim( $atts['class']['wrapper'] . ' ' . $atts['tags'] ) ) . '">';
		$output .= '<' . $atts['heading_tag'] . ' class="wm-item-title ' . esc_attr( trim( $atts['class']['title'] . ' ' . $atts['tags'] ) ) . '" data-tags="' . $atts['tags'] . '" data-tag-names="' . esc_attr( implode( '|', $atts['tag_names'] ) ) . '">' . $atts['title'] . '</' . $atts['heading_tag'] . '>';
		$output .= '<div class="' . esc_attr( trim( $atts['class']['content'] . ' ' . sanitize_html_class( strip_tags( $atts['title'] ) ) ) ) . '">' . $atts['content'] . '</div>';
		$output .= '</div>' . "\r\n";

	} elseif ( 'tabs' == $wm_shortcode_helper_variable ) {
	//Markup for "wm_tabs" parent shortcode

		$i      = rand( 100, 999 );
		$output = "\r\n" . '<div class="' . esc_attr( trim( $atts['class']['wrapper'] . ' ' . sanitize_html_class( strip_tags( $atts['title'] ) ) . '_' . $i ) ) . '" id="' . sanitize_html_class( strip_tags( $atts['title'] ) ) . '_' . $i . '" data-title="' . sanitize_html_class( strip_tags( $atts['title'] ) ) . '_' . $i . '&&' . esc_attr( $atts['title'] ) . '">' . $atts['content'] . '</div>' . "\r\n";

	}

?>