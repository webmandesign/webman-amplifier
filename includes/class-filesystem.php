<?php
/**
 * Filesystem class.
 *
 * @package    WebMan Amplifier
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- prefixed with 'WMA'
class WMA_Filesystem {

	/**
	 * File actions.
	 *
	 * @since  1.6.0
	 *
	 * @param  string $path
	 * @param  string $action
	 * @param  string $alt     Alternative content. Could be `$destination` or `$contents`, for example.
	 *
	 * @return  bool
	 */
	public static function file( string $path, string $action = '', string $alt = '' ) {

		// Processing

			switch ( $action ) {

				case 'read':
				case 'fread':
				case 'file_get_contents':
					return self::get_filesystem()->get_contents( $path );

				case 'create':
				case 'write':
				case 'fwrite':
					// $alt = $contents
					return self::get_filesystem()->put_contents( $path, $alt );

				case 'delete':
				case 'remove':
				case 'unlink':
					return wp_delete_file( $path );

				case 'rename':
				case 'move':
					// $alt = $destination
					return self::get_filesystem()->move( $path, $alt, true );

				default:
					return false;
			}

	} // /file

	/**
	 * Directory actions.
	 *
	 * @since  1.6.0
	 *
	 * @param  string $path
	 * @param  string $action
	 * @param  string $alt     Alternative content. Could be `$destination` or `$contents`, for example.
	 *
	 * @return  bool
	 */
	public static function dir( string $path, string $action = '', string $alt = '' ) {

		// Processing

			switch ( $action ) {

				case 'create':
				case 'make':
				case 'mkdir':
					return wp_mkdir_p( $path );

				case 'delete':
				case 'remove':
				case 'rmdir':
				case 'unlink':
					return self::get_filesystem()->delete( $path, true );

				case 'rename':
				case 'move':
					// $alt = $destination
					return self::get_filesystem()->move( $path, $alt, true );

				default:
					return false;
			}

	} // /dir

	/**
	 * Form tags.
	 *
	 * @since  1.6.0
	 *
	 * @return  WP_Filesystem_Base
	 */
	public static function get_filesystem() {

		// Variables

			global $wp_filesystem;


		// Processing

			// If the filesystem has not been instantiated yet, do it here.
			if ( ! $wp_filesystem ) {

				if ( ! function_exists( 'WP_Filesystem' ) ) {
					require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
				}

				WP_Filesystem();
			}


		// Output

			return $wp_filesystem;

	} // /get_filesystem

}
