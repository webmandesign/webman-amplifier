<?php
/**
 * WebMan Custom Posts
 *
 * Registering "wm_logos" custom post.
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
	add_action( 'wmhook_wmamp_register_post_types', 'wma_logos_cp_register', 10 );

	// CP list table columns
	add_action( 'manage_wm_logos_posts_custom_column', 'wma_logos_cp_columns_render' );

	// Registering taxonomies
	add_action( 'wmhook_wmamp_register_post_types', 'wma_logos_cp_taxonomies', 10 );

	/**
	 * The init action occurs after the theme's functions file has been included.
	 * So, if you're looking for terms directly in the functions file,
	 * you're doing so before they've actually been registered.
	 */

/**
 * Filters
 */

	// CP list table columns
	add_filter( 'manage_edit-wm_logos_columns', 'wma_logos_cp_columns_register' );

/**
 * CREATING A CUSTOM POST
 */

	/**
	 * Custom post registration
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_logos_cp_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_logos_cp_register() {

			// Processing

				// Custom post registration arguments
				$args = (array) apply_filters( 'wmhook_wmamp_cp_register_wm_logos', array(
					'query_var'           => 'logo',
					'capability_type'     => 'post',
					'public'              => true,
					'show_ui'             => true,
					'exclude_from_search' => true,
					'show_in_nav_menus'   => false,
					'hierarchical'        => false,
					'rewrite'             => false,
					'menu_position'       => 33,
					'menu_icon'           => 'dashicons-awards',
					'supports'            => array(
						'title',
						'thumbnail',
						'author',
					),
					'labels'              => array(
						'name'                     => esc_html_x( 'Logos', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'singular_name'            => esc_html_x( 'Logos', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'add_new'                  => esc_html_x( 'Add New', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'add_new_item'             => esc_html_x( 'Add New', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'new_item'                 => esc_html_x( 'Add New', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'edit_item'                => esc_html_x( 'Edit', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'view_item'                => esc_html_x( 'View', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'view_items'               => esc_html_x( 'View Logos', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'search_items'             => esc_html_x( 'Search', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'not_found'                => esc_html_x( 'No item found', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'not_found_in_trash'       => esc_html_x( 'No item found in trash', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'featured_image'           => esc_html_x( 'Logo image', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'set_featured_image'       => esc_html_x( 'Set logo image', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'remove_featured_image'    => esc_html_x( 'Remove logo image', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'use_featured_image'       => esc_html_x( 'Use as logo image', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'filter_items_list'        => esc_html_x( 'Filter logos list', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'items_list_navigation'    => esc_html_x( 'Logos list navigation', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'items_list'               => esc_html_x( 'Logos list', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'attributes'               => esc_html_x( 'Logo Attributes', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'item_published'           => esc_html_x( 'Logo published.', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'item_published_privately' => esc_html_x( 'Logo published privately.', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'item_reverted_to_draft'   => esc_html_x( 'Logo reverted to draft.', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'item_scheduled'           => esc_html_x( 'Logo scheduled.', 'Custom post labels: Logos.', 'webman-amplifier' ),
						'item_updated'             => esc_html_x( 'Logo updated.', 'Custom post labels: Logos.', 'webman-amplifier' ),
					)
				) );

				// Register custom post type
				register_post_type( 'wm_logos' , $args );

		}
	} // /wma_logos_cp_register

/**
 * CUSTOM POST LIST TABLE IN ADMIN
 */

	/**
	 * Register table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_logos_cp_columns_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_logos_cp_columns_register( array $columns ): array {

			// Variables

				$prefix = 'wmamp-';
				$suffix = '-wm_logos';


			// Processing

				$columns[ $prefix . 'thumb' . $suffix ] = esc_html__( 'Logo', 'webman-amplifier' );
				$columns[ $prefix . 'link' . $suffix ]  = esc_html__( 'Custom link', 'webman-amplifier' );


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_logos_cp_columns_register_output', $columns );

		}
	} // /wma_logos_cp_columns_register



	/**
	 * Render table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_logos_cp_columns_render' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_logos_cp_columns_render( string $column ) {

			// Variables

				global $post;

				$prefix = 'wmamp-';
				$suffix = '-wm_logos';


			// Processing

				switch ( $column ) {

					case $prefix . 'link' . $suffix:

						$link = stripslashes( wma_meta_option( 'link' ) );

						echo
							'<a href="' . esc_url( $link ) . '">'
							. esc_url( $link )
							. '</a>';
						break;

					case $prefix . 'thumb' . $suffix:

						$size  = (string) apply_filters( 'wmhook_wmamp_cp_admin_thumb_size', 'thumbnail' );
						$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, $size ) ) : ( '' );

						$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

						echo '<span class="wm-image-container' . esc_attr( $hasThumb ) . '">';
						if ( get_edit_post_link() ) {
							edit_post_link( $image );
						} else {
							echo wp_kses( $image, WMA_KSES::$prefix . 'inline' );
						}
						echo '</span>';
						break;

					default:
						break;
				}

		}
	} // /wma_logos_cp_columns_render

/**
 * TAXONOMIES
 */

	/**
	 * Register taxonomies
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_logos_cp_taxonomies' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_logos_cp_taxonomies() {

			// Processing

				// Logos categories
				$args = (array) apply_filters( 'wmhook_wmamp_cp_taxonomy_logo_category', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => 'logo-category',
					'rewrite'           => false,
					'labels'            => array(
						'name'                  => esc_html_x( 'Logo Categories', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'singular_name'         => esc_html_x( 'Logo Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'search_items'          => esc_html_x( 'Search Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'all_items'             => esc_html_x( 'All Categories', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'parent_item'           => esc_html_x( 'Parent Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'parent_item_colon'     => esc_html_x( 'Parent Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ) . ':',
						'edit_item'             => esc_html_x( 'Edit Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'view_item'             => esc_html_x( 'View Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'update_item'           => esc_html_x( 'Update Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'add_new_item'          => esc_html_x( 'Add New Category', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'new_item_name'         => esc_html_x( 'New Category Title', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'not_found'             => esc_html_x( 'No categories found', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'no_terms'              => esc_html_x( 'No categories', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'items_list_navigation' => esc_html_x( 'Logo Categories list navigation', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
						'items_list'            => esc_html_x( 'Logo Categories list', 'Custom taxonomy labels: Logos categories.', 'webman-amplifier' ),
					)
				) );

				register_taxonomy( 'logo_category', 'wm_logos', $args );

		}
	} // /wma_logos_cp_taxonomies

/**
 * META BOXES
 */

	/**
	 * Register metabox fields
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_logos_cp_metafields' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_logos_cp_metafields(): array {

			// Variables

				$fields = array();

				// "Attributes" tab
				$fields[1000] = array(
					'type'  => 'section-open',
					'id'    => 'logo-settings-section',
					'title' => esc_html__( 'Logo settings', 'webman-amplifier' ),
				);

					// Logo image
					$fields[1020] = array(
						'type'    => 'html',
						'content' => '<tr class="option padding-20"><td colspan="2"><div class="box blue"><a href="#" class="button-primary button-set-featured-image" style="margin-right: 1em">' . esc_html__( 'Set featured image', 'webman-amplifier' ) . '</a> ' . esc_html__( 'Set the logo image as the featured image of the post', 'webman-amplifier' ) . '</div></td></tr>',
					);

					// Logo custom link input field
					$fields[1040] = array(
						'type'        => 'text',
						'id'          => 'link',
						'label'       => esc_html__( 'Custom link URL', 'webman-amplifier' ),
						'description' => esc_html__( 'No link will be displayed / applied when left blank', 'webman-amplifier' ),
						'validate'    => 'url',
					);

					// Logo custom link actions
					$fields[1060] = array(
						'type'        => 'select',
						'id'          => 'link-action',
						'label'       => esc_html__( 'Custom link action', 'webman-amplifier' ),
						'description' => esc_html__( 'Choose how to display / apply the link set above', 'webman-amplifier' ),
						'options'     => array(
							'_blank' => esc_html__( 'Open in new tab / window', 'webman-amplifier' ),
							'_self'  => esc_html__( 'Open in same window', 'webman-amplifier' ),
						),
					);

				// /"Attributes" tab
				$fields[1980] = array(
					'type' => 'section-close',
				);

				// Apply filter to manipulate with metafields array
				$fields = (array) apply_filters( 'wmhook_wmamp_cp_metafields_wm_logos', $fields );

				// Sort the array by the keys
				ksort( $fields );

			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_logos_cp_metafields_output', $fields );

		}
	} // /wma_logos_cp_metafields



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
			'fields' => 'wma_logos_cp_metafields',

			// Meta box id, unique per meta box.
			'id' => 'wm_logos-metabox',

			// Post types.
			'pages' => array( 'wm_logos' ),

			// Tabbed meta box interface?
			'tabs' => false,

			// Meta box title.
			'title' => esc_html__( 'Logo settings', 'webman-amplifier' ),

			// Wrap the meta form around visual editor? (This is always tabbed.)
			'visual-wrapper' => false,
		) );
	}
