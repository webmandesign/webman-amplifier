<?php
/**
 * Custom Beaver Builder module frontend JavaScript output
 *
 * This works as a global `frontend.js.php` file for all custom modules.
 * Differentiate the module output using the `$module` object passed
 * into the action hook below.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @uses  obj $module   FLBuilderModule extension class
 * @uses  obj $settings Module settings object
 *
 * @since    1.3.15
 * @version  1.3.15
 */



do_action( 'wmhook_shortcode_bb_module_frontend_js', $module, $settings );
