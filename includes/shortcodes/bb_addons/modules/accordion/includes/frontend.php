<?php
/**
 * Custom Beaver Builder module init
 *
 * Accordion module
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   2015 WebMan - Oliver Juhas
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

	$module = 'accordion';





/**
 * 20) Output
 */

	do_action( WM_SHORTCODES_HOOK_PREFIX . 'bb_module_output', $module, $settings );

?>