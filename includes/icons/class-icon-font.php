<?php
/**
 * WebMan Font Icons Class
 *
 * @package     WebMan Amplifier
 * @subpackage  Font Icons
 *
 * @since    1.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WM_Icons' ) ) {
	class WM_Icons {

		/**
		 * @var  array Array of paths and URLs
		 */
		private $paths = array();

		/**
		 * @var  array Array holding the icon CSS class and characters used
		 */
		private $font_config = array();

		/**
		 * @var  string The file with the icon font setup
		 */
		private $font_glyphs_file = '';

		/**
		 * @var  string Icon font name
		 */
		private $font_name = '';

		/**
		 * @var  string Capability to upload font file
		 */
		private $capability = '';

		/**
		 * @var  object
		 */
		protected static $instance;

		/**
		 * Constructor
		 *
		 * @since   1.0
		 * @access  public
		 */
		public function __construct() {

			// Processing

				$this->setup_globals();
				$this->setup_actions();
				$this->setup_icons();

		} // /__construct

		/**
		 * Return an instance of the class
		 *
		 * @since   1.0
		 * @access  public
		 *
		 * @return  object A single instance of this class
		 */
		public static function instance() {

			// Processing

				if ( ! isset( self::$instance ) ) {
					self::$instance = new WM_Icons;
				}


			// Output

				return self::$instance;

		} // /instance

		/**
		 * Global variables setup
		 *
		 * @since    1.0
		 * @version  1.1
		 *
		 * @access  private
		 */
		private function setup_globals() {

			// Processing

				// Icon font name
				$this->font_name = 'fontello';

				// Paths and URLs
				$this->paths            = (array) wp_upload_dir();
				$this->paths['fonts']   = 'wmamp_fonts';
				$this->paths['temp']    = trailingslashit( $this->paths['fonts'] ) . 'temp';
				$this->paths['fontdir'] = trailingslashit( $this->paths['basedir'] ) . $this->paths['fonts'] . '/' . $this->font_name;
				$this->paths['tempdir'] = trailingslashit( $this->paths['basedir'] ) . $this->paths['temp'];
				$this->paths['fonturl'] = trailingslashit( $this->paths['baseurl'] ) . $this->paths['fonts'] . '/' . $this->font_name;
				$this->paths['tempurl'] = trailingslashit( $this->paths['baseurl'] ) . trailingslashit( $this->paths['temp'] );
				$this->paths            = (array) apply_filters( 'wmhook_icons_paths', $this->paths );

				// Capability to upload font file
				$this->capability = (string) apply_filters( 'wmhook_icons_capability', 'switch_themes' );

		} // /setup_globals

		/**
		 * Setup default icons
		 *
		 * @since    1.0
		 * @version  1.6.0
		 * @access   private
		 */
		private function setup_icons() {

			// Processing

				// Get recent icons array from database
				$icons = get_option( 'wmamp-icons' );

				// If no icons stored, reset the default icons
				if ( empty( $icons ) ) {

					// Include the default icons config file which contains $icons array definition

						$default_fonticons_config_file = (string) apply_filters( 'wmhook_icons_default_iconfont_config_path', WMAMP_ASSETS_DIR . 'font/config.php' );

						$icons = include_once $default_fonticons_config_file;

						// Backwards compatibility when `$icons` is defined in the file.
						if ( ! is_array( $icons ) ) {
							include_once $default_fonticons_config_file;
						}

					// Assign the $icons array to $font_config variable
					$this->font_config = (array) apply_filters( 'wmhook_icons_default_iconfont_config_array', $icons );

					// Process the $font_config variable
					$this->write_config();
				}

		} // /setup_icons

		/**
		 * Setup actions
		 *
		 * @since    1.0
		 * @version  1.6.0
		 * @access   private
		 */
		private function setup_actions() {

			// Processing

				add_action( 'init', array( $this, 'assets_global' ), 1 );

				// Admin panel assets
				add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

				// Menu registration
				add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		} // /setup_actions

		/**
		 * Register global scripts and styles.
		 *
		 * @since   1.6.0
		 *
		 * @access  public
		 */
		public function assets_global() {

			// Variables

				$icon_font_url = WM_Amplifier::fix_ssl_urls(
					esc_url_raw(
						(string) apply_filters( 'wmhook_icons_iconfont_url', get_option( 'wmamp-icon-font' ) )
					)
				);


			// Processing

				if ( $icon_font_url ) {

					$filetime = ( file_exists( get_option( 'wmamp-icon-font-path' ) ) ) ? ( filemtime( get_option( 'wmamp-icon-font-path' ) ) ) : ( '000' );

					wp_register_style(
						'wm-fonticons',
						$icon_font_url,
						false,
						WMAMP_VERSION . '.' . $filetime,
						'screen'
					);
				}

		} // /assets_global

		/**
		 * Scripts and styles
		 *
		 * @since    1.0
		 * @version  1.6.0
		 *
		 * @access  public
		 */
		public function assets() {

			// Variables

				global $current_screen;


			// Processing

				// Register

					// Styles

						wp_register_style(
							'wm-admin-icons',
							WMAMP_ASSETS_URL . 'css/admin-icons.css',
							false,
							WMAMP_VERSION,
							'screen'
						);

						wp_register_style(
							'wm-metabox-styles',
							WMAMP_ASSETS_URL . 'css/metabox.css',
							false,
							WMAMP_VERSION,
							'screen'
						);

					// Scripts

						wp_register_script(
							'wm-metabox-scripts',
							WMAMP_ASSETS_URL . 'js/metabox.js',
							array( 'jquery', 'jquery-ui-tabs', 'jquery-ui-slider', 'wp-dom-ready' ),
							WMAMP_VERSION,
							true
						);

					// Allow hooking for deregistering
					do_action( 'wmhook_icons_assets_registered' );

				// Enqueue (only on admin page)
				if ( 'appearance_page_icon-font' == $current_screen->id ) {

					// Styles

						wp_enqueue_style( 'wm-fonticons' );
						wp_enqueue_style( 'wm-admin-icons' );
						wp_enqueue_style( 'wm-metabox-styles' );

						wp_style_add_data(
							'wm-metabox-styles',
							'rtl',
							'replace'
						);

					// Scripts

						wp_enqueue_script( 'media-upload' );
						wp_enqueue_media();
						wp_enqueue_script( 'wm-metabox-scripts' );

						// Text input focus select.
						wp_add_inline_script(
							'wm-metabox-scripts',
							'( function( jQuery ) { '
							. 'jQuery( "#wmamp-icons-classes-list" )'
								. '.on( "focus", "[readonly]", function() { '
									. 'jQuery( this ).select();'
								. ' } );'
							. ' } )( jQuery );'
						);
				}

				// Allow hooking for dequeuing
				do_action( 'wmhook_icons_assets_enqueued' );

		} // /assets

		/**
		 * Add admin menu element
		 *
		 * @since    1.0
		 * @version  1.6.0
		 *
		 * @access  public
		 */
		public function admin_menu() {

			// Processing

				// Saving fields from theme options form
				if (
					isset( $_GET['page'] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					&& 'icon-font' == $_GET['page'] // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				) {

					// Check if the user is allowed to edit options
					if ( ! current_user_can( $this->capability ) ) {
						wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'webman-amplifier' ) );
					} else {
						$this->add_zipped_font();
					}
				}

				// Adding admin menu item under "Appearance" menu
				add_theme_page(
					esc_html_x( 'Icon Font', 'Admin page title.', 'webman-amplifier' ), // page_title
					esc_html_x( 'Icon Font', 'Admin menu title.', 'webman-amplifier' ), // menu_title
					$this->capability,                                                  // capability
					'icon-font',                                                        // menu_slug
					array( $this, 'admin_form' )                                        // form render function callback
				);

		} // /admin_menu

		/**
		 * Render admin form to upload font ZIP file
		 *
		 * @since    1.0
		 * @version  1.6.0
		 *
		 * @access   public
		 */
		public function admin_form() {

			// Variables

				$fonticons = get_option( 'wmamp-icons' );

				if ( isset( $fonticons['icons_select'] ) ) {

					$fonticons = wma_ksort( $fonticons['icons_select'] );

					$output  = '<div class="wm-meta-wrap wmamp-icons-classes-list-container">';
					$output .= '<div class="box yellow">';
					$output .= '<h2>' . esc_html__( 'List of the recently used icons with their CSS classes:', 'webman-amplifier' ) . '</h2>';
					$output .= '<ol class="wmamp-icons-classes-list" id="wmamp-icons-classes-list">';

					foreach ( $fonticons as $icon => $name ) {
						$output .= '<li>';
						$output .= '<span class="' . esc_attr( $icon ) . '" aria-hidden="true"></span>';
						$output .= '<label><span>' . esc_html__( 'CSS class:', 'webman-amplifier' ) . '</span><input type="text" value="' . esc_attr( $icon ) . '" readonly="readonly" /></label>';
						$output .= '<label><span>' . esc_html__( 'Instant HTML:', 'webman-amplifier' ) . '</span><input type="text" value="' . esc_attr( '<span class="' . esc_attr( $icon ) . '" aria-hidden="true"></span>' ) . '" readonly="readonly" /></label>';
						$output .= '</li>';
					}

					$output .= '</ol>';
					$output .= '</div>';
					$output .= '</div>';

					$fonticons = $output;
				} else {
					$fonticons = '';
				}

				// Form fields setup

					$fields = array( array(
						'id'          => 'wmamp-font-zip',
						'label'       => esc_html__( 'Fontello ZIP package file', 'webman-amplifier' ),
						'button'      => esc_html__( 'Set the file', 'webman-amplifier' ),
						'placeholder' => esc_html__( 'Fontello ZIP package file URL', 'webman-amplifier' ),
						'description' =>
							/* translators: %s: link to Fontello.com. */
							sprintf( esc_html__( 'Upload a new icon font ZIP package generated with %s.', 'webman-amplifier' ), '<a href="https://fontello.com/">Fontello.com</a>' )
							. '<br>'
							. esc_html__( 'Use the default button on right to empty the input field and set the default icon font file.', 'webman-amplifier' )
							. '<br>'
							. '<strong>'
							. esc_html__( 'IMPORTANT: Please do not use custom font name when creating your Fontello.com selection. Leave the field blank or use "fontello" as font name. Otherwise the font icons will not be generated.', 'webman-amplifier' )
							. '</strong>',
						'default'     => '',
					) );

				// Form fields values setup

					$icon_font = get_option( 'wmamp-icon-font' );
					$zip_file  = get_option( $fields[0]['id'] );

					if (
						! is_array( $zip_file )
						|| ! isset( $zip_file['url'] )
						|| ! trim( $zip_file['url'] )
						|| ! isset( $zip_file['id'] )
						|| ! trim( $zip_file['id'] )
						|| false === stripos( $zip_file['url'], '.zip' )
					) {

						$zip_file = array(
							'url' => '',
							'id'  => '',
						);
					}

					$options = array(
						$fields[0]['id']  => $zip_file,
						'wmamp-icon-font' => ( trim( $icon_font ) ) ? ( esc_url( $icon_font ) ) : ( '' ),
					);


			// Processing

				$output = '<div class="wrap wm-admin-wrap">';

				// Title
				$output .= '<h1>' . esc_html__( 'Icon Font Setup', 'webman-amplifier' ) . '</h1>';

				// Status messages

					// phpcs:ignore WordPress.Security.NonceVerification.Recommended
					$message = ( isset( $_GET['message'] ) ) ? ( absint( $_GET['message'] ) ) : ( 0 );

					if ( is_multisite() && false === stripos( get_site_option( 'upload_filetypes' ), 'zip' ) ) {

						$message =
							'<strong>'
							. esc_html__( 'You are currently on a WordPress multisite installation and ZIP file upload is disabled.', 'webman-amplifier' )
							. '</strong>'
							. '<br>'
							. esc_html__( 'Go to your Network settings page and add the "zip" file extension to the list of allowed "Upload file types".', 'webman-amplifier' )
							. '<br>'
							. '<a href="' . network_admin_url( 'settings.php' ) . '">'
							. esc_html__( 'Network settings →', 'webman-amplifier' )
							. '</a>';

					} elseif ( 1 === $message ) {

						$message = esc_html__( 'The ZIP file was processed successfully and new icon font was set up.', 'webman-amplifier' );

					} elseif ( 2 === $message ) {

						$message =
							'<strong>'
							. esc_html__( 'Error during processing of your ZIP file.', 'webman-amplifier' )
							. '</strong>';

					} elseif ( 3 === $message ) {

						$message =
							'<strong>'
							. esc_html__( "Using this feature is reserved for administrators. You don't have the necessary permissions.", 'webman-amplifier' )
							. '</strong>';

					} elseif ( 4 === $message ) {

						$message = esc_html__( 'Default icon font file was restored.', 'webman-amplifier' );

					} else {
						$message = '';
					}

					// Display message box if any message sent
					if ( $message ) {
						$output .= '<div id="message" class="updated"><p>' . $message . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see below
					}

				// Render form

					$output .= '<form class="wm-meta-wrap" method="post" action="' . esc_url( admin_url( 'themes.php?page=icon-font' ) ) . '">';
						$output .= '<table class="form-table">';

						// Caption

							$output .= '<caption>';
								$output .= esc_html__( 'Icon Font File Setup', 'webman-amplifier' );
							$output .= '</caption>';

						// Save button

							$output .= '<tfoot>';
								$output .= '<tr class="padding-20"><td colspan="2">';

									// Nonce
									$output .= wp_nonce_field( 'icon_font', '_wpnonce', true, false );

									// Button
									$output .= '<input type="submit" name="save-icon-font" id="save-icon-font" class="button button-primary button-large" value="' . esc_attr__( 'Save changes', 'webman-amplifier' ) . '" />';
									$output .= '<input type="hidden" name="action" value="wmamp-uploading-icon-font" />';

								$output .= '</td></tr>';
							$output .= '</tfoot>';

							$output .= '<tbody>';

							// Font CSS file link
							if ( $options['wmamp-icon-font'] ) {
								$output .= '<tr class="option padding-20"><td colspan="2">';

									$output .=
										'<div class="box blue">'
										. sprintf(
											/* translators: %s: linked file URL. */
											esc_html__( 'To display the icon font, please, use this CSS file: %s', 'webman-amplifier' ),
											'<br><code><a href="' . esc_url( $options['wmamp-icon-font'] ) . '">'
											. esc_url( $options['wmamp-icon-font'] )
											. '</a></code>'
										)
										. '</div>';

								$output .= '</td></tr>';
							}

							// Upload field

								$output .= '<tr class="option zip-wrap option-' . esc_attr( $fields[0]['id'] ) . '" data-option="' . esc_attr( $fields[0]['id'] ) . '"><th>';

									// Label
									$output .=
										'<label
											for="' . esc_attr( $fields[0]['id'] ) . '"
											data-id="' . esc_attr( $fields[0]['id'] ) . '"
											>'
										. esc_html( $fields[0]['label'] )
										. '</label>';

								$output .= '</th><td>';

									// Input field
									$output .=
										'<input
											type="text"
											name="' . esc_attr( $fields[0]['id'] ) . '[url]"
											id="' . esc_attr( $fields[0]['id'] ) . '"
											value="' . esc_attr( $options[$fields[0]['id']]['url'] ) . '"
											class="fieldtype-zip"
											placeholder="' . esc_attr( $fields[0]['placeholder'] ) . '"
											readonly="readonly"
											/>';
									$output .=
										'<input
											type="hidden"
											name="' . esc_attr( $fields[0]['id'] ) . '[id]"
											value="' . esc_attr( $options[$fields[0]['id']]['id'] ) . '"
											/>';

									// Upload button
									$output .=
										'<a
											href="#0"
											class="button button-set-zip"
											data-id="' . esc_attr( $fields[0]['id'] ) . '"
											>'
										. esc_html( $fields[0]['button'] )
										. '</a>';

									// Description
									$output .= '<p class="description">' . $fields[0]['description'] . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- see below

									// Default value button
									$output .=
										'<a
											data-option="' . esc_attr( $fields[0]['id'] ) . '[url]"
											class="button-default-value"
											title="' . esc_attr__( 'Use default', 'webman-amplifier' ) . '"
											>'
										. '<span>'
										. esc_html( $fields[0]['default'] )
										. '</span>'
										. '</a>';

								$output .= '</td></tr>';

							$output .= '</tbody>';

						$output .= '</table>';
					$output .= '</form>';

					// Available icon classes
					$output .= $fonticons;

				$output .= '</div>';


			// Output

				echo wp_kses( (string) apply_filters( 'wmhook_icons_admin_form_output', $output ), WMA_KSES::$prefix . 'form' );

		} // /admin_form

		/**
		 * Adding ZIPped font file
		 *
		 * @since    1.0
		 * @version  1.6.0
		 * @access   private
		 */
		private function add_zipped_font() {

			// Processing

				if (
					isset( $_POST['action'] )
					&& 'wmamp-uploading-icon-font' === $_POST['action']
				) {

					// Check referer
					check_admin_referer( 'icon_font', '_wpnonce' );

					// Check capability
					if ( ! current_user_can( $this->capability ) ) {
						wp_safe_redirect( admin_url( 'themes.php?page=icon-font&message=3' ) );
						die();
					}

					// Get the ZIP file path

						$attachment = ( isset( $_POST['wmamp-font-zip'] ) ) ? ( $_POST['wmamp-font-zip'] ) : ( '' ); // phpcs:ignore
						$attachment = (array) apply_filters( 'wmhook_icons_uploaded_icon_font_zip_url', $attachment );

						if (
							! is_array( $attachment )
							|| empty( $attachment['url'] )
							|| empty( $attachment['id'] )
							|| false === stripos( $attachment['url'], '.zip' )
						) {

							delete_option( 'wmamp-font-zip' );
							delete_option( 'wmamp-icon-font' );
							delete_option( 'wmamp-icons' );

							$this->setup_icons();

							if ( ! trim( $attachment['url'] ) ) {
								wp_safe_redirect( admin_url( 'themes.php?page=icon-font&message=4' ) );
							} else {
								wp_safe_redirect( admin_url( 'themes.php?page=icon-font&message=2' ) );
							}

							die();
						}

						$path     = realpath( get_attached_file( $attachment['id'] ) );
						$unzipped = $this->zip_flatten( $path, array(
							'\.eot',
							'\.svg',
							'\.ttf',
							'\.woff',
							'\.woff2',
							'\.json',
							'fontello.css'
						) );

					// If able to unzip and save the files to our temp folder, create a config file
					if ( $unzipped ) {
						$this->create_config();
					}

					// If no name for the font don't add it and delete the temp folder
					if ( empty( $this->font_name ) ) {

						WMA_Filesystem::dir( $this->paths['tempdir'], 'delete' );

						wp_safe_redirect( admin_url( 'themes.php?page=icon-font&message=2' ) );
						die();
					}

					// Save the ZIP file info to database
					update_option( 'wmamp-font-zip', $attachment );

					// Return the successful message
					wp_safe_redirect( admin_url( 'themes.php?page=icon-font&message=1' ) );
					die();
				}

		} // /add_zipped_font

		/**
		 * Extracts the ZIP file to a flat folder and removes obsolete files
		 * And replaces the font file URLs in "fontello.css" file
		 *
		 * @see   _unzip_file_ziparchive() for inspiration
		 * @link  https://developer.wordpress.org/reference/functions/_unzip_file_ziparchive/
		 *
		 * @since    1.0
		 * @version  1.6.0
		 *
		 * @access  private
		 * @uses    PHP ZipArchive class
		 *
		 * @param   string $file   ZIP file name
		 * @param   array  $filter Array of file extensions to keep
		 *
		 * @return  boolean True if ZIP processed successfully
		 */
		private function zip_flatten( string $file = '', array $filter = array() ): bool {

			// Processing

				// Create the temporary folder

					$tempdir = WMA_Filesystem::dir(
						$this->paths['tempdir'],
						'create'
					);

					if ( ! $tempdir ) {
						exit( "Wasn't able to create a temporary folder" );
					}

				// Use the PHP ZipArchive class
				$zip = new ZipArchive;
				if ( $zip->open( $file, ZIPARCHIVE::CHECKCONS ) ) {

					// Parse the ZIP archive
					for ( $i = 0; $i < $zip->numFiles; $i++ ) {

						$delete = false;

						// // Get ZIP file info.
						// $info = $zip->statIndex( $i );

						// Get ZIP file entry (file, folder, subfolder)
						$entry = $zip->getNameIndex( $i );

						// Filter allowed files
						if ( ! empty( $filter ) ) {

							$delete  = true;
							$matches = array();

							foreach ( $filter as $regex ) {

								preg_match( '!' . $regex . '!', $entry, $matches );

								if ( ! empty( $matches ) ) {
									$delete = false;
									break;
								}
							}
						}

						// Skip directories and obsolete files
						if (
							'/' == substr( $entry, -1 )
							|| $delete
						) {
							continue;
						}

						$new_content = $zip->getFromIndex( $i );

						if ( empty( $new_content ) ) {
							exit( 'Unable to extract the file or the file is empty' );
						}

						// Process "fontello.css" file content
						if ( 'fontello.css' === basename( $entry ) ) {

							// Replace font paths
							$new_content = str_replace(
								array(
									'../font/',
									'margin-right: .2em;',
									'margin-left: .2em;',
									'speak: never;',
								),
								array(
									'',
									'/* margin-right: .2em; */',
									'/* margin-left: .2em; */',
									'/* speak: never; */'
								),
								$new_content
							);

							// Replace query string from URLs with "?VERSION".
							$new_content = preg_replace( '/\?[\d]+/', '?VERSION', $new_content );

							// Minify the file content

								// Remove CSS comments
								$new_content = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $new_content );

								// Remove tabs, spaces, line breaks, etc.
								$new_content = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $new_content );
								$new_content = str_replace( array( '     ', '    ', '   ', '  ' ), ' ', $new_content );
								$new_content = str_replace( array( ' { ', ': ', '; }' ), array( '{', ':', '}' ), $new_content );

							// Now we are ready to remove the EOT font format URLs
							$new_content = str_replace(
								array(
									" src:url('fontello.eot?VERSION');",
									"url('fontello.eot?VERSION#iefix') format('embedded-opentype'), ",
								),
								'',
								$new_content
							);

							// Replace "?VERSION" with actual file version.
							$version     = ( (bool) apply_filters( 'wmhook_icons_css_enable_font_src_version', true ) ) ? ( '?' . time() ) : ( '' );
							$new_content = str_replace( '?VERSION', $version, $new_content );
						}

						// Copy files from ZIP to a new file in temporary directory.

							$target_file = $this->paths['tempdir'] . '/' . basename( $entry );

							WMA_Filesystem::file( $target_file, 'create' );
							WMA_Filesystem::file( $target_file, 'write', $new_content );
					}

					// Close the ZIP file processing
					$zip->close();

				} else {
					exit( "Wasn't able to process the ZIP archive" );
				}


			// Output

				return true;

		} // /zip_flatten

		/**
		 * Creates icons configuration from JSON file
		 *
		 * @since    1.0
		 * @version  1.6.0
		 * @access   private
		 */
		private function create_config() {

			// Processing

				// Find the JSON config file

					$files = scandir( $this->paths['tempdir'] );

					foreach ( $files as $file ) {
						if ( false !== strpos( strtolower( $file ), '.json' ) && '.' != $file[0] ) {
							$this->font_glyphs_file = $file;
						}
					}

				// Check if JSON exists
				if ( empty( $this->font_glyphs_file ) ) {
					WMA_Filesystem::dir( $this->paths['tempdir'], 'delete' );
					exit( 'Found no JSON file with font information in your folder. Was not able to create the necessary config file.' );
				}

				// Open the JSON file
				$json = WMA_Filesystem::file(
					trailingslashit( $this->paths['tempdir'] ) . $this->font_glyphs_file,
					'read'
				);

				// Process the JSON file content
				if (
					! is_wp_error( $json )
					&& ! empty( $json )
				) {

					$this->font_config = array();

					$this->font_config['wmamp-font-file-url']  = trailingslashit( $this->paths['fonturl'] ) . $this->font_name . '.css';
					$this->font_config['wmamp-font-file-path'] = trailingslashit( $this->paths['fontdir'] ) . $this->font_name . '.css';

					$json = json_decode( $json, true );

					if ( ! empty( $json['glyphs'] ) ) {
						foreach ( (array) $json['glyphs'] as $icon ) {

							if (
								isset( $icon['css'] )
								&& isset( $icon['code'] )
							) {

								$this->font_config[ $icon['css'] ]['class'] = $icon['css'];
								$this->font_config[ $icon['css'] ]['char']  = dechex( $icon['code'] );
							}
						}
					}

					if ( ! empty( $this->font_config ) ) {
						$this->rename_folder();
						$this->write_config();

						return true;
					}
				}


			// Output

				return false;

		} // /create_config

		/**
		 * Writes icons configurations in database
		 *
		 * @since    1.0
		 * @version  1.6.0
		 * @access   private
		 */
		private function write_config() {

			// Variables

				$icons = array();


			// Processing

				// Prepare icons array to store in database
				if (
					is_array( $this->font_config )
					&& $this->font_config
				) {

					$icons['css-prefix'] = (string) apply_filters( 'wmhook_icons_icon_css_prefix', 'icon-' );
					$icons['css-suffix'] = (string) apply_filters( 'wmhook_icons_icon_css_suffix', '' );

					foreach ( $this->font_config as $key => $icon ) {

						if (
							! empty( $icon )
							&& ! in_array( $key, array( 'wmamp-font-file-url', 'wmamp-font-file-path' ) )
						) {

							$icons['icons'][ $icon['class'] ] = '\\' . $icon['char'];

							$icons['icons_select'][ $icons['css-prefix'] . $icon['class'] . $icons['css-suffix'] ] = ucfirst(
								str_replace(
									array( '-', '_' ),
									' ',
									$icon['class']
								)
							);
						}
					}
				}

				// Prepare default icon font file info
				if ( isset( $this->font_config['wmamp-font-file-url'] ) ) {

					$fontcss      = $this->font_config['wmamp-font-file-url'];
					$fontcss_path = $this->font_config['wmamp-font-file-path'];

				} else {

					$fontcss = (string) apply_filters(
						'wmhook_icons_default_iconfont_css_url',
						WMAMP_ASSETS_URL . 'font/' . $this->font_name . '.css'
					);

					$fontcss_path = (string) apply_filters(
						'wmhook_icons_default_iconfont_css_path',
						WMAMP_ASSETS_DIR . 'font/' . $this->font_name . '.css'
					);
				}

				// Cache in database
				update_option( 'wmamp-icon-font-path', $fontcss_path );
				update_option( 'wmamp-icon-font', $fontcss );
				update_option( 'wmamp-icons', $icons );

		} // /write_config

		/**
		 * Make temporary folder the final one
		 *
		 * @since    1.0
		 * @version  1.6.0
		 * @access   private
		 */
		private function rename_folder() {

			// Processing

				if ( file_exists( $this->paths['fontdir'] ) ) {
					WMA_Filesystem::dir(
						$this->paths['fontdir'],
						'delete'
					);
				}


			// Output

				return WMA_Filesystem::dir(
					$this->paths['tempdir'],
					'rename',
					$this->paths['fontdir']
				);

		} // /rename_folder

	}
}

// Load Filesystem class.
require_once WMAMP_INCLUDES_DIR . 'class-filesystem.php';
