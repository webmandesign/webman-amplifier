<?php
/**
 * Visual Composer plugin custom Accordion extension
 *
 * From "js-compose/composer/lib/shortcodes/accordion.php".
 * Extension class naming rules: 'WPBakeryShortCode_' . $vc_plugin['base']
 *
 * @since       1.0
 * @version     1.0.9.5
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 */



if ( class_exists( 'WPBakeryShortCode' ) ) {

	/**
	 * "wm_accordion" shortcode
	 *
	 * Unfortunatelly, due to WordPress PHP requirements (@link http://wordpress.org/about/requirements/),
	 * we can't use the class aliases available since PHP v5.3. So, have to create a new extension classes.
	 *
	 * @since    1.0
	 * @version  1.0.9.5
	 */
	class WPBakeryShortCode_wm_accordion extends WPBakeryShortCode {

		protected $controls_css_settings = 'out-tc vc_controls-content-widget';



		public function __construct( $settings ) {
			parent::__construct( $settings );
		} // /__construct



		public function contentAdmin( $atts, $content ) {
			$width = $custom_markup = '';
			$shortcode_attributes = array( 'width' => '1/1' );

			foreach ( $this->settings['params'] as $param ) {
				if ( $param['param_name'] != 'content' ) {
					if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
						$shortcode_attributes[ $param['param_name'] ] = $param['value'];
					} elseif ( isset( $param['value'] ) ) {
						$shortcode_attributes[ $param['param_name'] ] = $param['value'];
					}
				} elseif ( $param['param_name'] == 'content' && $content == NULL ) {
					$content = $param['value'];
				}
			}

			extract( shortcode_atts( $shortcode_attributes, $atts ) );

			$output = $inner = '';
			$elem   = $this->getElementHolder( $width );

			foreach ( $this->settings['params'] as $param ) {
				$param_value = '';
				$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
				if ( is_array( $param_value ) ) {
					// Get first element from the array
					reset( $param_value );
					$first_key   = key( $param_value );
					$param_value = $param_value[$first_key];
				}
				$inner .= $this->singleParamHtmlHolder( $param, $param_value );
			}

			$tmp = '';

			if ( isset($this->settings['custom_markup']) && $this->settings['custom_markup'] != '' ) {
				if ( $content != '' ) {
					$custom_markup = str_ireplace( "%content%", $tmp.$content, $this->settings['custom_markup'] );
				} else if ( $content == '' && isset( $this->settings['default_content_in_template'] ) && $this->settings['default_content_in_template'] != '' ) {
					$custom_markup = str_ireplace( "%content%", $this->settings['default_content_in_template'], $this->settings['custom_markup'] );
				} else {
					$custom_markup = str_ireplace( "%content%", '', $this->settings['custom_markup'] );
				}
				$inner .= do_shortcode( $custom_markup );
			}

			$elem   = str_ireplace( '%wpb_element_content%', $inner, $elem );
			$output = $elem;

			return $output;
		} // /contentAdmin

	} // /WPBakeryShortCode_wm_accordion





	/**
	 * "wm_tabs" shortcode
	 *
	 * Has the same admin interface as the "wm_accordion" shortcode.
	 *
	 * Unfortunatelly, due to WordPress PHP requirements (@link http://wordpress.org/about/requirements/),
	 * we can't use the class aliases available since PHP v5.3. So, have to create a new extension classes.
	 *
	 * @since    1.0
	 * @version  1.0.9.5
	 */
	class WPBakeryShortCode_wm_tabs extends WPBakeryShortCode {

		protected $controls_css_settings = 'out-tc vc_controls-content-widget';



		public function __construct( $settings ) {
			parent::__construct( $settings );
		} // /__construct



		public function contentAdmin( $atts, $content ) {
			$width = $custom_markup = '';
			$shortcode_attributes = array( 'width' => '1/1' );

			foreach ( $this->settings['params'] as $param ) {
				if ( $param['param_name'] != 'content' ) {
					if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
						$shortcode_attributes[ $param['param_name'] ] = $param['value'];
					} elseif ( isset( $param['value'] ) ) {
						$shortcode_attributes[ $param['param_name'] ] = $param['value'];
					}
				} elseif ( $param['param_name'] == 'content' && $content == NULL ) {
					$content = $param['value'];
				}
			}

			extract( shortcode_atts( $shortcode_attributes, $atts ) );

			$output = $inner = '';
			$elem = $this->getElementHolder( $width );

			foreach ( $this->settings['params'] as $param ) {
				$param_value = '';
				$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
				if ( is_array( $param_value ) ) {
					// Get first element from the array
					reset( $param_value );
					$first_key   = key( $param_value );
					$param_value = $param_value[$first_key];
				}
				$inner .= $this->singleParamHtmlHolder( $param, $param_value );
			}

			$tmp = '';

			if ( isset($this->settings['custom_markup']) && $this->settings['custom_markup'] != '' ) {
				if ( $content != '' ) {
					$custom_markup = str_ireplace( "%content%", $tmp.$content, $this->settings['custom_markup'] );
				} else if ( $content == '' && isset( $this->settings['default_content_in_template'] ) && $this->settings['default_content_in_template'] != '' ) {
					$custom_markup = str_ireplace( "%content%", $this->settings['default_content_in_template'], $this->settings['custom_markup'] );
				} else {
					$custom_markup = str_ireplace( "%content%", '', $this->settings['custom_markup'] );
				}
				$inner .= do_shortcode( $custom_markup );
			}

			$elem = str_ireplace( '%wpb_element_content%', $inner, $elem );
			$output = $elem;

			return $output;
		} // /contentAdmin

	} // /WPBakeryShortCode_wm_tabs





	/**
	 * "wm_pricing_table" shortcode
	 *
	 * Has the same admin interface as the "wm_accordion" shortcode.
	 *
	 * Unfortunatelly, due to WordPress PHP requirements (@link http://wordpress.org/about/requirements/),
	 * we can't use the class aliases available since PHP v5.3. So, have to create a new extension classes.
	 *
	 * @since    1.0
	 * @version  1.0.9.5
	 */
	class WPBakeryShortCode_wm_pricing_table extends WPBakeryShortCode {

		protected $controls_css_settings = 'out-tc vc_controls-content-widget';



		public function __construct( $settings ) {
			parent::__construct( $settings );
		} // /__construct



		public function contentAdmin( $atts, $content ) {
			$width = $custom_markup = '';
			$shortcode_attributes = array( 'width' => '1/1' );

			foreach ( $this->settings['params'] as $param ) {
				if ( $param['param_name'] != 'content' ) {
					if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
						$shortcode_attributes[ $param['param_name'] ] = $param['value'];
					} elseif ( isset( $param['value'] ) ) {
						$shortcode_attributes[ $param['param_name'] ] = $param['value'];
					}
				} elseif ( $param['param_name'] == 'content' && $content == NULL ) {
					$content = $param['value'];
				}
			}

			extract( shortcode_atts( $shortcode_attributes, $atts ) );

			$output = $inner = '';
			$elem = $this->getElementHolder( $width );

			foreach ( $this->settings['params'] as $param ) {
				$param_value = '';
				$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
				if ( is_array( $param_value ) ) {
					// Get first element from the array
					reset( $param_value );
					$first_key   = key( $param_value );
					$param_value = $param_value[$first_key];
				}
				$inner .= $this->singleParamHtmlHolder( $param, $param_value );
			}

			$tmp = '';

			if ( isset( $this->settings['custom_markup'] ) && $this->settings['custom_markup'] != '' ) {
				if ( $content != '' ) {
					$custom_markup = str_ireplace( "%content%", $tmp.$content, $this->settings['custom_markup'] );
				} else if ( $content == '' && isset( $this->settings['default_content_in_template'] ) && $this->settings['default_content_in_template'] != '' ) {
					$custom_markup = str_ireplace( "%content%", $this->settings['default_content_in_template'], $this->settings['custom_markup'] );
				} else {
					$custom_markup = str_ireplace( "%content%", '', $this->settings['custom_markup'] );
				}
				$inner .= do_shortcode( $custom_markup );
			}

			$elem = str_ireplace( '%wpb_element_content%', $inner, $elem );
			$output = $elem;

			return $output;
		} // /contentAdmin

	} // /WPBakeryShortCode_wm_pricing_table

} // /class_exists( 'WPBakeryShortCode' )





/**
 * Visual Composer 4.2+ support
 *
 * @since  1.0.8
 */
if (
		! class_exists( 'WPBakeryShortCode_VC_Tab' )
		&& function_exists( 'vc_path_dir' )
		&& vc_path_dir( 'SHORTCODES_DIR', 'vc-tab.php' )
	) {
	require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-tab.php' );
}

if ( class_exists( 'WPBakeryShortCode_VC_Tab' ) ) {

	/**
	 * "wm_item" shortcode
	 *
	 * Unfortunatelly, due to WordPress PHP requirements (@link http://wordpress.org/about/requirements/),
	 * we can't use the class aliases available since PHP v5.3. So, have to create a new extension classes.
	 *
	 * @since    1.0
	 * @version  1.0.9.5
	 */
	class WPBakeryShortCode_wm_item extends WPBakeryShortCode_VC_Tab {

		protected $predefined_atts = array(
				'icon'        => '',
				'heading_tag' => 'h3',
				'tags'        => '',
				'title'       => 'TITLE?',
			);



		public function contentAdmin( $atts, $content = null ) {
			$title = $output = '';

			extract( shortcode_atts( apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', $this->predefined_atts, 'item' ), $atts ) );

			$column_controls = $this->getColumnControls( $this->settings( 'controls' ) );
			$column_controls_bottom = $this->getColumnControls( 'add', 'bottom-controls' );

			$width = array( '' );

			for ( $i = 0; $i < count( $width ); $i++ ) {
				$output .= '<div class="group wpb_sortable">';
				$output .= '<h3><span class="tab-label"><%= params.title %></span></h3>';
				$output .= '<div ' . $this->mainHtmlBlockParams( $width, $i ) . '>';
				$output .= str_replace( "%column_size%", wpb_translateColumnWidthToFractional( $width[$i] ), $column_controls );
				$output .= '<div class="wpb_element_wrapper">';
				$output .= '<div ' . $this->containerHtmlBlockParams( $width, $i ) . '>';
				$output .= do_shortcode( shortcode_unautop( $content ) );

				/*
				REMOVED IN v1.0.9.5
				if ( function_exists( 'vc_backend_editor' ) ) {
				//Visual Composer 4.2+
					$output .= vc_backend_editor()->getLayout()->getContainerHelper();
				} else {
				//Visual Composer 4.2-, legacy support
					$output .= WPBakeryVisualComposer::getInstance()->getLayout()->getContainerHelper();
				}
				*/

				$output .= '</div>';
				if ( isset( $this->settings['params'] ) ) {
					$inner = '';
					foreach ( $this->settings['params'] as $param ) {
						$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
						if ( is_array( $param_value ) ) {
							// Get first element from the array
							reset( $param_value );
							$first_key = key( $param_value );
							$param_value = $param_value[$first_key];
						}
						$inner .= $this->singleParamHtmlHolder( $param, $param_value );
					}
					$output .= $inner;
				}
				$output .= '</div>';
				$output .= str_replace( "%column_size%", wpb_translateColumnWidthToFractional( $width[$i] ), $column_controls_bottom );
				$output .= '</div>';
				$output .= '</div>';
			}

			return $output;
		} // /contentAdmin



		public function mainHtmlBlockParams( $width, $i ) {
			return 'data-element_type="' . $this->settings['base'] . '" class="wpb_' . $this->settings['base'] . ' ' . $this->settings['class'] . '"' . $this->customAdminBlockParams();
		} // /mainHtmlBlockParams



		public function containerHtmlBlockParams( $width, $i ) {
			return 'class="wpb_column_container vc_container_for_children"';
		} // /containerHtmlBlockParams



		public function contentAdmin_old( $atts, $content = null ) {
			$width = $output = $title = '';

			extract( shortcode_atts( apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', $this->predefined_atts, 'item' ), $atts ) );

			$column_controls = $this->getColumnControls( $this->settings( 'controls' ) );

			for ( $i = 0; $i < count( $width ); $i++ ) {
				$output .= '<div class="group wpb_sortable">';
				$output .= '<div class="wpb_element_wrapper">';
				$output .= '<div class="vc_row-fluid wpb_row_container">';
				$output .= '<h3><a href="#">' . $title . '</a></h3>';
				$output .= '<div ' . $this->customAdminBockParams() . ' data-element_type="' . $this->settings["base"] . '" class=" wpb_' . $this->settings['base'] . ' wpb_sortable">';
				$output .= '<div class="wpb_element_wrapper">';
				$output .= '<div class="vc_row-fluid wpb_row_container">';
				$output .= do_shortcode( shortcode_unautop( $content ) );
				$output .= '</div>';
				if ( isset( $this->settings['params'] ) ) {
					$inner = '';
					foreach ( $this->settings['params'] as $param ) {
						$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
						if ( is_array( $param_value ) ) {
							// Get first element from the array
							reset( $param_value );
							$first_key = key( $param_value );
							$param_value = $param_value[$first_key];
						}
						$inner .= $this->singleParamHtmlHolder( $param, $param_value );
					}
					$output .= $inner;
				}
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
			}

			return $output;
		} // /contentAdmin_old



		protected function outputTitle( $title ) {
			return  '';
		} // /outputTitle



		public function customAdminBlockParams() {
			return '';
		} // /customAdminBlockParams

	} // /WPBakeryShortCode_wm_item

} // /class_exists( 'WPBakeryShortCode_VC_Tab' )

?>