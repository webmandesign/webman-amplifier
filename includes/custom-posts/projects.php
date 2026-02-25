<?php
/**
 * WebMan Custom Posts
 *
 * Registering "wm_projects" custom post.
 *
 * @package     WebMan Amplifier
 * @subpackage  Custom Posts
 *
 * @since    1.0
 * @version  1.6.2
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Actions
 */

	// Registering CP
	add_action( 'wmhook_wmamp_register_post_types', 'wma_projects_cp_register', 10 );

	// CP list table columns
	add_action( 'manage_wm_projects_posts_custom_column', 'wma_projects_cp_columns_render' );

	// Registering taxonomies
	add_action( 'wmhook_wmamp_register_post_types', 'wma_projects_cp_taxonomies', 10 );

	// Permanlinks settings
	add_action( 'admin_init', 'wma_projects_cp_permalinks' );

	/**
	 * The init action occurs after the theme's functions file has been included.
	 * So, if you're looking for terms directly in the functions file,
	 * you're doing so before they've actually been registered.
	 */

/**
 * Filters
 */

	// CP list table columns
	add_filter( 'manage_edit-wm_projects_columns', 'wma_projects_cp_columns_register' );

/**
 * CREATING A CUSTOM POST
 */

	/**
	 * Custom post registration
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_projects_cp_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_register() {

			// Variables

				$permalinks = get_option( 'wmamp-permalinks' );


			// Processing

				// Custom post registration arguments
				$args = apply_filters( 'wmhook_wmamp_cp_register_wm_projects', array(
					'query_var'           => 'project',
					'capability_type'     => 'post',
					'public'              => true,
					'show_ui'             => true,
					'has_archive'         => ( isset( $permalinks['projects'] ) && $permalinks['projects'] ) ? ( $permalinks['projects'] ) : ( 'projects' ),
					'exclude_from_search' => false,
					'hierarchical'        => false,
					'rewrite'             => array(
						'slug' => ( isset( $permalinks['project'] ) && $permalinks['project'] ) ? ( $permalinks['project'] ) : ( 'project' ),
					),
					'menu_position'       => 30,
					'menu_icon'           => 'dashicons-portfolio',
					'supports'            => array(
						'title',
						'editor',
						'excerpt',
						'thumbnail',
						'custom-fields',
						'author',
					),
					'labels'              => array(
						'name'                     => esc_html_x( 'Projects', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'singular_name'            => esc_html_x( 'Project', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'add_new'                  => esc_html_x( 'Add New', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'add_new_item'             => esc_html_x( 'Add New Project', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'new_item'                 => esc_html_x( 'Add New', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'edit_item'                => esc_html_x( 'Edit Project', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'view_item'                => esc_html_x( 'View Project', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'view_items'               => esc_html_x( 'View Projects', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'search_items'             => esc_html_x( 'Search Projects', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'not_found'                => esc_html_x( 'No project found', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'not_found_in_trash'       => esc_html_x( 'No project found in trash', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'filter_items_list'        => esc_html_x( 'Filter projects list', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'items_list_navigation'    => esc_html_x( 'Projects list navigation', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'items_list'               => esc_html_x( 'Projects list', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'attributes'               => esc_html_x( 'Project Attributes', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'item_published'           => esc_html_x( 'Project published.', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'item_published_privately' => esc_html_x( 'Project published privately.', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'item_reverted_to_draft'   => esc_html_x( 'Project reverted to draft.', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'item_scheduled'           => esc_html_x( 'Project scheduled.', 'Custom post labels: Projects.', 'webman-amplifier' ),
						'item_updated'             => esc_html_x( 'Project updated.', 'Custom post labels: Projects.', 'webman-amplifier' ),
					),
					'show_in_rest' => true, // Required for Gutenberg editor.
				) );

				// Register custom post type
				register_post_type( 'wm_projects' , $args );

		}
	} // /wma_projects_cp_register

/**
 * CUSTOM POST LIST TABLE IN ADMIN
 */

	/**
	 * Register table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_projects_cp_columns_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_columns_register( array $columns ): array {

			// Variables

				$prefix = 'wmamp-';
				$suffix = '-wm_projects';


			// Processing

				$columns[ $prefix . 'thumb' . $suffix ] = esc_html__( 'Image', 'webman-amplifier' );


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_projects_cp_columns_register_output', $columns );

		}
	} // /wma_projects_cp_columns_register



	/**
	 * Render table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_projects_cp_columns_render' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_columns_render( string $column ) {

			// Variables

				global $post;

				$prefix = 'wmamp-';
				$suffix = '-wm_projects';


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
							echo wp_kses( '<a href="' . get_permalink() . '">' . $image . '</a>', WMA_KSES::$prefix . 'inline' );
						}
						echo '</span>';
					break;

					default:
						break;
				}

		}
	} // /wma_projects_cp_columns_render

/**
 * TAXONOMIES
 */

	/**
	 * Register taxonomies
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_projects_cp_taxonomies' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_taxonomies() {

			// Variables

				$permalinks = get_option( 'wmamp-permalinks' );


			// Processing

				// Projects categories

					$args = apply_filters( 'wmhook_wmamp_cp_taxonomy_project_category', array(
						'hierarchical'      => true,
						'show_ui'           => true,
						'show_admin_column' => true,
						'query_var'         => 'project-category',
						'rewrite'           => array(
							'slug' => ( isset( $permalinks['project_category'] ) && $permalinks['project_category'] ) ? ( $permalinks['project_category'] ) : ( 'project-category' )
						),
						'labels'            => array(
							'name'                  => esc_html_x( 'Project Categories', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'singular_name'         => esc_html_x( 'Project Category', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'search_items'          => esc_html_x( 'Search Categories', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'all_items'             => esc_html_x( 'All Categories', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'parent_item'           => esc_html_x( 'Parent Category', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'parent_item_colon'     => esc_html_x( 'Parent Category', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ) . ':',
							'edit_item'             => esc_html_x( 'Edit Category', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'view_item'             => esc_html_x( 'View Category', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'update_item'           => esc_html_x( 'Update Category', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'add_new_item'          => esc_html_x( 'Add New Category', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'new_item_name'         => esc_html_x( 'New Category Title', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'not_found'             => esc_html_x( 'No categories found', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'no_terms'              => esc_html_x( 'No categories', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'items_list_navigation' => esc_html_x( 'Project Categories list navigation', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
							'items_list'            => esc_html_x( 'Project Categories list', 'Custom taxonomy labels: Projects categories.', 'webman-amplifier' ),
						),
						'show_in_rest' => true, // Required for Gutenberg editor.
					) );

					register_taxonomy( 'project_category', 'wm_projects', $args );

				// Projects tags

					$args = apply_filters( 'wmhook_wmamp_cp_taxonomy_project_tag', array(
						'hierarchical'      => false,
						'show_ui'           => true,
						'show_admin_column' => true,
						'query_var'         => 'project-tag',
						'rewrite'           => array(
							'slug' => ( isset( $permalinks['project_tag'] ) && $permalinks['project_tag'] ) ? ( $permalinks['project_tag'] ) : ( 'project-tag' )
						),
						'labels'            => array(
							'name'                       => esc_html_x( 'Project Tags', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'singular_name'              => esc_html_x( 'Project Tag', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'search_items'               => esc_html_x( 'Search Tags', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'popular_items'              => esc_html_x( 'Popular Tags', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'all_items'                  => esc_html_x( 'All Tags', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'edit_item'                  => esc_html_x( 'Edit Tag', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'view_item'                  => esc_html_x( 'View Tag', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'update_item'                => esc_html_x( 'Update Tag', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'add_new_item'               => esc_html_x( 'Add New Tag', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'new_item_name'              => esc_html_x( 'New Tag Title', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'separate_items_with_commas' => esc_html_x( 'Separate tags with commas', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'add_or_remove_items'        => esc_html_x( 'Add or remove tags', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'choose_from_most_used'      => esc_html_x( 'Choose from the most used tags', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'not_found'                  => esc_html_x( 'No tags found', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'no_terms'                   => esc_html_x( 'No tags', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'items_list_navigation'      => esc_html_x( 'Project Tags list navigation', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
							'items_list'                 => esc_html_x( 'Project Tags list', 'Custom taxonomy labels: Projects tags.', 'webman-amplifier' ),
						),
						'show_in_rest' => true, // Required for Gutenberg editor.
					) );

					register_taxonomy( 'project_tag', 'wm_projects', $args );

		}
	} // /wma_projects_cp_taxonomies

/**
 * PERMALINKS SETTINGS
 */

	/**
	 * Create permalinks settings fields in WordPress admin
	 *
	 * @since    1.0
	 * @version  1.6.2
	 */
	if ( ! function_exists( 'wma_projects_cp_permalinks' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_permalinks() {

			// Requirements check

				if ( empty( get_post_type_object( 'wm_projects' )->has_archive ) ) {
					return;
				}


			// Processing

				// Adding sections

					add_settings_section(
						'wmamp-wm_projects-permalinks',
						esc_html__( 'Projects Custom Post Permalinks', 'webman-amplifier' ),
						'wma_projects_cp_permalinks_render_section',
						'permalink'
					);

				// Adding settings fields

					add_settings_field(
						'projects',
						esc_html__( 'Projects archive permalink', 'webman-amplifier' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-wm_projects-permalinks',
						array(
							'name'        => 'projects',
							'placeholder' => (string) apply_filters( 'wmhook_wmamp_cp_permalink_projects', 'projects' )
						)
					);

					add_settings_field(
						'project',
						esc_html__( 'Single project permalink', 'webman-amplifier' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-wm_projects-permalinks',
						array(
							'name'        => 'project',
							'placeholder' => (string) apply_filters( 'wmhook_wmamp_cp_permalink_project', 'project' )
						)
					);

					add_settings_field(
						'project_category',
						esc_html__( 'Project category base', 'webman-amplifier' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-wm_projects-permalinks',
						array(
							'name'        => 'project_category',
							'placeholder' => (string) apply_filters( 'wmhook_wmamp_cp_permalink_project_category', 'project-category' )
						)
					);

					add_settings_field(
						'project_tag',
						esc_html__( 'Project tag base', 'webman-amplifier' ),
						'wma_permalinks_render_field',
						'permalink',
						'wmamp-wm_projects-permalinks',
						array(
							'name'        => 'project_tag',
							'placeholder' => (string) apply_filters( 'wmhook_wmamp_cp_permalink_project_tag', 'project-tag' )
						)
					);

		}
	} // /wma_projects_cp_permalinks



	/**
	 * Create permalinks settings section WordPress admin
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_projects_cp_permalinks_render_section' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_permalinks_render_section() {

			// Processing

				// Settings section description
				echo wp_kses(
					(string) apply_filters(
						'wmhook_wmamp_wma_projects_cp_permalinks_render_section_output',
						'<p>'
						. esc_html__( 'You can change the Projects custom post type permalinks here.', 'webman-amplifier' )
						. '</p>'
					),
					WMA_KSES::$prefix . 'form'
				);

		}
	} // /wma_projects_cp_permalinks_render_section

/**
 * META BOXES
 */

	/**
	 * Register metabox fields
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_projects_cp_metafields' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_metafields() {

			// Variables

				$fields = array();

				// "Attributes" tab
				$fields[1000] = array(
					'type'  => 'section-open',
					'id'    => 'project-attributes-section',
					'title' => esc_html_x( 'Attributes', 'Metabox section title.', 'webman-amplifier' ),
				);

					// Project custom link input field
					$fields[1020] = array(
						'type'        => 'text',
						'id'          => 'link',
						'label'       => esc_html__( 'Custom link URL', 'webman-amplifier' ),
						'description' => esc_html__( 'No link will be displayed / applied when left blank', 'webman-amplifier' ),
					);

					// Project custom link actions
					$fields[1040] = array(
						'type'        => 'select',
						'id'          => 'link-action',
						'label'       => esc_html__( 'Custom link action', 'webman-amplifier' ),
						'description' => esc_html__( 'Choose how to display / apply the link set above', 'webman-amplifier' ),
						'optgroups'   => true,
						'options'     => array(
							'1OPTGROUP'  => esc_html__( 'Project page', 'webman-amplifier' ),
								''         => esc_html__( 'Display link on project page', 'webman-amplifier' ),
							'1/OPTGROUP' => '',
							'2OPTGROUP'  => esc_html__( 'Apply directly in projects list', 'webman-amplifier' ),
								'modal'    => esc_html__( 'Open in popup window (videos and images only)', 'webman-amplifier' ),
								'_blank'   => esc_html__( 'Open in new tab / window', 'webman-amplifier' ),
								'_self'    => esc_html__( 'Open in same window', 'webman-amplifier' ),
							'2/OPTGROUP' => '',
						),
					);

				// /"Attributes" tab
				$fields[1980] = array(
					'type' => 'section-close',
				);

				// Apply filter to manipulate with metafields array
				$fields = (array) apply_filters( 'wmhook_wmamp_cp_metafields_wm_projects', $fields );

				// Sort the array by the keys
				ksort( $fields );

			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_projects_cp_metafields_output', $fields );

		}
	} // /wma_projects_cp_metafields



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
			'fields' => 'wma_projects_cp_metafields',

			// Meta box id, unique per meta box.
			'id' => 'wm_projects-metabox',

			// Post types.
			'pages' => array( 'wm_projects' ),

			// Tabbed meta box interface?
			'tabs' => true,

			// Meta box title.
			'title' => esc_html__( 'Project settings', 'webman-amplifier' ),
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
	if ( ! function_exists( 'wma_projects_cp_jetpack_sitemaps' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_projects_cp_jetpack_sitemaps( array $post_types = array() ): array {

			// Processing

				$post_types[] = 'wm_projects';
				array_unique( $post_types );


			// Output

				return $post_types;

		}
	}

	add_filter( 'jetpack_sitemap_post_types', 'wma_projects_cp_jetpack_sitemaps' );
