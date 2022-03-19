<?php
/**
 * WebMan Amplifier
 *
 * A set of additional features for WebMan themes (http://www.webmandesign.eu).
 *
 * @package    WebMan Amplifier
 * @author     WebMan Design
 * @copyright  WebMan Design, Oliver Juhas
 * @license    GNU General Public License v3
 *
 * @link  https://www.webmandesign.eu
 *
 * @wordpress-plugin
 * Plugin Name:        WebMan Amplifier
 * Plugin URI:         https://github.com/webmandesign/webman-amplifier
 * Description:        Pack of additional WordPress features. Contains additional custom post types, shortcodes, page builder integration, meta box generator and icon font management.
 * Version:            1.5.10
 * Author:             WebMan Design, Oliver Juhas
 * Author URI:         https://www.webmandesign.eu
 * Text Domain:        webman-amplifier
 * Domain Path:        /languages
 * License:            GNU General Public License v3
 * License URI:        http://www.gnu.org/licenses/gpl-3.0.txt
 * Requires at least:  4.3
 * Tested up to:       5.9
 */





// Exit if accessed directly

	if ( ! defined( 'ABSPATH' ) ) exit;





/**
 * Constants
 */

	// Define global constants

		// Plugin version

			if ( ! defined( 'WMAMP_VERSION' ) ) define( 'WMAMP_VERSION', '1.5.10' );

		// Paths

			if ( ! defined( 'WMAMP_PLUGIN_FILE' ) )  define( 'WMAMP_PLUGIN_FILE',  __FILE__                                          );
			if ( ! defined( 'WMAMP_PLUGIN_DIR' ) )   define( 'WMAMP_PLUGIN_DIR',   plugin_dir_path( __FILE__ )                       );
			if ( ! defined( 'WMAMP_PLUGIN_URL' ) )   define( 'WMAMP_PLUGIN_URL',   plugin_dir_url( __FILE__ )                        );
			if ( ! defined( 'WMAMP_INCLUDES_DIR' ) ) define( 'WMAMP_INCLUDES_DIR', trailingslashit( WMAMP_PLUGIN_DIR ) . 'includes/' );
			if ( ! defined( 'WMAMP_INCLUDES_URL' ) ) define( 'WMAMP_INCLUDES_URL', trailingslashit( WMAMP_PLUGIN_URL ) . 'includes/' );
			if ( ! defined( 'WMAMP_ASSETS_DIR' ) )   define( 'WMAMP_ASSETS_DIR',   trailingslashit( WMAMP_PLUGIN_DIR ) . 'assets/'   );
			if ( ! defined( 'WMAMP_ASSETS_URL' ) )   define( 'WMAMP_ASSETS_URL',   trailingslashit( WMAMP_PLUGIN_URL ) . 'assets/'   );

		// Variables

			if ( ! defined( 'WMAMP_COLOR_BRIGHTNESS_TRESHOLD' ) ) define( 'WMAMP_COLOR_BRIGHTNESS_TRESHOLD', 127 );

	// Define Metabox class constants

		if ( ! defined( 'WM_METABOX_FIELD_PREFIX' ) )    define( 'WM_METABOX_FIELD_PREFIX',    'wm-'                                   );
		if ( ! defined( 'WM_METABOX_SERIALIZED_NAME' ) ) define( 'WM_METABOX_SERIALIZED_NAME', '_' . WM_METABOX_FIELD_PREFIX . 'meta'  );
		if ( ! defined( 'WM_METABOX_LABEL_HTML' ) )      define( 'WM_METABOX_LABEL_HTML',      '<a><br><code><em><img><small><strong>' );





/**
 * Required files
 */

	// Load the main plugin class

		require_once WMAMP_PLUGIN_DIR . 'class-wm-amplifier.php';

	// Load helper functions

		require_once WMAMP_INCLUDES_DIR . 'functions.php';

	// Load 3rd party plugins compatibility

		require_once WMAMP_INCLUDES_DIR . 'compatibility/compatibility.php';





/**
 * Functions
 */

	/**
	 * The main function responsible for returning the plugin instance
	 * to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without
	 * needing to declare the global.
	 *
	 * Example: <?php $wmamp = wm_amplifier(); ?>
	 *
	 * @since    1.0
	 * @version  1.2.2
	 *
	 * @return  WebMan Amplifier instance
	 */
	function wma_amplifier() {

		// Output

			return WM_Amplifier::instance();

	} // /wma_amplifier



	/**
	 * Plugin activation
	 *
	 * @since    1.0
	 * @version  1.2.2
	 */
	function wma_amplifier_activate() {

		// Processing

			do_action( 'wmhook_wmamp_' . 'plugin_activation' );

	} // /wma_amplifier_activate

	register_activation_hook( WMAMP_PLUGIN_FILE, 'wma_amplifier_activate' );



	/**
	 * Plugin deactivation
	 *
	 * @since    1.0.5
	 * @version  1.2.2
	 */
	function wma_amplifier_deactivate() {

		// Processing

			do_action( 'wmhook_wmamp_' . 'plugin_deactivation' );

	} // /wma_amplifier_deactivate

	register_deactivation_hook( WMAMP_PLUGIN_FILE, 'wma_amplifier_deactivate' );



	/**
	 * Hook WebMan Amplifier early onto the 'plugins_loaded' action.
	 *
	 * This gives all other plugins the chance to load before WebMan Amplifier, to get
	 * their actions, filters, and overrides setup without WebMan Amplifier being in the way.
	 *
	 * @since    1.0
	 * @version  1.2.2
	 */
	if ( defined( 'WMAMP_LATE_LOAD' ) ) {

		add_action( 'plugins_loaded', 'wma_amplifier', (int) WMAMP_LATE_LOAD );

	} else {

		wma_amplifier();

	}
