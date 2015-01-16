<?php
/**
 * Price (Pricing Table shortcode item)
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1
 *
 * @param  string caption
 * @param  string class
 * @param  string color
 * @param  string cost
 * @param  string heading_tag (heading tag setup option for better SEO)
 * @param  string type Legacy attribute
 * @param  string appearance Introduced not to conflict with Beaver Builder
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'appearance'  => '',
			'caption'     => '',
			'class'       => '',
			'color'       => '',
			'color_text'  => '',
			'cost'        => '',
			'heading_tag' => 'h3',
			'type'        => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Helper variables
	global $wm_shortcode_helper_variable; //Dynamic columns counting for current Pricing Table shortcode

//Validation
	//type
		//Fix for Beaver Builder
			if ( $atts['appearance'] ) {
				$atts['type'] = $atts['appearance'];
			}
		$atts['type'] = trim( $atts['type'] );
		if ( ! in_array( $atts['type'], array( 'featured', 'legend' ) ) ) {
			$atts['type'] = 'default';
		}
	//caption
		$atts['caption'] = '<' . $atts['heading_tag'] . ' class="wm-price-caption wm-price-element">' . strip_tags( trim( $atts['caption'] ), $this->inline_tags ) . '</' . $atts['heading_tag'] . '>';
	//color
		$atts['color']      = strtolower( preg_replace( '/[^a-fA-F0-9]/', '', $atts['color'] ) );
		$atts['color_text'] = strtolower( preg_replace( '/[^a-fA-F0-9]/', '', $atts['color_text'] ) );
		$atts['style']      = '';
		if ( $atts['color'] && 'legend' != $atts['type'] ) {
			if ( ! $atts['color_text'] ) {
				$atts['color_text'] = str_replace( '#', '', wma_contrast_color( $atts['color'], 170 ) );
				$atts['color_text'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_color_text', $atts['color_text'] );
			}
			$atts['style']      = ' style="background-color: #' . $atts['color'] . '; border-color: #' . $atts['color'] . '; color: #' . $atts['color_text'] . '"';
		}
	//cost
		$atts['cost'] = '<div class="wm-price-cost wm-price-element">' . do_shortcode( trim( $atts['cost'] ) ) . '</div>';
	//content
		$replacement     = array(
				'<p>'  => '<div class="wm-price-feature-row">',
				'</p>' => '</div>',
			);
		$content         = str_replace( array_keys( $replacement ), $replacement, wpautop( $content ) );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
		$atts['content'] = '<div class="wm-price-features wm-price-element">' . $atts['content'] . '</div>';
	//header
		$atts['header'] = '<div class="wm-price-header wm-price-element"' . $atts['style'] . '>' . $atts['caption'] . $atts['cost'] . '</div>';
	//class
		$atts['class']  = trim( esc_attr( 'wm-price ' . $atts['class'] ) );
		$atts['class'] .= ' wm-column width-1-{{columns}} price-column-' . ++$wm_shortcode_helper_variable;
		$atts['class'] .= ' type-' . $atts['type'];
		$atts['class']  = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', $atts['class'] );

//Output
	$output = "\r\n" . '<div class="' . $atts['class'] . '">' . $atts['header'] . $atts['content'] . '</div>' . "\r\n";

?>