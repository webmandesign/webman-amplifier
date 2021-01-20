<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WebMan Amplifier
 *
 * A set of additional features for WebMan themes (http://www.webmandesign.eu).
 *
 * @package    WebMan Amplifier
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @link  https://www.webmandesign.eu
 *
 * @wordpress-plugin
 * Plugin Name:        WebMan Amplifier
 * Plugin URI:         https://github.com/webmandesign/webman-amplifier
 * Author:             WebMan Design, Oliver Juhas
 * Author URI:         https://www.webmandesign.eu
 * Version:            1.6.0
 * Requires at least:  4.3
 * Tested up to:       5.6
 * Text Domain:        webman-amplifier
 * Domain Path:        /languages
 * License:            GNU General Public License v3
 * License URI:        http://www.gnu.org/licenses/gpl-3.0.txt
 * Description:        Pack of additional WordPress features. Contains custom post types, shortcodes (with page builder integration), meta box generator and icon font management.
 */





/**
 * Constants
 */

	if ( ! defined( 'WMAMP_VERSION' ) ) define( 'WMAMP_VERSION', '1.6.0' );

	if ( ! defined( 'WMAMP_PLUGIN_FILE' ) )  define( 'WMAMP_PLUGIN_FILE',  __FILE__                                          );
	if ( ! defined( 'WMAMP_PLUGIN_DIR' ) )   define( 'WMAMP_PLUGIN_DIR',   plugin_dir_path( __FILE__ )                       );
	if ( ! defined( 'WMAMP_PLUGIN_URL' ) )   define( 'WMAMP_PLUGIN_URL',   plugin_dir_url( __FILE__ )                        );
	if ( ! defined( 'WMAMP_INCLUDES_DIR' ) ) define( 'WMAMP_INCLUDES_DIR', trailingslashit( WMAMP_PLUGIN_DIR ) . 'includes/' );
	if ( ! defined( 'WMAMP_INCLUDES_URL' ) ) define( 'WMAMP_INCLUDES_URL', trailingslashit( WMAMP_PLUGIN_URL ) . 'includes/' );
	if ( ! defined( 'WMAMP_ASSETS_DIR' ) )   define( 'WMAMP_ASSETS_DIR',   trailingslashit( WMAMP_PLUGIN_DIR ) . 'assets/'   );
	if ( ! defined( 'WMAMP_ASSETS_URL' ) )   define( 'WMAMP_ASSETS_URL',   trailingslashit( WMAMP_PLUGIN_URL ) . 'assets/'   );

	if ( ! defined( 'WMAMP_COLOR_BRIGHTNESS_TRESHOLD' ) ) define( 'WMAMP_COLOR_BRIGHTNESS_TRESHOLD', 127 );

	if ( ! defined( 'WM_METABOX_FIELD_PREFIX' ) )    define( 'WM_METABOX_FIELD_PREFIX',    'wm-'                                   );
	if ( ! defined( 'WM_METABOX_SERIALIZED_NAME' ) ) define( 'WM_METABOX_SERIALIZED_NAME', '_' . WM_METABOX_FIELD_PREFIX . 'meta'  );
	if ( ! defined( 'WM_METABOX_LABEL_HTML' ) )      define( 'WM_METABOX_LABEL_HTML',      '<a><br><code><em><img><small><strong>' );





/**
 * Load functionality
 */

	require_once WMAMP_PLUGIN_DIR . 'class-wm-amplifier.php';

	require_once WMAMP_INCLUDES_DIR . 'functions.php';

	require_once WMAMP_INCLUDES_DIR . 'compatibility/compatibility.php';





/**
 * Functions
 */

	/**
	 * Plugin activation
	 *
	 * @since    1.0.0
	 * @version  1.6.0
	 */
	function webman_amplifier_activate() {

		// Processing

			do_action( 'wmhook_wmamp_plugin_activation' );

	} // /webman_amplifier_activate

	register_activation_hook( WMAMP_PLUGIN_FILE, 'webman_amplifier_activate' );



	/**
	 * Plugin deactivation
	 *
	 * @since    1.0.5
	 * @version  1.6.0
	 */
	function webman_amplifier_deactivate() {

		// Processing

			do_action( 'wmhook_wmamp_plugin_deactivation' );

	} // /webman_amplifier_deactivate

	register_deactivation_hook( WMAMP_PLUGIN_FILE, 'webman_amplifier_deactivate' );
