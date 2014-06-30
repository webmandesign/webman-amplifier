<?php
/**
 * WebMan Amplifier
 *
 * A set of additional features for WebMan themes (http://www.webmandesign.eu).
 *
 * @package    WebMan Amplifier
 * @author     WebMan
 * @license    GPL-2.0+
 * @link       http://www.webmandesign.eu
 * @copyright  2014 WebMan - Oliver Juhas
 *
 * Plugin Name:        WebMan Amplifier
 * Plugin URI:         http://www.webmandesign.eu/
 * Description:        Pack of additional WordPress features. Contains shortcodes, additional custom post types, meta box generator, Visual Composer plugin (3rd party) integration, icon font management.
 * Version:            1.0.9.3
 * Author:             WebMan - Oliver Juhas
 * Author URI:         http://www.webmandesign.eu/
 * Text Domain:        wm_domain
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:        /languages
 * Requires at least:  3.8
 * Tested up to:       3.9
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * Constants
 */

	//Define global constants
		//Plugin version
			define( 'WMAMP_VERSION',      '1.0.9.3' );
		//Special filter/action hooks prefix
			define( 'WMAMP_HOOK_PREFIX',  'wmhook_wmamp_' );
		//Paths
			define( 'WMAMP_PLUGIN_FILE',  __FILE__                                         );
			define( 'WMAMP_PLUGIN_DIR',   plugin_dir_path( __FILE__ )                      );
			define( 'WMAMP_PLUGIN_URL',   plugin_dir_url( __FILE__ )                       );
			define( 'WMAMP_INCLUDES_DIR', trailingslashit( WMAMP_PLUGIN_DIR . 'includes' ) );
			define( 'WMAMP_ASSETS_DIR',   trailingslashit( WMAMP_PLUGIN_DIR . 'assets' )   );
			define( 'WMAMP_ASSETS_URL',   trailingslashit( WMAMP_PLUGIN_URL . 'assets' )   );
		//Variable defaults
			define( 'WMAMP_COLOR_BRIGHTNESS_TRESHOLD', 127 );

	//Define Metabox class constants
		//Special filter/action hooks prefix
			define( 'WM_METABOX_HOOK_PREFIX', 'wmhook_metabox_' );
		//Input fields prefixes
			define( 'WM_METABOX_FIELD_PREFIX', 'wm-' );
		//Name of the meta variable (serialized array) to be stored in WordPress database
			define( 'WM_METABOX_SERIALIZED_NAME', '_' . WM_METABOX_FIELD_PREFIX . 'meta' );
		//HTML tags allowed in meta field labels
			define( 'WM_METABOX_LABEL_HTML', '<a><br><code><em><img><small><strong>' );
		//Paths
			define( 'WM_METABOX_FIELDS_DIR', WMAMP_INCLUDES_DIR . 'metabox/fields/' );

	//Define Shortcodes class constants
		//Special filter/action hooks prefix
			define( 'WM_SHORTCODES_HOOK_PREFIX', 'wmhook_shortcode_' );

	//Define Font Icons class constants
		//Special filter/action hooks prefix
			define( 'WM_ICONS_HOOK_PREFIX', 'wmhook_icons_' );



/**
 * Required files
 */

	//Load the main plugin class
		require_once( WMAMP_PLUGIN_DIR . 'class-wm-amplifier.php' );



/**
 * The main function responsible for returning the plugin instance
 * to functions everywhere.
 *
 * Use this function like you would a global variable, except without
 * needing to declare the global.
 *
 * Example: <?php $wmamp = wm_amplifier(); ?>
 *
 * @since   1.0
 *
 * @return  WebMan Amplifier instance
 */
function wma_amplifier() {
	return WM_Amplifier::instance();
} // /wma_amplifier



/**
 * Plugin activation
 *
 * @since  1.0
 */
function wma_amplifier_activate() {
	do_action( WMAMP_HOOK_PREFIX . 'plugin_activation' );
} // /wma_amplifier_activate

register_activation_hook( WMAMP_PLUGIN_FILE, 'wma_amplifier_activate' );



/**
 * Plugin deactivation
 *
 * @since  1.0.5
 */
function wma_amplifier_deactivate() {
	do_action( WMAMP_HOOK_PREFIX . 'plugin_deactivation' );
} // /wma_amplifier_deactivate

register_deactivation_hook( WMAMP_PLUGIN_FILE, 'wma_amplifier_deactivate' );



/**
 * Hook WebMan Amplifier early onto the 'plugins_loaded' action.
 *
 * This gives all other plugins the chance to load before WebMan Amplifier, to get
 * their actions, filters, and overrides setup without WebMan Amplifier being in the way.
 */
if ( defined( 'WMAMP_LATE_LOAD' ) ) {
	add_action( 'plugins_loaded', 'wm_amplifier', (int) WMAMP_LATE_LOAD );
} else {
	wma_amplifier();
}

?>