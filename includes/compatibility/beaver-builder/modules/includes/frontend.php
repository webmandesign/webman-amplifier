<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Beaver Builder module frontend output
 *
 * This works as a global `frontend.php` file for all custom modules.
 * Differentiate the module output using the `$module` object passed
 * into the action hook below.
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.1.0
 * @version  1.6.0
 */





do_action( 'wmhook_amplifier_beaver_builder_module_frontend', $module, $settings );
