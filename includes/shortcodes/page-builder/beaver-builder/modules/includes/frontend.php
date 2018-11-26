<?php
/**
 * Custom Beaver Builder module frontend output
 *
 * This works as a global `frontend.php` file for all custom modules.
 * Differentiate the module output using the `$module` object passed
 * into the action hook below.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @uses  obj $module   FLBuilderModule extension class
 * @uses  obj $settings Module settings object
 *
 * @since    1.1
 * @version  1.3.15
 */



do_action( 'wmhook_shortcode_bb_module_frontend', $module, $settings );
