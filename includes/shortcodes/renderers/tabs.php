<?php
/**
 * Tabs wrapper
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1.6
 *
 * @param  integer active
 * @param  string class
 * @param  string layout
 * @param  boolean tour
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'active' => 0,
			'class'  => '',
			'layout' => 'top',
			'tour'   => false,
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
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
		$content = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$content = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $content, $atts );
		//Prepare tabs output
			$tabs        = array();
			$tabs_output = '';
			preg_match_all( '/(data-title)=("[^"]*")/i', $content, $tabs );
			if (
					is_array( $tabs )
					&& ! empty( $tabs )
					&& isset( $tabs[2] )
				) {
				$i    = 0;
				$tabs = $tabs[2];
				$tabs = str_replace( '"', '', $tabs );

				//Tabs output
					foreach ( $tabs as $tab ) {
						$tab          = explode( '&&', $tab );
						$tabs_output .= '<li class="wm-tab-items-' . esc_attr( $tab[0] ) . '"><a href="#' . esc_attr( $tab[0] ) . '" data-tab="#' . esc_attr( $tab[0] ) . '">' . html_entity_decode( $tab[1] ) . '</a></li>';
						$i++;
					}
					$tabs_output = '<ul class="wm-tab-links wm-tab-count-' . esc_attr( $i ) . '">' . $tabs_output . '</ul>';
			}

		//Implement tabs output
			$atts['content'] = $tabs_output . '<div class="wm-tabs-items">' . $content . '</div>';
	//class
		$atts['class']  = trim( esc_attr( 'wm-tabs clearfix ' . trim( $atts['class'] ) ) );
		$atts['class'] .= ' layout-' . $atts['layout'];
		if ( $atts['tour'] ) {
			$atts['class'] .= ' tour-tabs';
		}
		$atts['class']  = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );

//Enqueue scripts
	$enqueue_scripts = array(
			'wm-shortcodes-tabs'
		);

	wma_shortcode_enqueue_scripts( $shortcode, $enqueue_scripts, $atts );

//Output
	$output = '<div class="' . esc_attr( $atts['class'] ) . '" data-active="' . esc_attr( $atts['active'] ) . '">' . $atts['content'] . '</div>';

?>