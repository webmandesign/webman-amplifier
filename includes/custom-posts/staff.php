<?php
/**
 * WebMan Custom Posts
 *
 * Registering "wm_staff" custom post.
 *
 * @package     WebMan Amplifier
 * @subpackage  Custom Posts
 *
 * @since    1.0
 * @version  1.5.6
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;





/**
 * ACTIONS AND FILTERS
 */

	/**
	 * Actions
	 */

		//Registering CP
			add_action( 'wmhook_wmamp_' . 'register_post_types', 'wma_staff_cp_register', 10 );
		//CP list table columns
			add_action( 'manage_wm_staff_posts_custom_column', 'wma_staff_cp_columns_render' );
		//Registering taxonomies
			add_action( 'wmhook_wmamp_' . 'register_post_types', 'wma_staff_cp_taxonomies', 10 );
		//Permanlinks settings
			add_action( 'admin_init', 'wma_staff_cp_permalinks' );

		/**
		 * The init action occurs after the theme's functions file has been included.
		 * So, if you're looking for terms directly in the functions file,
		 * you're doing so before they've actually been registered.
		 */



	/**
	 * Filters
	 */

		//CP list table columns
			add_filter( 'manage_edit-wm_staff_columns', 'wma_staff_cp_columns_register' );

		// Title text

			add_filter( 'enter_title_here', 'wma_staff_cp_title_text' );





/**
 * CREATING A CUSTOM POST
 */

	/**
	 * Custom post registration
	 *
	 * @since    1.0
	 * @version  1.5.6
	 */
	if ( ! function_exists( 'wma_staff_cp_register' ) ) {
		function wma_staff_cp_register() {

			// Helper variables

				$permalinks = get_option( 'wmamp-permalinks' );


			// Processing

				// Custom post registration arguments

					$args = apply_filters( 'wmhook_wmamp_' . 'cp_register_' . 'wm_staff', array(
						'query_var'           => 'staff',
						'capability_type'     => 'page',
						'public'              => true,
						'show_ui'             => true,
						'has_archive'         => ( isset( $permalinks['people'] ) && $permalinks['people'] ) ? ( $permalinks['people'] ) : ( 'people' ),
						'exclude_from_search' => false,
						'hierarchical'        => false,
						'rewrite'             => array(
								'slug' => ( isset( $permalinks['person'] ) && $permalinks['person'] ) ? ( $permalinks['person'] ) : ( 'person' ),
							),
						'menu_position'       => 42,
						'menu_icon'           => 'dashicons-businessman',
						'supports'            => array(
								'title',
								'editor',
								'thumbnail',
								'author',
							),
						'labels'              => array(
							'name'                     => _x( 'Staff', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'singular_name'            => _x( 'Person', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'add_new'                  => _x( 'Add New', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'add_new_item'             => _x( 'Add Person', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'new_item'                 => _x( 'Add New', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'edit_item'                => _x( 'Edit Person', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'view_item'                => _x( 'View Person', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'view_items'               => _x( 'View Staff', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'search_items'             => _x( 'Search Staff', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'not_found'                => _x( 'No person found', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'not_found_in_trash'       => _x( 'No person found', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'featured_image'           => _x( 'Person photo', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'set_featured_image'       => _x( 'Set person photo', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'remove_featured_image'    => _x( 'Remove person photo', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'use_featured_image'       => _x( 'Use as person photo', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'filter_items_list'        => _x( 'Filter staff list', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'items_list_navigation'    => _x( 'Staff list navigation', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'items_list'               => _x( 'Staff list', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'attributes'               => _x( 'Staff Attributes', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'item_published'           => _x( 'Staff published.', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'item_published_privately' => _x( 'Staff published privately.', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'item_reverted_to_draft'   => _x( 'Staff reverted to draft.', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'item_scheduled'           => _x( 'Staff scheduled.', 'Custom post labels: Staff.', 'webman-amplifier' ),
							'item_updated'             => _x( 'Staff updated.', 'Custom post labels: Staff.', 'webman-amplifier' ),
						),
						'show_in_rest' => true, // Required for Gutenberg editor.
					) );

				// Register custom post type

					register_post_type( 'wm_staff' , $args );

		}
	} // /wma_staff_cp_register



	/**
	 * Admin post title text
	 *
	 * @since  1.4
	 */
	if ( ! function_exists( 'wma_staff_cp_title_text' ) ) {
		function wma_staff_cp_title_text( $title ) {

			// Helper variables

				$screen = get_current_screen();


			// Processing

				if ( 'wm_staff' == $screen->post_type ) {
					$title = esc_html__( 'Enter person name here', 'webman-amplifier' );
				}


			// Output

				return $title;

		}
	} // /wma_staff_cp_title_text





/**
 * CUSTOM POST LIST TABLE IN ADMIN
 */

	/**
	 * Register table columns
	 *
	 * @since    1.0
	 * @version  1.4.1
	 */
	if ( ! function_exists( 'wma_staff_cp_columns_register' ) ) {
		function wma_staff_cp_columns_register( $columns ) {

			// Helper variables

				$prefix = 'wmamp-';
				$suffix = '-wm_staff';


			// Processing

				$columns[ $prefix . 'thumb' . $suffix ] = esc_html__( 'Photo', 'webman-amplifier' );


			// Output

				return apply_filters( 'wmhook_wmamp_' . 'wma_staff_cp_columns_register' . '_output', $columns );

		}
	} // /wma_staff_cp_columns_register



	/**
	 * Render table columns
	 *
	 * @since    1.0
	 * @version  1.4.1
	 */
	if ( ! function_exists( 'wma_staff_cp_columns_render' ) ) {
		function wma_staff_cp_columns_render( $column ) {

			// Helper variables

				global $post;

				$prefix = 'wmamp-';
				$suffix = '-wm_staff';


			// Processing

				switch ( $column ) {

					case $prefix . 'thumb' . $suffix:
						$size  = apply_filters( 'wmhook_wmamp_' . 'cp_admin_thumb_size', 'thumbnail' );
						$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, $size ) ) : ( '' );

						$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

						echo '<span class="wm-image-container' . $hasThumb . '">';

						if ( get_edit_post_link() ) {
							edit_post_link( $image );
						} else {
							echo '<a href="' . get_permalink() . '">' . $image . '</a>';
						}

						echo '</span>';
					break;

					default:
					break;

				} // /switch

		}
	} // /wma_staff_cp_columns_render





/**
 * TAXONOMIES
 */

	/**
	 * Register taxonomies
	 *
	 * @since    1.0
	 * @version  1.4.1
	 */
	if ( ! function_exists( 'wma_staff_cp_taxonomies' ) ) {
		function wma_staff_cp_taxonomies() {

			// Helper variables

				$permalinks = get_option( 'wmamp-permalinks' );


			// Processing

				// Staff departments

					$args = apply_filters( 'wmhook_wmamp_' . 'cp_taxonomy_' . 'staff_department', array(
						'hierarchical'      => true,
						'show_ui'           => true,
						'show_admin_column' => true,
						'query_var'         => 'staff-department',
						'rewrite'           => array(
								'slug' => ( isset( $permalinks['staff_department'] ) && $permalinks['staff_department'] ) ? ( $permalinks['staff_department'] ) : ( 'staff-department' )
							),
						'labels'            => array(
							'name'                  => _x( 'Departments', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'singular_name'         => _x( 'Department', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'search_items'          => _x( 'Search Departments', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'all_items'             => _x( 'All Departments', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'parent_item'           => _x( 'Parent Department', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'parent_item_colon'     => _x( 'Parent Department', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ) . ':',
							'edit_item'             => _x( 'Edit Department', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'view_item'             => _x( 'View Department', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'update_item'           => _x( 'Update Department', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'add_new_item'          => _x( 'Add New Department', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'new_item_name'         => _x( 'New Department Title', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'not_found'             => _x( 'No departments found', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'no_terms'              => _x( 'No departments', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'items_list_navigation' => _x( 'Departments list navigation', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
							'items_list'            => _x( 'Departments list', 'Custom taxonomy labels: Staff departments.', 'webman-amplifier' ),
						),
						'show_in_rest' => true, // Required for Gutenberg editor.
					) );

					register_taxonomy( 'staff_department', 'wm_staff', $args );

				// Staff positions

					$args = apply_filters( 'wmhook_wmamp_' . 'cp_taxonomy_' . 'staff_position', array(
						'hierarchical'      => false,
						'show_ui'           => true,
						'show_admin_column' => true,
						'query_var'         => 'staff-position',
						'rewrite'           => array(
								'slug' => ( isset( $permalinks['staff_position'] ) && $permalinks['staff_position'] ) ? ( $permalinks['staff_position'] ) : ( 'staff-position' )
							),
						'labels'            => array(
							'name'                       => _x( 'Positions', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'singular_name'              => _x( 'Position', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'search_items'               => _x( 'Search Positions', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'popular_items'              => _x( 'Popular Positions', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'all_items'                  => _x( 'All Positions', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'edit_item'                  => _x( 'Edit Position', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'view_item'                  => _x( 'View Position', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'update_item'                => _x( 'Update Position', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'add_new_item'               => _x( 'Add New Position', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'new_item_name'              => _x( 'New Position Title', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'separate_items_with_commas' => _x( 'Separate positions with commas', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'add_or_remove_items'        => _x( 'Add or remove positions', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'choose_from_most_used'      => _x( 'Choose from the most used positions', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'not_found'                  => _x( 'No positions found', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'no_terms'                   => _x( 'No positions', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'items_list_navigation'      => _x( 'Positions list navigation', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
							'items_list'                 => _x( 'Positions list', 'Custom taxonomy labels: Staff positions.', 'webman-amplifier' ),
						),
						'show_in_rest' => true, // Required for Gutenberg editor.
					) );

					register_taxonomy( 'staff_position', 'wm_staff', $args );

				// Staff specialty

					$args = apply_filters( 'wmhook_wmamp_' . 'cp_taxonomy_' . 'staff_specialty', array(
						'hierarchical'      => false,
						'show_ui'           => true,
						'show_admin_column' => true,
						'query_var'         => 'staff-specialty',
						'rewrite'           => array(
								'slug' => ( isset( $permalinks['staff_specialty'] ) && $permalinks['staff_specialty'] ) ? ( $permalinks['staff_specialty'] ) : ( 'staff-specialty' )
							),
						'labels'            => array(
							'name'                       => _x( 'Specialties', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'singular_name'              => _x( 'Specialty', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'search_items'               => _x( 'Search Specialties', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'popular_items'              => _x( 'Popular Specialties', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'all_items'                  => _x( 'All Specialties', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'edit_item'                  => _x( 'Edit Specialty', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'view_item'                  => _x( 'View Specialty', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'update_item'                => _x( 'Update Specialty', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'add_new_item'               => _x( 'Add New Specialty', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'new_item_name'              => _x( 'New Specialty Title', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'separate_items_with_commas' => _x( 'Separate specialties with commas', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'add_or_remove_items'        => _x( 'Add or remove specialties', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'choose_from_most_used'      => _x( 'Choose from the most used specialties', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'not_found'                  => _x( 'No specialties found', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'no_terms'                   => _x( 'No specialties', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'items_list_navigation'      => _x( 'Specialties list navigation', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
							'items_list'                 => _x( 'Specialties list', 'Custom taxonomy labels: Staff specialties.', 'webman-amplifier' ),
						),
						'show_in_rest' => true, // Required for Gutenberg editor.
					) );

					register_taxonomy( 'staff_specialty', 'wm_staff', $args );

		}
	} // /wma_staff_cp_taxonomies





/**
 * PERMALINKS SETTINGS
 */

	/**
	 * Create permalinks settings fields in WordPress admin
	 *
	 * @since    1.0
	 * @version  1.3.21
	 */
	if ( ! function_exists( 'wma_staff_cp_permalinks' ) ) {
		function wma_staff_cp_permalinks() {

			// Requirements check

				$obj = get_post_type_object( 'wm_staff' );

				if ( ! $obj->has_archive ) {
					return;
				}


			// Processing

				// Adding sections

					add_settings_section(
							'wmamp-' . 'wm_staff' . '-permalinks',
							__( 'Staff Custom Post Permalinks', 'webman-amplifier' ),
							'wma_staff_cp_permalinks_render_section',
							'permalink'
						);

				// Adding settings fields

					add_settings_field(
							'people',
							__( 'Staff archive permalink', 'webman-amplifier' ),
							'wma_permalinks_render_field',
							'permalink',
							'wmamp-' . 'wm_staff' . '-permalinks',
							array(
									'name'        => 'people',
									'placeholder' => apply_filters( 'wmhook_wmamp_' . 'cp_permalink_' . 'people', 'people' )
								)
						);

					add_settings_field(
							'person',
							__( 'Single person permalink', 'webman-amplifier' ),
							'wma_permalinks_render_field',
							'permalink',
							'wmamp-' . 'wm_staff' . '-permalinks',
							array(
									'name'        => 'person',
									'placeholder' => apply_filters( 'wmhook_wmamp_' . 'cp_permalink_' . 'person', 'person' )
								)
						);

					add_settings_field(
							'staff_department',
							__( 'Staff department base', 'webman-amplifier' ),
							'wma_permalinks_render_field',
							'permalink',
							'wmamp-' . 'wm_staff' . '-permalinks',
							array(
									'name'        => 'staff_department',
									'placeholder' => apply_filters( 'wmhook_wmamp_' . 'cp_permalink_' . 'staff_department', 'staff-department' )
								)
						);

					add_settings_field(
							'staff_position',
							__( 'Staff positions base', 'webman-amplifier' ),
							'wma_permalinks_render_field',
							'permalink',
							'wmamp-' . 'wm_staff' . '-permalinks',
							array(
									'name'        => 'staff_position',
									'placeholder' => apply_filters( 'wmhook_wmamp_' . 'cp_permalink_' . 'staff_position', 'staff-position' )
								)
						);

					add_settings_field(
							'staff_specialty',
							__( 'Staff specialty base', 'webman-amplifier' ),
							'wma_permalinks_render_field',
							'permalink',
							'wmamp-' . 'wm_staff' . '-permalinks',
							array(
									'name'        => 'staff_specialty',
									'placeholder' => apply_filters( 'wmhook_wmamp_' . 'cp_permalink_' . 'staff_specialty', 'staff-specialty' )
								)
						);

		}
	} // /wma_staff_cp_permalinks



	/**
	 * Create permalinks settings section WordPress admin
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_staff_cp_permalinks_render_section' ) ) {
		function wma_staff_cp_permalinks_render_section() {
			//Settings section description
				echo apply_filters( 'wmhook_wmamp_' . 'wma_staff_cp_permalinks_render_section' . '_output', '<p>' . __( 'You can change the Staff custom post type permalinks here.', 'webman-amplifier' ) . '</p>' );
		}
	} // /wma_staff_cp_permalinks_render_section





/**
 * META BOXES
 */

	/**
	 * Register metabox fields
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_staff_cp_metafields' ) ) {
		function wma_staff_cp_metafields() {
			//Helper variables
				$fields = array();
				$fonticons = get_option( 'wmamp-icons' );

			//Prepare font icons
				if ( isset( $fonticons['icons_select'] ) ) {
					$fonticons = array_merge( array( '' => '' ), $fonticons['icons_select'] );
				} else {
					$fonticons = array();
				}
				asort( $fonticons );

				//"Info" tab
					$fields[1000] = array(
							'type'  => 'section-open',
							'id'    => 'staff-info-section',
							'title' => _x( 'Info', 'Metabox section title.', 'webman-amplifier' ),
						);

						//Staff custom link input field
							$fields[1020] = array(
									'type'        => 'text',
									'id'          => 'link',
									'label'       => __( 'Custom link URL', 'webman-amplifier' ),
									'description' => __( 'No link will be displayed / applied when left blank', 'webman-amplifier' ),
									'validate'    => 'url',
								);

						//Staff custom link to a page selector
							$fields[1040] = array(
									'type'        => 'select',
									'id'          => 'link-page',
									'label'       => __( '...or link to a page', 'webman-amplifier' ),
									'description' => __( 'No link will be displayed / applied when left blank', 'webman-amplifier' ),
									'options'     => wma_pages_array(),
								);

						//Staff custom link actions
							$fields[1060] = array(
									'type'        => 'select',
									'id'          => 'link-action',
									'label'       => __( 'Custom link action', 'webman-amplifier' ),
									'description' => __( 'Choose how to display / apply the link set above', 'webman-amplifier' ),
									'options'     => array(
											'_blank' => __( 'Open in new tab / window', 'webman-amplifier' ),
											'_self'  => __( 'Open in same window', 'webman-amplifier' ),
										),
									'default'    => '_self',
								);

					$fields[1980] = array(
							'type' => 'section-close',
						);
				// /"Info" tab

				//"Contacts" tab
					$fields[3000] = array(
							'type'  => 'section-open',
							'id'    => 'staff-contacts-section',
							'title' => _x( 'Contacts', 'Metabox section title.', 'webman-amplifier' ),
						);

						//Staff custom contacts
						$contact_fields = array();
						if ( ! empty( $fonticons ) ) {
							$contact_fields[] = array(
									'type'    => 'select',
									'id'      => 'icon',
									'label'   => __( 'Icon', 'webman-amplifier' ),
									'options' => $fonticons,
								);
						}
						$contact_fields[] = array(
								'type'  => 'text',
								'id'    => 'title',
								'label' => __( 'Title', 'webman-amplifier' ),
							);
						$contact_fields[] = array(
								'type'  => 'textarea',
								'id'    => 'content',
								'label' => __( 'HTML content', 'webman-amplifier' ),
							);
						$contact_fields = apply_filters( 'wmhook_wmamp_' . 'cp_metafields_' . 'wm_staff' . '_contact_fields', $contact_fields, $fonticons );
							$fields[3020] = array(
									'type'   => 'repeater',
									'id'     => 'contacts',
									'label'  => __( 'Staff contacts', 'webman-amplifier' ),
									'fields' => $contact_fields,
								);

					$fields[3980] = array(
							'type' => 'section-close',
						);
				// /"Contacts" tab

			//Apply filter to manipulate with metafields array
				$fields = apply_filters( 'wmhook_wmamp_' . 'cp_metafields_' . 'wm_staff', $fields );

			//Sort the array by the keys
				ksort( $fields );

			//Output
				return apply_filters( 'wmhook_wmamp_' . 'wma_staff_cp_metafields' . '_output', $fields );
		}
	} // /wma_staff_cp_metafields



	/**
	 * Create actual metabox
	 *
	 * @since  1.0
	 */
	if ( function_exists( 'wma_add_meta_box' ) ) {
		wma_add_meta_box( array(
				// Meta fields function callback (should return array of fields).
				// The function callback is used for to use a WordPress globals
				// available during the metabox rendering, such as $post.
				'fields' => 'wma_staff_cp_metafields',

				// Meta box id, unique per meta box.
				'id' => 'wm_staff' . '-metabox',

				// Post types.
				'pages' => array( 'wm_staff' ),

				// Tabbed meta box interface?
				'tabs' => true,

				// Meta box title.
				'title' => __( 'Staff settings', 'webman-amplifier' ),
			) );
	}





/**
 * OTHERS
 */

	/**
	 * Adding post type to Jetpack Sitemaps
	 *
	 * @link  https://jetpack.com/support/sitemaps/
	 * @link  https://developer.jetpack.com/hooks/jetpack_sitemap_post_types/
	 *
	 * @since    1.4.3
	 * @version  1.4.3
	 */
	if ( ! function_exists( 'wma_staff_cp_jetpack_sitemaps' ) ) {
		function wma_staff_cp_jetpack_sitemaps( $post_types = array() ) {

			// Processing

				$post_types[] = 'wm_staff';
				array_unique( $post_types );

			// Output

				return $post_types;

		}
	}

add_filter( 'jetpack_sitemap_post_types', 'wma_staff_cp_jetpack_sitemaps' );
