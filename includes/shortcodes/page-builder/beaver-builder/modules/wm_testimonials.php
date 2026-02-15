<?php
/**
 * Custom Beaver Builder module init
 *
 * Testimonials
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.1
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * 10) Helper variables
 */

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
	$module = wma_bb_get_custom_module_slug( __FILE__ );
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
	$module_form = wma_bb_shortcode_def( $module, 'form' );
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
	$module_form_children = wma_bb_shortcode_def( $module, 'form_children' );

/**
 * 20) Registration
 */

	/**
	 * Module registration class
	 */
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- prefixed with "WM"
	class WM_BB_Module_Testimonials extends FLBuilderModule {

		public function __construct() {

			$module = wma_bb_get_custom_module_slug( __FILE__ );

			parent::__construct( apply_filters( 'wmhook_wmamp_bb_module_construct_' . $module, wma_bb_shortcode_def( $module, 'register' ) ) );

		} // /__construct

	} // /WM_BB_Module_Testimonials

/**
 * 30) Forms
 */

	/**
	 * Register the module and its form
	 */
	if ( ! empty( $module_form ) && is_array( $module_form ) ) {
		FLBuilder::register_module( 'WM_BB_Module_Testimonials', $module_form );
	}

	/**
	 * Module children form
	 */
	if ( ! empty( $module_form_children ) && is_array( $module_form_children ) ) {
		FLBuilder::register_settings_form( 'wm_children_form_' . $module, $module_form_children );
	}
