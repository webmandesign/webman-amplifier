<?php
/**
 * Tabs wrapper
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  integer active
 * @param  string class
 * @param  string layout
 * @param  boolean tour
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'active' => 0,
			'class'  => '',
			'layout' => 'top',
			'tour'   => false,
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Helper variables
	global $wm_shortcode_helper_variable;
	$wm_shortcode_helper_variable = $shortcode; //Passing the parent shortcode for "wm_item" shortcodes

//Validation
	//active
		$atts['active'] = absint( $atts['active'] );
	//layout
		$atts['layout'] = trim( $atts['layout'] );
		if ( ! in_array( $atts['layout'], array( 'top', 'left', 'right' ) ) ) {
			$atts['layout'] = 'top';
		}
	//content
		$content = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$content = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $content );
		//Prepare tabs output
			$tabs        = array();
			$tabs_output = '';
			preg_match_all( '/(data-title)=("[^"]*")/i', $content, $tabs );
			if (
					is_array( $tabs )
					&& ! empty( $tabs )
					&& isset( $tabs[2] )
				) {
				$tabs = $tabs[2];
				$tabs = str_replace( '"', '', $tabs );

				//Tabs output
					foreach ( $tabs as $tab ) {
						$tab          = explode( '&&', $tab );
						$tabs_output .= '<li class="wm-tab-items-' . $tab[0] . '"><a href="#' . $tab[0] . '" data-tab="#' . $tab[0] . '">' . html_entity_decode( $tab[1] ) . '</a></li>';
					}
					$tabs_output = '<ul class="wm-tab-links">' . $tabs_output . '</ul>';
			}

		//Implement tabs output
			$atts['content'] = $tabs_output . '<div class="wm-tabs-items">' . $content . '</div>';
	//class
		$atts['class']  = trim( esc_attr( 'wm-tabs clearfix ' . trim( $atts['class'] ) ) );
		$atts['class'] .= ' layout-' . $atts['layout'];
		if ( $atts['tour'] ) {
			$atts['class'] .= ' tour-tabs';
		}
		$atts['class']  = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', $atts['class'] );

//Enqueue scripts
	if ( apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_enqueue_scripts', true ) ) {
		wp_enqueue_script( 'wm-shortcodes-tabs' );
	}
	do_action( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_enqueue_scripts' );

//Output
	$output = '<div class="' . $atts['class'] . '" data-active="' . $atts['active'] . '">' . $atts['content'] . '</div>';

?>