<?php
/**
 * WebMan Custom Posts
 *
 * Registering "wm_testimonials" custom post.
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
			add_action( WMAMP_HOOK_PREFIX . 'register_post_types', 'wma_testimonials_cp_register', 10 );
		//CP list table columns
			add_action( 'manage_wm_testimonials_posts_custom_column', 'wma_testimonials_cp_columns_render' );
		//Registering taxonomies
			add_action( WMAMP_HOOK_PREFIX . 'register_post_types', 'wma_testimonials_cp_taxonomies', 10 );
		//Permanlinks settings
			add_action( 'admin_init', 'wma_testimonials_cp_permalinks' );

		/**
		 * The init action occurs after the theme's functions file has been included.
		 * So, if you're looking for terms directly in the functions file,
		 * you're doing so before they've actually been registered.
		 */



	/**
	 * Filters
	 */

		//CP list table columns
			add_filter( 'manage_edit-wm_testimonials_columns', 'wma_testimonials_cp_columns_register' );





/**
 * CREATING A CUSTOM POST
 */

	/**
	 * Custom post registration
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_register' ) ) {
		function wma_testimonials_cp_register() {
			$permalinks = get_option( 'wmamp-permalinks' );

			//Custom post registration arguments
				$args = apply_filters( WMAMP_HOOK_PREFIX . 'cp_register_' . 'wm_testimonials', array(
					'query_var'           => 'testimonials',
					'capability_type'     => 'page',
					'public'              => true,
					'show_ui'             => true,
					'exclude_from_search' => true,
					'show_in_nav_menus'   => false,
					'hierarchical'        => false,
					'rewrite'             => array(
							'slug' => ( isset( $permalinks['testimonial'] ) && $permalinks['testimonial'] ) ? ( $permalinks['testimonial'] ) : ( 'testimonial' )
						),
					'menu_position'       => 39,
					'menu_icon'           => 'dashicons-testimonial',
					'supports'            => array(
							'title',
							'editor',
							'thumbnail',
							'author',
						),
					'labels'              => array(
						'name'               => _x( 'Testimonials', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'singular_name'      => _x( 'Testimonial', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'add_new'            => _x( 'Add New', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'add_new_item'       => _x( 'Add New Testimonial', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'new_item'           => _x( 'Add New', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'edit_item'          => _x( 'Edit Testimonial', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'view_item'          => _x( 'View Testimonial', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'search_items'       => _x( 'Search Testimonials', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'not_found'          => _x( 'No testimonial found', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'not_found_in_trash' => _x( 'No testimonials found in trash', 'Custom post labels: Testimonials.', 'wm_domain' ),
						'parent_item_colon'  => ''
					)
				) );

			//Register custom post type
				register_post_type( 'wm_testimonials' , $args );
		}
	} // /wma_testimonials_cp_register





/**
 * CUSTOM POST LIST TABLE IN ADMIN
 */

	/**
	 * Register table columns
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_columns_register' ) ) {
		function wma_testimonials_cp_columns_register( $columns ) {
			//Helper variables
				$prefix = 'wmamp-';
				$suffix = '-wm_testimonials';

			//Register table columns
				$columns = apply_filters( WMAMP_HOOK_PREFIX . 'cp_columns_' . 'wm_testimonials', array(
					'cb'                           => '<input type="checkbox" />',
					$prefix . 'thumb' . $suffix    => __( 'Photo', 'wm_domain' ),
					'title'                        => __( 'Title', 'wm_domain' ),
					$prefix . 'category' . $suffix => __( 'Category', 'wm_domain' ),
					$prefix . 'slug' . $suffix     => __( 'Slug', 'wm_domain' ),
					'date'                         => __( 'Date', 'wm_domain' ),
					'author'                       => __( 'Author', 'wm_domain' )
				) );

			return apply_filters( WMAMP_HOOK_PREFIX . 'wma_testimonials_cp_columns_register' . '_output', $columns );
		}
	} // /wma_testimonials_cp_columns_register



	/**
	 * Render table columns
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_columns_render' ) ) {
		function wma_testimonials_cp_columns_render( $column ) {
			//Helper variables
				global $post;
				$prefix = 'wmamp-';
				$suffix = '-wm_testimonials';

			//Columns renderers
				switch ( $column ) {
					case $prefix . 'category' . $suffix:

						$terms = get_the_terms( $post->ID , 'testimonial_category' );
						if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
								echo '<strong class="testimonial-category">' . $termName . '</strong><br />';
							}
						}

					break;
					case $prefix . 'slug' . $suffix:

						echo $post->post_name;

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
	} // /wma_testimonials_cp_columns_render





/**
 * TAXONOMIES
 */

	/**
	 * Register taxonomies
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_taxonomies' ) ) {
		function wma_testimonials_cp_taxonomies() {
			$permalinks = get_option( 'wmamp-permalinks' );

			//Testimonial categories
				$args = apply_filters( WMAMP_HOOK_PREFIX . 'cp_taxonomy_' . 'testimonial_category', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'testimonial-category',
					'rewrite'           => array(
							'slug' => ( isset( $permalinks['testimonial_category'] ) && $permalinks['testimonial_category'] ) ? ( $permalinks['testimonial_category'] ) : ( 'testimonial-category' )
						),
					'labels'            => array(
						'name'          => _x( 'Categories', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'singular_name' => _x( 'Category', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'search_items'  => _x( 'Search Categories', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'all_items'     => _x( 'All Categories', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'parent_item'   => _x( 'Parent Category', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'edit_item'     => _x( 'Edit Category', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'update_item'   => _x( 'Update Category', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'add_new_item'  => _x( 'Add New Category', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' ),
						'new_item_name' => _x( 'New Category Title', 'Custom taxonomy labels: Testimonials categories.', 'wm_domain' )
					)
				) );

				register_taxonomy( 'testimonial_category', 'wm_testimonials', $args );
		}
	} // /wma_testimonials_cp_taxonomies





/**
 * PERMALINKS SETTINGS
 */

	/**
	 * Create permalinks settings fields in WordPress admin
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_permalinks' ) ) {
		function wma_testimonials_cp_permalinks() {
			//Adding sections
				add_settings_section(
						'wmamp-' . 'wm_testimonials' . '-permalinks',
						__( 'Testimonials Custom Post Permalinks', 'wm_domain' ),
						'wma_testimonials_cp_permalinks_render_section',
						'permalink'
					);

			//Adding settings fields
				add_settings_field(
						'testimonial',
						__( 'Single testimonial permalink', 'wm_domain' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-' . 'wm_testimonials' . '-permalinks',
						array(
								'name'        => 'testimonial',
								'placeholder' => apply_filters( WMAMP_HOOK_PREFIX . 'cp_permalink_' . 'testimonial', 'testimonial' )
							)
					);
				add_settings_field(
						'testimonial_category',
						__( 'Testimonial category base', 'wm_domain' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-' . 'wm_testimonials' . '-permalinks',
						array(
								'name'        => 'testimonial_category',
								'placeholder' => apply_filters( WMAMP_HOOK_PREFIX . 'cp_permalink_' . 'testimonial_category', 'testimonial-category' )
							)
					);
		}
	} // /wma_testimonials_cp_permalinks



	/**
	 * Create permalinks settings section WordPress admin
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_permalinks_render_section' ) ) {
		function wma_testimonials_cp_permalinks_render_section() {
			//Settings section description
				echo apply_filters( WMAMP_HOOK_PREFIX . 'wma_testimonials_cp_permalinks_render_section' . '_output', '<p>' . __( 'You can change the Testimonials custom post type permalinks here.', 'wm_domain' ) . '</p>' );
		}
	} // /wma_testimonials_cp_permalinks_render_section





/**
 * META BOXES
 */

	/**
	 * Register metabox fields
	 *
	 * @since  1.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_metafields' ) ) {
		function wma_testimonials_cp_metafields() {
			//Helper variables
				$fields = array();

				//"Author" tab
					$fields[1000] = array(
							'type'  => 'section-open',
							'id'    => 'testimonial-author-section',
							'title' => _x( 'Author', 'Metabox section title.', 'wm_domain' ),
						);

						//Testimonial image
							$fields[1020] = array(
									'type'    => 'html',
									'content' => '<tr class="option padding-20"><td colspan="2"><div class="box blue"><a href="#" class="button-primary button-set-featured-image" style="margin-right: 1em">' . __( 'Set featured image', 'wm_domain' ) . '</a> ' . __( 'You can set the testimonial author photo or logo as post featured image', 'wm_domain' ) . '</div></td></tr>',
								);

						//Testimonial author input field
							$fields[1040] = array(
									'type'        => 'text',
									'id'          => 'author',
									'label'       => __( 'Testimonial author', 'wm_domain' ),
									'description' => __( 'Set the testimonial author name here', 'wm_domain' ),
								);

						//Testimonial custom link input field
							$fields[1060] = array(
									'type'        => 'text',
									'id'          => 'link',
									'label'       => __( 'Custom link URL', 'wm_domain' ),
									'description' => __( 'No link will be displayed / applied when left blank', 'wm_domain' ),
									'validate'    => 'url',
								);

						//Testimonial custom link actions
							$fields[1080] = array(
									'type'        => 'select',
									'id'          => 'link-action',
									'label'       => __( 'Custom link action', 'wm_domain' ),
									'description' => __( 'Choose how to display / apply the link set above', 'wm_domain' ),
									'options'     => array(
											'_blank' => __( 'Open in new tab / window', 'wm_domain' ),
											'_self'  => __( 'Open in same window', 'wm_domain' ),
										),
								);

					$fields[1980] = array(
							'type' => 'section-close',
						);
				// /"Author" tab

			//Apply filter to manipulate with metafields array
				$fields = apply_filters( WMAMP_HOOK_PREFIX . 'cp_metafields_' . 'wm_testimonials', $fields );

			//Sort the array by the keys
				ksort( $fields );

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_testimonials_cp_metafields' . '_output', $fields );
		}
	} // /wma_testimonials_cp_metafields



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
				'fields' => 'wma_testimonials_cp_metafields',

				// Meta box id, unique per meta box.
				'id' => 'wm_testimonials' . '-metabox',

				// Post types.
				'pages' => array( 'wm_testimonials' ),

				// Tabbed meta box interface?
				'tabs' => true,

				// Meta box title.
				'title' => __( 'Testimonial settings', 'wm_domain' ),
			) );
	}

?>