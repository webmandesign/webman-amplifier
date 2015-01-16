<?php
/**
 * WebMan Metabox Generator
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */

/**
 * USAGE:
 *
 * wma_add_meta_box( array(
 * 	// Where the meta box appear: normal (default), advanced, side.
 * 		'context' => 'normal',
 *
 * 	// Meta fields function callback (should return array of fields).
 * 	// The function callback is used for to use a WordPress globals
 * 	// available during the metabox rendering, such as $post.
 * 		'fields' => 'callback_function',
 *
 * 	// Meta box id, unique per meta box.
 * 		'id' => 'demo_meta_box',
 *
 * 	// Post types.
 * 		'pages' => array( 'post', 'page' ),
 *
 * 	// Order of meta box: high (default), low.
 * 		'priority' => 'high',
 *
 * 	// Tabbed meta box interface?
 * 		'tabs' => true,
 *
 * 	// Meta box title.
 * 		'title' => 'Custom Meta Box',
 *
 * 	// Wrap the meta form around visual editor? (This is always tabbed.)
 * 		'visual-wrapper' => false,
 *
 * 	// Function callback of form fields displayed immediately after
 * 	// visual editor on 1st tab.
 * 		'visual-wrapper-add' => 'callback_function',
 * 	) );
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * WebMan Metabox Generator Class
 *
 * @package	 WebMan Amplifier
 * @author   WebMan
 *
 * @since    1.0
 * @version  1.1
 */
if ( ! class_exists( 'WM_Metabox' ) && is_admin() ) {

	class WM_Metabox {

		/**
		 * VARIABLES
		 */

			/**
			 * @var  array Metabox setup attributes.
			 */
			private $meta_box;

			/**
			 * @var  string Metabox form fields function callback (returning array of fields).
			 */
			private $fields;

			/**
			 * @var  array Metabox form fields definition (rendering) files array.
			 */
			private $field_files;

			/**
			 * @var  string Meta fields ID prefix.
			 */
			private $prefix;

			/**
			 * @var  string Name of serialized meta stored in database (underscore at the beginning makes it hidden).
			 */
			private $serialized_name;





		/**
		 * INITIATION
		 */

			/**
			 * Constructor
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access  public
			 *
			 * @param  array $meta_box Definition of the metabox
			 */
			public function __construct( $meta_box ) {
				//If we are not in admin, exit
					if (
							! is_admin()
							|| ! isset( $meta_box['fields'] )
							|| ! is_callable( $meta_box['fields'] )
						) {
						return;
					}

				//Form field definition files ( 'field_file_name' => 'optional_file_path' )
					$field_files = array(
							'checkbox'    => '',
							'conditional' => '',
							'hidden'      => '',
							'html'        => '',
							'images'      => '',
							'radio'       => '',
							'repeater'    => '',
							'sections'    => '',
							'select'      => '',
							'slider'      => '',
							'texts'       => '',
						);

				//Set up class globals
					$this->prefix          = WM_METABOX_FIELD_PREFIX;
					$this->serialized_name = WM_METABOX_SERIALIZED_NAME;
					$this->meta_box        = (array) $meta_box;
					$this->fields          = (string) $meta_box['fields'];
					$this->field_files     = apply_filters( WM_METABOX_HOOK_PREFIX . 'field_files', $field_files );

				//Adding missing metabox options
					$this->meta_box = wp_parse_args( $this->meta_box, array(
							//DEFAULTS:
							'context'            => 'normal',
							'fields'             => '',
							'id'                 => '',
							'pages'              => array( 'post' ),
							'priority'           => 'high',
							'tabs'               => true,
							'title'              => '',
							'visual-wrapper'     => apply_filters( WM_METABOX_HOOK_PREFIX . 'visual_wrapper_toggle', false ),
							'visual-wrapper-add' => '',
						) );

				//Manage metabox title and ID
					$this->meta_box['title'] = trim( $this->meta_box['title'] );
					if ( ! $this->meta_box['title'] ) {
						return;
					}
					if ( ! trim( $this->meta_box['id'] ) ) {
						$this->meta_box['id'] = 'wm-' . sanitize_html_class( $this->meta_box['title'] );
					}
					if ( 'normal' != $this->meta_box['context'] ) {
						$this->meta_box['visual-wrapper'] = false;
					}

				//Required files
				//Field definitions (renderers)
					foreach ( $this->field_files as $file_name => $file_path ) {
						$file_path = (string) $file_path;

						if ( empty( $file_path ) || $file_name === $file_path ) {
							require_once( WMAMP_INCLUDES_DIR . 'metabox/fields/' . $file_name . '.php' );
						} elseif ( file_exists( $file_path ) ) {
							require_once( $file_path );
						}
					}

				//Add metaboxes
					if ( $this->meta_box['visual-wrapper'] ) {
						add_action( 'edit_form_after_title',  array( $this, 'metabox_start' ), 1000 );
						add_action( 'edit_form_after_editor', array( $this, 'metabox_end' ),   1    );
					} else {
						add_action( 'add_meta_boxes', array( $this, 'add' ) );
					}
					add_action( 'save_post', array( $this, 'save' ) );

				//Load assets (JS and CSS)
					add_action( 'admin_enqueue_scripts', array( $this, 'assets' ), 998 );
					//need to use admin_print_scripts due to Visual Composer plugin using it and to make sure our scripts are loaded after VC ones
					add_action( 'admin_print_scripts-post.php',     array( $this, 'assets_late' ), 998 );
					add_action( 'admin_print_scripts-post-new.php', array( $this, 'assets_late' ), 998 );
			} // /__construct



			/**
			 * Register (and include) styles and scripts
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access  public
			 */
			public function assets() {
				//Helper variables
					$icon_font_url   = apply_filters( WM_METABOX_HOOK_PREFIX . 'iconfont_url', get_option( 'wmamp-icon-font' ) );
					$icon_font_posts = apply_filters( WM_METABOX_HOOK_PREFIX . 'iconfont_admin_screen_addon', array( 'edit-wm_modules' ) );

				//Register
					//Styles
						wp_register_style( 'wm-metabox-styles',     WMAMP_ASSETS_URL . 'css/metabox.css',     false, WMAMP_VERSION, 'screen' );
						wp_register_style( 'wm-metabox-styles-rtl', WMAMP_ASSETS_URL . 'css/rtl-metabox.css', false, WMAMP_VERSION, 'screen' );
						if ( $icon_font_url ) {
							wp_register_style( 'wm-fonticons', $icon_font_url, false, WMAMP_VERSION, 'screen' );
						}

					//Scripts
						wp_register_script( 'wm-metabox-scripts', WMAMP_ASSETS_URL . 'js/metabox.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-ui-slider' ), WMAMP_VERSION, true );

				//Enqueue (only on admin edit pages)
				if ( $this->is_edit_page() ) {
					//Styles
						wp_enqueue_style( 'wp-color-picker' );
						wp_enqueue_style( 'wm-metabox-styles' );
						if ( is_rtl() ) {
							wp_enqueue_style( 'wm-metabox-styles-rtl' );
						}

					//Scripts
						wp_enqueue_script( 'media-upload' );
						wp_enqueue_media();
						wp_enqueue_script( 'jquery-ui-core' );
						wp_enqueue_script( 'jquery-ui-tabs' );
						wp_enqueue_script( 'jquery-ui-slider' );
						wp_enqueue_script( 'wp-color-picker' );

					//AJAX
						wp_localize_script( 'jquery', 'wmGalleryPreviewNonce', wp_create_nonce( 'wm-gallery-preview-refresh' ) );
				}

				//Load icon font CSS also on Content Module posts table
					if ( $this->is_edit_page( $icon_font_posts ) && $icon_font_url ) {
						wp_enqueue_style( 'wm-fonticons' );
					}
			} // /assets



			/**
			 * Enqueue JavaScripts
			 *
			 * Need this function cause of Visual Composer plugin
			 * compatibility as it prints scripts at the end of HTML
			 * and we need our script to be loaded after VC ones.
			 *
			 * @since   1.0
			 * @access  public
			 */
			public function assets_late() {
				//Enqueue (only on admin edit pages)
					if ( $this->is_edit_page() ) {
						//Scripts
							wp_enqueue_script( 'wm-metabox-scripts' );
					}
			} // /assets_late





		/**
		 * CREATE METABOX
		 */

			/**
			 * Add metabox on admin edit pages
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   string $post_type WordPress post type
			 */
			public function add( $post_type ) {
				if ( ! $post_type ) {
					global $post_type;
				}

				//Add the metabox only if the current post type is supported
					if ( in_array( $post_type, (array) $this->meta_box['pages'] ) ) {
						add_meta_box(
								'wmamp-metabox-' . $this->meta_box['id'],  //$id
								$this->meta_box['title'],                  //$title
								array( $this, 'show' ),                    //$callback
								$post_type,                                //$post_type
								$this->meta_box['context'],                //$context
								$this->meta_box['priority']                //$priority
								//$callback_args
							);
					}
			} // /add





		/**
		 * DISPLAYING FORM
		 */

			/**
			 * Display meta box
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   object $post WordPress post object
			 */
			public function show( $post ) {
				if ( ! $post ) {
					global $post;
				}

				//Execute fields function
					$meta_fields = (array) call_user_func( $this->fields );

				//Setting up helper variables
					$page_template = '';
					$tabbed        = ( $this->meta_box['tabs'] ) ? ( ' jquery-ui-tabs' ) : ( '' );

				//Set a page template if editing a page
					if ( 'page' == $post->post_type ) {
						$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
						if ( $post->ID == get_option( 'page_for_posts' ) )
							$page_template = 'blog-page';
					}

				//Output nonce field
					wp_nonce_field( $this->prefix . $post->post_type . '-metabox-nonce', $post->post_type . '-metabox-nonce' );

				//Action hooks
					do_action( WM_METABOX_HOOK_PREFIX . 'before' );
					do_action( WM_METABOX_HOOK_PREFIX . 'before_' . $this->meta_box['id'] );

				//Display meta box form HTML
					$output = "\r\n\r\n" . '<div class="wm-meta-wrap' . $tabbed . '">' . "\r\n";

					//Tabs
						if ( $tabbed ) {
							$output .= "\t" . '<ul class="tabs no-js">' . "\r\n";
							$i = 0;
							foreach ( $meta_fields as $tab ) {
								if ( isset( $tab['type'] ) && 'section-open' == $tab['type'] ) {
									$tab['id']    = WM_METABOX_FIELD_PREFIX . 'section-' . $tab['id'];
									$tab['title'] = ( isset( $tab['title'] ) ) ? ( trim( $tab['title'] ) ) : ( 'TAB' );
									$hidden       = ( 'page' == $post->post_type && isset( $tab['page'] ) ) ? ( self::page_template_conditional_class( $tab['page'], $page_template ) ) : ( '' );
									$output .= "\t\t" . '<li class="item-' . ++$i . $hidden . ' ' . $tab['id'] . '"><a href="#' . $tab['id'] . '">' . $tab['title'] . '</a></li>' . "\r\n";
								}
							}
							$output .= "\t" . '</ul>' . "\r\n\r\n";
						}

						echo $output;

					//Content
						foreach ( $meta_fields as $field ) {
							if ( isset( $field['type'] ) ) {
								//Display form fields using action hook (echo the function return)
								do_action( WM_METABOX_HOOK_PREFIX . 'render_' . $field['type'], $field, $page_template );
							}
						}

						$output = "\r\n\r\n\t" . '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'wm_domain' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'wm_domain' ) . '</a></div>' . "\r\n";
					$output .= '</div> <!-- /wm-meta-wrap -->' . "\r\n\r\n";

					echo $output;

				//Action hooks
					do_action( WM_METABOX_HOOK_PREFIX . 'after' );
					do_action( WM_METABOX_HOOK_PREFIX . 'after_' . $this->meta_box['id'] );
			} // /show



			/**
			 * Opening the meta box wrapping visual editor
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access  public
			 *
			 * @param  object $post WordPress post object
			 */
			public function metabox_start( $post ) {
				if ( ! $post ) {
					global $post;
				}

				//Add the metabox only if the current post type is supported
					global $post_type;
					if ( ! in_array( $post_type, (array) $this->meta_box['pages'] ) ) {
						return;
					}

				//Execute fields function
					$meta_fields = (array) call_user_func( $this->fields );

				//Setting up helper variables
					$page_template = '';

				//Set a page template if editing a page
					if ( 'page' == $post->post_type ) {
						$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
						if ( $post->ID == get_option( 'page_for_posts' ) )
							$page_template = 'blog-page';
					}

				//Output nonce field
					wp_nonce_field( $this->prefix . $post->post_type . '-metabox-nonce', $post->post_type . '-metabox-nonce' );

				//Action hooks
					do_action( WM_METABOX_HOOK_PREFIX . 'before' );
					do_action( WM_METABOX_HOOK_PREFIX . 'before_' . $this->meta_box['id'] );

				//Display meta box form HTML
					$output = "\r\n\r\n" . '<div class="wm-meta-wrap meta-special jquery-ui-tabs">' . "\r\n";

					//Tabs
						$output .= "\t" . '<ul class="tabs no-js">' . "\r\n";
						$output .= "\t\t" . '<li class="item-0 ' . WM_METABOX_FIELD_PREFIX . 'section-visual-editor"><a href="#' . WM_METABOX_FIELD_PREFIX . 'section-visual-editor">' . _x( 'Content', 'Metabox tab title for native WordPress visual editor tab.', 'wm_domain' ) . '</a></li>' . "\r\n";
						$i = 0;
						foreach ( $meta_fields as $tab ) {
							if ( isset( $tab['type'] ) && 'section-open' == $tab['type'] ) {
								$tab['id']    = WM_METABOX_FIELD_PREFIX . 'section-' . $tab['id'];
								$tab['title'] = ( isset( $tab['title'] ) ) ? ( trim( $tab['title'] ) ) : ( 'TAB' );
								$hidden       = ( 'page' == $post->post_type && isset( $tab['page'] ) ) ? ( self::page_template_conditional_class( $tab['page'], $page_template ) ) : ( '' );
								$output .= "\t\t" . '<li class="item-' . ++$i . $hidden . ' ' . $tab['id'] . '"><a href="#' . $tab['id'] . '">' . $tab['title'] . '</a></li>' . "\r\n";
							}
						}
						$output .= "\t" . '</ul>' . "\r\n\r\n";

						echo $output;

						$editor_tab_content = array(
							array(
								'type'     => 'section-open',
								'id'       => 'visual-editor',
								'exclude'  => apply_filters( WM_METABOX_HOOK_PREFIX . 'visual_editor_exclude', array() ),
								'no-table' => true
							)
						);

					//Content
						foreach ( $editor_tab_content as $field ) {
							if ( isset( $field['type'] ) ) {
								//Display form fields using action hook (echo the function return)
									do_action( WM_METABOX_HOOK_PREFIX . 'render_' . $field['type'], $field, $page_template );
							}
						}

				//DIV wrapper closes in another metabox_end() function
			} // /metabox_start



			/**
			 * Closing the meta box wrapping visual editor
			 *
			 * @since    1.0
			 * @version  1.1
			 *
			 * @access   public
			 *
			 * @param    object $post WordPress post object
			 */
			public function metabox_end( $post ) {
				if ( ! $post ) {
					global $post;
				}

				//Add the metabox only if the current post type is supported
					global $post_type;
					if ( ! in_array( $post_type, (array) $this->meta_box['pages'] ) ) {
						return;
					}

				//Execute additional fields function
					if ( $this->meta_box['visual-wrapper-add'] ) {
						$additional_table_start = array(
								array(
									'type'    => 'html',
									'content' => '<table class="form-table"><tbody>'
								)
							);
						$additional_table_end = array(
								array(
									'type'    => 'html',
									'content' => '</tbody></table>'
								)
							);
						$this->meta_box['visual-wrapper-add'] = array_merge(
								$additional_table_start,
								(array) call_user_func( $this->meta_box['visual-wrapper-add'] ),
								$additional_table_end
							);
					} else {
						$this->meta_box['visual-wrapper-add'] = array();
					}

				//Setting up helper variables
					$page_template = '';
				//Execute fields function
					$meta_fields = (array) call_user_func( $this->fields );

				//Set a page template if editing a page
					if ( 'page' == $post->post_type ) {
						$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
						if ( $post->ID == get_option( 'page_for_posts' ) )
							$page_template = 'blog-page';
					}

					$meta_fields = array_merge(
						$this->meta_box['visual-wrapper-add'],
						array(
							array(
								'type'      => 'html',
								'content'   => '<div class="box yellow if-page-builder-on">' . __( 'Use page builder to create the content.', 'wm_domain' ) . '</div>',
								'condition' => wma_is_active_page_builder()
							),
							array(
								'type'     => 'section-close', //closing visual editor wrapper
								'no-table' => true
							)
						),
						$meta_fields
					);

				//Content
						foreach ( $meta_fields as $field ) {
							if ( isset( $field['type'] ) ) {
								//Display form fields using action hook (echo the function return)
									do_action( WM_METABOX_HOOK_PREFIX . 'render_' . $field['type'], $field, $page_template );
							}
						}

						$output = "\r\n\r\n\t" . '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'wm_domain' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'wm_domain' ) . '</a></div>' . "\r\n";
					$output .= '</div> <!-- /wm-meta-wrap -->' . "\r\n\r\n";

					echo $output;

				//Action hooks
					do_action( WM_METABOX_HOOK_PREFIX . 'after' );
					do_action( WM_METABOX_HOOK_PREFIX . 'after_' . $this->meta_box['id'] );
			} // /metabox_end





		/**
		 * SAVING META FIELDS
		 */

			/**
			 * Save metabox data
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   integer $post_id WordPress post ID
			 */
			public function save( $post_id ) {
				global $post, $post_type;

				if ( ! $post_id ) {
					$post_id = $post->ID;
				}

				//Get current post type
					$postTypeObject = get_post_type_object( $post_type );

				//Execute fields function
					$meta_fields = (array) call_user_func( $this->fields );
					if ( $this->meta_box['visual-wrapper-add'] ) {
						$meta_fields = array_merge(
							(array) call_user_func( $this->meta_box['visual-wrapper-add'] ),
							$meta_fields
						);
					}

				//Check whether to fire meta saving procedure
					if (
							empty( $_POST )
							|| ! is_object( $post )
							//check post type
							|| ( ! in_array( $post_type, $this->meta_box['pages'] ) )
							//check revision
							|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )
							//check autosave
							|| ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
							//check nonce - security
							|| ( ! check_admin_referer( $this->prefix . $post_type . '-metabox-nonce', $post_type . '-metabox-nonce' ) )
							//check permission
							|| ( ! current_user_can( $postTypeObject->cap->edit_post, $post_id ) )
							//check if form fields are set
							|| ( ! is_array( $meta_fields ) || empty( $meta_fields ) )
						)
						return $post_id;

				//Validating and saving meta fields in serialized array
					//Prepare array to be saved in database
						$meta_options = array();

					//Get old serialized meta
						$old = get_post_meta( $post_id, $this->serialized_name, true );

					//If old meta, use it
						if ( is_array( $old ) && ! empty( $old ) ) {
							$meta_options = $old;
						}

					//Go through all the meta fields
						foreach ( $meta_fields as $field ) {
							if (
									isset( $field['id'] )
									&& isset( $field['type'] )
									&& ! in_array( $field['type'], array( 'section-open', 'sub-section-open' ) )
								) {
								//Set the correct form field ID
									$field['id'] = $this->prefix . $field['id'];

								//Get new meta field value and run it through saving (validation) process filter
									$new = ( isset( $_POST[$field['id']] ) ) ? ( $_POST[$field['id']] ) : ( null );
									if ( isset( $field['type'] ) ) {
										$new = apply_filters( WM_METABOX_HOOK_PREFIX . 'saving_' . $field['type'], $new, $field, $post_id );
									}

								//Append/overwrite the meta value in $meta_options helper variable
									if ( isset( $_POST[$field['id']] ) ) {
										//Basic validation (complex one should be applied via the above filter)
											if ( isset( $field['validate'] ) ) {
												switch ( $field['validate'] ) {
													case 'url':
														$new = esc_url( $new );
														break;
													case 'absint':
														$new = absint( $new );
														break;
													case 'int':
														$new = intval( $new );
														break;
													case 'email':
														$new = ( is_email( $new ) ) ? ( $new ) : ( '' );
														break;
													case 'color':
														$new = preg_replace( '/[^a-fA-F0-9\#]/', '', $new );
														break;
													default:
														break;
												}
											}
										$meta_options[$field['id']] = $new;
									} else {
										$meta_options[$field['id']] = null;
									}
							} //if field ID set
						} // /foreach field

					//Store serialized meta in database
						if ( $meta_options ) {
							update_post_meta( $post_id, $this->serialized_name, $meta_options );
						} else {
							delete_post_meta( $post_id, $this->serialized_name );
						}
			} // /save





		/**
		 * HELPER METHODS
		 */

			/**
			 * Check if current page is edit page
			 *
			 * @since   1.0
			 * @access  public
			 *
			 * @param   array $addon Additional $current_screen IDs to include
			 */
			public function is_edit_page( $addon = array() ) {
				global $current_screen;

				$pages = (array) $this->meta_box['pages'];

				if ( $addon ) {
					$pages = array_merge( $pages, $addon );
				}

				return in_array( $current_screen->id, $pages );
			} // /is_edit_page



			/**
			 * Checks if page template is selected and outputs CSS class
			 *
			 * @since   1.0
			 * @access  private
			 *
			 * @param   array  $conditions    Array of conditions to check.
			 * @param   string $page_template Current page template set.
			 *
			 * @return  string CSS class.
			 */
			private function page_template_conditional_class( $conditions = array(), $page_template = null ) {
				if (
						! $conditions
						|| ! is_array( $conditions )
						|| ! $page_template
					) {
					return;
				}

				//Helper variables
					$output = '';

				//Preparing output
					if (
							isset( $conditions['templates'] )
							&& is_array( $conditions['templates'] )
							&& ! empty( $conditions['templates'] )
						) {
						//Set default operand
							if ( ! isset( $conditions['operand'] ) ) {
								$conditions['operand'] = 'IS';
							}
						//Check if page template is in the array
							$template_check = in_array( $page_template, $conditions['templates'] );
						//Depending on operand, set the output
							if ( 'IS_NOT' !== $conditions['operand'] ) {
								//Only if page template is in the array
								$output .= ( $template_check ) ? ( '' ) : ( ' hide' );
							} else {
								//Only if the page template is NOT in the array
								$output .= ( $template_check ) ? ( ' hide' ) : ( '' );
							}
					}

				//Output
					return apply_filters( WM_METABOX_HOOK_PREFIX . 'page_template_conditional_class' . '_output', $output );
			} // /page_template_conditional_class

	} // /WM_Metabox





	/**
	 * INITIATOR FUNCTION
	 */

		/**
		 * WM_Metabox class initiator
		 *
		 * @since   1.0
		 *
		 * @param   array $metabox Array of metabox parameters.
		 *
		 * @return  WM Metabox instance
		 */
		function wma_add_meta_box( $metabox = array() ) {
			new WM_Metabox( $metabox );
		} // /wma_add_meta_box

} // /class WM_Metabox check

?>