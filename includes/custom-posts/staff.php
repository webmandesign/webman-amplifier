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
 * @version  1.1
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
			add_action( WMAMP_HOOK_PREFIX . 'register_post_types', 'wma_staff_cp_register', 10 );
		//CP list table columns
			add_action( 'manage_wm_staff_posts_custom_column', 'wma_staff_cp_columns_render' );
		//Registering taxonomies
			add_action( WMAMP_HOOK_PREFIX . 'register_post_types', 'wma_staff_cp_taxonomies', 10 );
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





/**
 * CREATING A CUSTOM POST
 */

	/**
	 * Custom post registration
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_staff_cp_register' ) ) {
		function wma_staff_cp_register() {
			$permalinks = get_option( 'wmamp-permalinks' );

			//Custom post registration arguments
				$args = apply_filters( WMAMP_HOOK_PREFIX . 'cp_register_' . 'wm_staff', array(
					'query_var'           => 'staff',
					'capability_type'     => 'page',
					'public'              => true,
					'show_ui'             => true,
					'exclude_from_search' => true,
					'show_in_nav_menus'   => false,
					'hierarchical'        => false,
					'rewrite'             => array(
							'slug' => ( isset( $permalinks['staff'] ) && $permalinks['staff'] ) ? ( $permalinks['staff'] ) : ( 'staff' )
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
						'name'               => _x( 'Staff', 'Custom post labels: Staff.', 'wm_domain' ),
						'singular_name'      => _x( 'Staff Member', 'Custom post labels: Staff.', 'wm_domain' ),
						'add_new'            => _x( 'Add New', 'Custom post labels: Staff.', 'wm_domain' ),
						'add_new_item'       => _x( 'Add New Member', 'Custom post labels: Staff.', 'wm_domain' ),
						'new_item'           => _x( 'Add New', 'Custom post labels: Staff.', 'wm_domain' ),
						'edit_item'          => _x( 'Edit Member', 'Custom post labels: Staff.', 'wm_domain' ),
						'view_item'          => _x( 'View Member', 'Custom post labels: Staff.', 'wm_domain' ),
						'search_items'       => _x( 'Search Members', 'Custom post labels: Staff.', 'wm_domain' ),
						'not_found'          => _x( 'No member found', 'Custom post labels: Staff.', 'wm_domain' ),
						'not_found_in_trash' => _x( 'No members found in trash', 'Custom post labels: Staff.', 'wm_domain' ),
						'parent_item_colon'  => ''
					)
				) );

			//Register custom post type
				register_post_type( 'wm_staff' , $args );
		}
	} // /wma_staff_cp_register





/**
 * CUSTOM POST LIST TABLE IN ADMIN
 */

	/**
	 * Register table columns
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_staff_cp_columns_register' ) ) {
		function wma_staff_cp_columns_register( $columns ) {
			//Helper variables
				$prefix = 'wmamp-';
				$suffix = '-wm_staff';

			//Register table columns
				$columns = apply_filters( WMAMP_HOOK_PREFIX . 'cp_columns_' . 'wm_staff', array(
					'cb'                             => '<input type="checkbox" />',
					$prefix . 'thumb' . $suffix      => __( 'Photo', 'wm_domain' ),
					'title'                          => __( 'Name', 'wm_domain' ),
					$prefix . 'position' . $suffix   => __( 'Position', 'wm_domain' ),
					$prefix . 'department' . $suffix => __( 'Department', 'wm_domain' ),
					'date'                           => __( 'Date', 'wm_domain' ),
					'author'                         => __( 'Author', 'wm_domain' )
				) );

			return apply_filters( WMAMP_HOOK_PREFIX . 'wma_staff_cp_columns_register' . '_output', $columns );
		}
	} // /wma_staff_cp_columns_register



	/**
	 * Render table columns
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_staff_cp_columns_render' ) ) {
		function wma_staff_cp_columns_render( $column ) {
			//Helper variables
				global $post;
				$prefix = 'wmamp-';
				$suffix = '-wm_staff';

			//Columns renderers
				switch ( $column ) {
					case $prefix . 'department' . $suffix:

						$terms = get_the_terms( $post->ID , 'staff_department' );
						if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
								echo '<strong class="staff-department">' . $termName . '</strong><br />';
							}
						}

					break;
					case $prefix . 'position' . $suffix:

						$separator = '';
						$terms     = get_the_terms( $post->ID , 'staff_position' );
						if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
								echo $separator . $termName;
								$separator = ', ';
							}
						}

					break;
					case $prefix . 'thumb' . $suffix:

						$size  = apply_filters( WMAMP_HOOK_PREFIX . 'cp_admin_thumb_size', 'admin-thumbnail' );
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
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_staff_cp_taxonomies' ) ) {
		function wma_staff_cp_taxonomies() {
			$permalinks = get_option( 'wmamp-permalinks' );

			//Staff departments
				$args = apply_filters( WMAMP_HOOK_PREFIX . 'cp_taxonomy_' . 'staff_department', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'staff-department',
					'rewrite'           => array(
							'slug' => ( isset( $permalinks['staff_department'] ) && $permalinks['staff_department'] ) ? ( $permalinks['staff_department'] ) : ( 'staff-department' )
						),
					'labels'            => array(
						'name'          => _x( 'Departments', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'singular_name' => _x( 'Department', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'search_items'  => _x( 'Search Departments', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'all_items'     => _x( 'All Departments', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'parent_item'   => _x( 'Parent Department', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'edit_item'     => _x( 'Edit Department', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'update_item'   => _x( 'Update Department', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'add_new_item'  => _x( 'Add New Department', 'Custom taxonomy labels: Staff departments.', 'wm_domain' ),
						'new_item_name' => _x( 'New Department Title', 'Custom taxonomy labels: Staff departments.', 'wm_domain' )
					)
				) );

				register_taxonomy( 'staff_department', 'wm_staff', $args );

			//Staff positions
				$args = apply_filters( WMAMP_HOOK_PREFIX . 'cp_taxonomy_' . 'staff_position', array(
					'hierarchical'      => false,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'staff-position',
					'rewrite'           => array(
							'slug' => ( isset( $permalinks['staff_position'] ) && $permalinks['staff_position'] ) ? ( $permalinks['staff_position'] ) : ( 'staff-position' )
						),
					'labels'            => array(
						'name'          => _x( 'Positions', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
						'singular_name' => _x( 'Position', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
						'search_items'  => _x( 'Search Positions', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
						'all_items'     => _x( 'All Positions', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
						'edit_item'     => _x( 'Edit Position', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
						'update_item'   => _x( 'Update Position', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
						'add_new_item'  => _x( 'Add New Position', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
						'new_item_name' => _x( 'New Position Title', 'Custom taxonomy labels: Staff positions.', 'wm_domain' ),
					)
				) );

				register_taxonomy( 'staff_position', 'wm_staff', $args );
		}
	} // /wma_staff_cp_taxonomies





/**
 * PERMALINKS SETTINGS
 */

	/**
	 * Create permalinks settings fields in WordPress admin
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_staff_cp_permalinks' ) ) {
		function wma_staff_cp_permalinks() {
			//Adding sections
				add_settings_section(
						'wmamp-' . 'wm_staff' . '-permalinks',
						__( 'Staff Custom Post Permalinks', 'wm_domain' ),
						'wma_staff_cp_permalinks_render_section',
						'permalink'
					);

			//Adding settings fields
				add_settings_field(
						'staff',
						__( 'Single staff permalink', 'wm_domain' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-' . 'wm_staff' . '-permalinks',
						array(
								'name'        => 'staff',
								'placeholder' => apply_filters( WMAMP_HOOK_PREFIX . 'cp_permalink_' . 'staff', 'staff' )
							)
					);
				add_settings_field(
						'staff_department',
						__( 'Staff department base', 'wm_domain' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-' . 'wm_staff' . '-permalinks',
						array(
								'name'        => 'staff_department',
								'placeholder' => apply_filters( WMAMP_HOOK_PREFIX . 'cp_permalink_' . 'staff_department', 'staff-department' )
							)
					);
				add_settings_field(
						'staff_position',
						__( 'Staff positions base', 'wm_domain' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-' . 'wm_staff' . '-permalinks',
						array(
								'name'        => 'staff_position',
								'placeholder' => apply_filters( WMAMP_HOOK_PREFIX . 'cp_permalink_' . 'staff_position', 'staff-position' )
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
				echo apply_filters( WMAMP_HOOK_PREFIX . 'wma_staff_cp_permalinks_render_section' . '_output', '<p>' . __( 'You can change the Staff custom post type permalinks here.', 'wm_domain' ) . '</p>' );
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
							'title' => _x( 'Info', 'Metabox section title.', 'wm_domain' ),
						);

						//Staff custom link input field
							$fields[1020] = array(
									'type'        => 'text',
									'id'          => 'link',
									'label'       => __( 'Custom link URL', 'wm_domain' ),
									'description' => __( 'No link will be displayed / applied when left blank', 'wm_domain' ),
									'validate'    => 'url',
								);

						//Staff custom link to a page selector
							$fields[1040] = array(
									'type'        => 'select',
									'id'          => 'link-page',
									'label'       => __( '...or link to a page', 'wm_domain' ),
									'description' => __( 'No link will be displayed / applied when left blank', 'wm_domain' ),
									'options'     => wma_pages_array(),
								);

						//Staff custom link actions
							$fields[1060] = array(
									'type'        => 'select',
									'id'          => 'link-action',
									'label'       => __( 'Custom link action', 'wm_domain' ),
									'description' => __( 'Choose how to display / apply the link set above', 'wm_domain' ),
									'options'     => array(
											'_blank' => __( 'Open in new tab / window', 'wm_domain' ),
											'_self'  => __( 'Open in same window', 'wm_domain' ),
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
							'title' => _x( 'Contacts', 'Metabox section title.', 'wm_domain' ),
						);

						//Staff custom contacts
						$contact_fields = array();
						if ( ! empty( $fonticons ) ) {
							$contact_fields[] = array(
									'type'    => 'select',
									'id'      => 'icon',
									'label'   => __( 'Icon', 'wm_domain' ),
									'options' => $fonticons,
								);
						}
						$contact_fields[] = array(
								'type'  => 'text',
								'id'    => 'title',
								'label' => __( 'Title', 'wm_domain' ),
							);
						$contact_fields[] = array(
								'type'  => 'textarea',
								'id'    => 'content',
								'label' => __( 'HTML content', 'wm_domain' ),
							);
						$contact_fields = apply_filters( WMAMP_HOOK_PREFIX . 'cp_metafields_' . 'wm_staff' . '_contact_fields', $contact_fields, $fonticons );
							$fields[3020] = array(
									'type'   => 'repeater',
									'id'     => 'contacts',
									'label'  => __( 'Staff contacts', 'wm_domain' ),
									'fields' => $contact_fields,
								);

					$fields[3980] = array(
							'type' => 'section-close',
						);
				// /"Contacts" tab

			//Apply filter to manipulate with metafields array
				$fields = apply_filters( WMAMP_HOOK_PREFIX . 'cp_metafields_' . 'wm_staff', $fields );

			//Sort the array by the keys
				ksort( $fields );

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_staff_cp_metafields' . '_output', $fields );
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
				'title' => __( 'Staff settings', 'wm_domain' ),
			) );
	}

?>