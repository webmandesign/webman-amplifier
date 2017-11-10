<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Beaver Builder module frontend CSS output
 *
 * This works as a global `frontend.css.php` file for all custom modules.
 * Differentiate the module output using the `$module` object passed
 * into the action hook below.
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.3.15
 * @version  1.6.0
 */



do_action( 'wmhook_amplifier_beaver_builder_module_frontend_css', $module, $settings );
