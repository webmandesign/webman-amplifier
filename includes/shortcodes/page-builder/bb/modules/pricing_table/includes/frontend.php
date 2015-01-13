<?php
/**
 * Custom Beaver Builder module init
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.1
 * @version  1.1
 *
 * CONTENT:
 * - 10) Helper variables
 * - 20) Output
 */





/**
 * 10) Helper variables
 */

	$module = basename( dirname( dirname( __FILE__ ) ) );





/**
 * 20) Output
 */

	do_action( WM_SHORTCODES_HOOK_PREFIX . 'bb_module_output', $module, $settings );

?>