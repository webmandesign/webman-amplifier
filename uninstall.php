<?php
/**
 * WebMan Amplifier Uninstall
 *
 * @package  WebMan Amplifier
 *
 * @since    1.1
 * @version  1.1
 */



/**
 * Requirements check
 */

	if (
			! defined( 'WP_UNINSTALL_PLUGIN' )
			|| ! WP_UNINSTALL_PLUGIN
			|| dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( WMAMP_PLUGIN_FILE ) )
		) {
		status_header( 404 );
		exit;
	}



/**
 * Uninstall process
 */

	/**
	 * @todo  Put only required uninstall actions here!
	 */

?>