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
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Actions
 */

	// Registering CP
	add_action( 'wmhook_wmamp_register_post_types', 'wma_testimonials_cp_register', 10 );

	// CP list table columns
	add_action( 'manage_wm_testimonials_posts_custom_column', 'wma_testimonials_cp_columns_render' );

	// Registering taxonomies
	add_action( 'wmhook_wmamp_register_post_types', 'wma_testimonials_cp_taxonomies', 10 );

	// Permanlinks settings
	add_action( 'admin_init', 'wma_testimonials_cp_permalinks' );

	/**
	 * The init action occurs after the theme's functions file has been included.
	 * So, if you're looking for terms directly in the functions file,
	 * you're doing so before they've actually been registered.
	 */

/**
 * Filters
 */

	// CP list table columns
	add_filter( 'manage_edit-wm_testimonials_columns', 'wma_testimonials_cp_columns_register' );

/**
 * CREATING A CUSTOM POST
 */

	/**
	 * Custom post registration
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_register() {

			// Variables

				$permalinks = get_option( 'wmamp-permalinks' );


			// Processing

				// Custom post registration arguments
				$args = apply_filters( 'wmhook_wmamp_cp_register_wm_testimonials', array(
					'query_var'           => 'testimonial',
					'capability_type'     => 'page',
					'public'              => true,
					'show_ui'             => true,
					'exclude_from_search' => true,
					'has_archive'         => ( isset( $permalinks['testimonials'] ) && $permalinks['testimonials'] ) ? ( $permalinks['testimonials'] ) : ( 'testimonials' ),
					'hierarchical'        => false,
					'rewrite'             => array(
						'slug' => ( isset( $permalinks['testimonial'] ) && $permalinks['testimonial'] ) ? ( $permalinks['testimonial'] ) : ( 'testimonial' ),
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
						'name'                     => esc_html_x( 'Testimonials', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'singular_name'            => esc_html_x( 'Testimonial', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'add_new'                  => esc_html_x( 'Add New', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'add_new_item'             => esc_html_x( 'Add New Testimonial', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'edit_item'                => esc_html_x( 'Edit Testimonial', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'new_item'                 => esc_html_x( 'Add New', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'view_item'                => esc_html_x( 'View Testimonial', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'view_items'               => esc_html_x( 'View Testimonials', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'search_items'             => esc_html_x( 'Search Testimonials', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'not_found'                => esc_html_x( 'No testimonial found', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'not_found_in_trash'       => esc_html_x( 'No testimonials found in trash', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'filter_items_list'        => esc_html_x( 'Filter testimonials list', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'items_list_navigation'    => esc_html_x( 'Testimonials list navigation', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'items_list'               => esc_html_x( 'Testimonials list', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'attributes'               => esc_html_x( 'Testimonial Attributes', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'item_published'           => esc_html_x( 'Testimonial published.', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'item_published_privately' => esc_html_x( 'Testimonial published privately.', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'item_reverted_to_draft'   => esc_html_x( 'Testimonial reverted to draft.', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'item_scheduled'           => esc_html_x( 'Testimonial scheduled.', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
						'item_updated'             => esc_html_x( 'Testimonial updated.', 'Custom post labels: Testimonials.', 'webman-amplifier' ),
					)
				) );

				// Register custom post type
				register_post_type( 'wm_testimonials' , $args );

		}
	} // /wma_testimonials_cp_register

/**
 * CUSTOM POST LIST TABLE IN ADMIN
 */

	/**
	 * Register table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_columns_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_columns_register( array $columns ): array {

			// Variables

				$prefix = 'wmamp-';
				$suffix = '-wm_testimonials';


			// Processing

				$columns[ $prefix . 'thumb' . $suffix ] = esc_html__( 'Photo', 'webman-amplifier' );


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_testimonials_cp_columns_register_output', $columns );

		}
	} // /wma_testimonials_cp_columns_register



	/**
	 * Render table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_columns_render' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_columns_render( string $column ) {

			// Variables

				global $post;

				$prefix = 'wmamp-';
				$suffix = '-wm_testimonials';


			// Processing

				switch ( $column ) {

					case $prefix . 'thumb' . $suffix:

						$size  = (string) apply_filters( 'wmhook_wmamp_cp_admin_thumb_size', 'thumbnail' );
						$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, $size ) ) : ( '' );

						$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

						echo '<span class="wm-image-container' . esc_attr( $hasThumb ) . '">';
						if ( get_edit_post_link() ) {
							edit_post_link( $image );
						} else {
							echo wp_kses( '<a href="' . get_permalink() . '">' . $image . '</a>', WMA_KSES::$prefix . 'inline' );
						}
						echo '</span>';
						break;

					default:
						break;
				}

		}
	} // /wma_testimonials_cp_columns_render

/**
 * TAXONOMIES
 */

	/**
	 * Register taxonomies
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_taxonomies' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_taxonomies() {

			// Variables

				$permalinks = get_option( 'wmamp-permalinks' );


			// Processing

				// Testimonial categories
				$args = apply_filters( 'wmhook_wmamp_cp_taxonomy_testimonial_category', array(
					'hierarchical'      => true,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => 'testimonial-category',
					'rewrite'           => array(
						'slug' => ( isset( $permalinks['testimonial_category'] ) && $permalinks['testimonial_category'] ) ? ( $permalinks['testimonial_category'] ) : ( 'testimonial-category' )
					),
					'labels'            => array(
						'name'                  => esc_html_x( 'Categories', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'singular_name'         => esc_html_x( 'Category', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'search_items'          => esc_html_x( 'Search Categories', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'all_items'             => esc_html_x( 'All Categories', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'parent_item'           => esc_html_x( 'Parent Category', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'parent_item_colon'     => esc_html_x( 'Parent Category', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ) . ':',
						'edit_item'             => esc_html_x( 'Edit Category', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'view_item'             => esc_html_x( 'View Category', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'update_item'           => esc_html_x( 'Update Category', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'add_new_item'          => esc_html_x( 'Add New Category', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'new_item_name'         => esc_html_x( 'New Category Title', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'not_found'             => esc_html_x( 'No categories found', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'no_terms'              => esc_html_x( 'No categories', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'items_list_navigation' => esc_html_x( 'Testimonials Categories list navigation', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
						'items_list'            => esc_html_x( 'Testimonials Categories list', 'Custom taxonomy labels: Testimonials categories.', 'webman-amplifier' ),
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
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_permalinks' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_permalinks() {

			// Requirements check

				$obj = get_post_type_object( 'wm_testimonials' );

				if ( ! $obj->has_archive ) {
					return;
				}


			// Processing

				// Adding sections

					add_settings_section(
						'wmamp-wm_testimonials-permalinks',
						esc_html__( 'Testimonials Custom Post Permalinks', 'webman-amplifier' ),
						'wma_testimonials_cp_permalinks_render_section',
						'permalink'
					);

				// Adding settings fields

					add_settings_field(
						'testimonials',
						esc_html__( 'Testimonials archive permalink', 'webman-amplifier' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-wm_testimonials-permalinks',
						array(
							'name'        => 'testimonials',
							'placeholder' => (string) apply_filters( 'wmhook_wmamp_cp_permalink_testimonials', 'testimonials' )
						)
					);

					add_settings_field(
						'testimonial',
						esc_html__( 'Single testimonial permalink', 'webman-amplifier' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-wm_testimonials-permalinks',
						array(
							'name'        => 'testimonial',
							'placeholder' => (string) apply_filters( 'wmhook_wmamp_cp_permalink_testimonial', 'testimonial' )
						)
					);

					add_settings_field(
						'testimonial_category',
						esc_html__( 'Testimonial category base', 'webman-amplifier' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-wm_testimonials-permalinks',
						array(
							'name'        => 'testimonial_category',
							'placeholder' => (string) apply_filters( 'wmhook_wmamp_cp_permalink_testimonial_category', 'testimonial-category' )
						)
					);

		}
	} // /wma_testimonials_cp_permalinks



	/**
	 * Create permalinks settings section WordPress admin
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_permalinks_render_section' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_permalinks_render_section() {

			// Processing

				// Settings section description
				echo wp_kses(
					(string) apply_filters(
						'wmhook_wmamp_wma_testimonials_cp_permalinks_render_section_output',
						'<p>'
						. esc_html__( 'You can change the Testimonials custom post type permalinks here.', 'webman-amplifier' )
						. '</p>'
					),
					WMA_KSES::$prefix . 'form'
				);

		}
	} // /wma_testimonials_cp_permalinks_render_section

/**
 * META BOXES
 */

	/**
	 * Register metabox fields
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_metafields' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_metafields(): array {

			// Variables

				$fields = array();

				// "Author" tab
				$fields[1000] = array(
					'type'  => 'section-open',
					'id'    => 'testimonial-author-section',
					'title' => esc_html_x( 'Author', 'Metabox section title.', 'webman-amplifier' ),
				);

					// Testimonial image
					$fields[1020] = array(
						'type'    => 'html',
						'content' => '<tr class="option padding-20"><td colspan="2"><div class="box blue"><a href="#" class="button-primary button-set-featured-image" style="margin-right: 1em">' . esc_html__( 'Set featured image', 'webman-amplifier' ) . '</a> ' . esc_html__( 'You can set the testimonial author photo or logo as post featured image', 'webman-amplifier' ) . '</div></td></tr>',
					);

					// Testimonial author input field
					$fields[1040] = array(
						'type'        => 'text',
						'id'          => 'author',
						'label'       => esc_html__( 'Testimonial author', 'webman-amplifier' ),
						'description' => esc_html__( 'Set the testimonial author name here', 'webman-amplifier' ),
					);

					// Testimonial custom link input field
					$fields[1060] = array(
						'type'        => 'text',
						'id'          => 'link',
						'label'       => esc_html__( 'Custom link URL', 'webman-amplifier' ),
						'description' => esc_html__( 'No link will be displayed / applied when left blank', 'webman-amplifier' ),
						'validate'    => 'url',
					);

					// Testimonial custom link actions
					$fields[1080] = array(
						'type'        => 'select',
						'id'          => 'link-action',
						'label'       => esc_html__( 'Custom link action', 'webman-amplifier' ),
						'description' => esc_html__( 'Choose how to display / apply the link set above', 'webman-amplifier' ),
						'options'     => array(
							'_blank' => esc_html__( 'Open in new tab / window', 'webman-amplifier' ),
							'_self'  => esc_html__( 'Open in same window', 'webman-amplifier' ),
						),
					);

				// /"Author" tab
				$fields[1980] = array(
					'type' => 'section-close',
				);

				// Apply filter to manipulate with metafields array
				$fields = (array) apply_filters( 'wmhook_wmamp_cp_metafields_wm_testimonials', $fields );

				// Sort the array by the keys
				ksort( $fields );


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_testimonials_cp_metafields_output', $fields );

		}
	} // /wma_testimonials_cp_metafields



	/**
	 * Create actual metabox
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( function_exists( 'wma_add_meta_box' ) ) {
		wma_add_meta_box( array(

			// Meta fields function callback (should return array of fields).
			// The function callback is used for to use a WordPress globals
			// available during the metabox rendering, such as $post.
			'fields' => 'wma_testimonials_cp_metafields',

			// Meta box id, unique per meta box.
			'id' => 'wm_testimonials-metabox',

			// Post types.
			'pages' => array( 'wm_testimonials' ),

			// Tabbed meta box interface?
			'tabs' => true,

			// Meta box title.
			'title' => esc_html__( 'Testimonial settings', 'webman-amplifier' ),
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
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_testimonials_cp_jetpack_sitemaps' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_testimonials_cp_jetpack_sitemaps( array $post_types = array() ): array {

			// Processing

				$post_types[] = 'wm_testimonials';
				array_unique( $post_types );


			// Output

				return $post_types;

		}
	}

	add_filter( 'jetpack_sitemap_post_types', 'wma_testimonials_cp_jetpack_sitemaps' );
