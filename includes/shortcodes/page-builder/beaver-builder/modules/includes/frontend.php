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
 * @version  1.1
 */



do_action( WM_SHORTCODES_HOOK_PREFIX . 'bb_module_output', $module, $settings );

?>