<?php
/**
 * Search Form
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Variables come from WM_Shortcodes::shortcode_render(), they are not global.
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

// Output

	$output = get_search_form( false );

// phpcs:enable
