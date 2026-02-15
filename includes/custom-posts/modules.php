<?php
/**
 * WebMan Custom Posts
 *
 * Registering "wm_modules" custom post.
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
	add_action( 'wmhook_wmamp_register_post_types', 'wma_modules_cp_register', 10 );

	// CP list table columns
	add_action( 'manage_wm_modules_posts_custom_column', 'wma_modules_cp_columns_render' );
	add_action( 'admin_enqueue_scripts', 'wma_modules_cp_admin_assets', 10 );

	// Registering taxonomies
	add_action( 'wmhook_wmamp_register_post_types', 'wma_modules_cp_taxonomies', 10 );

	/**
	 * The init action occurs after the theme's functions file has been included.
	 * So, if you're looking for terms directly in the functions file,
	 * you're doing so before they've actually been registered.
	 */

/**
 * Filters
 */

	// CP list table columns
	add_filter( 'manage_edit-wm_modules_columns', 'wma_modules_cp_columns_register' );

/**
 * CREATING A CUSTOM POST
 */

	/**
	 * Custom post registration
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_modules_cp_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_modules_cp_register() {

			// Processing

				// Custom post registration arguments
				$args = apply_filters( 'wmhook_wmamp_cp_register_wm_modules', array(
					'query_var'           => 'module',
					'capability_type'     => 'page',
					'public'              => true,
					'show_ui'             => true,
					'exclude_from_search' => true,
					'show_in_nav_menus'   => false,
					'hierarchical'        => false,
					'rewrite'             => false,
					'menu_position'       => 45,
					'menu_icon'           => 'dashicons-format-aside',
					'supports'            => array(
						'title',
						'editor',
						'thumbnail',
						'author',
					),
					'labels'              => array(
						'name'                     => esc_html_x( 'Content Modules', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'singular_name'            => esc_html_x( 'Content Module', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'add_new'                  => esc_html_x( 'Add New', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'add_new_item'             => esc_html_x( 'Add New module', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'new_item'                 => esc_html_x( 'Add New', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'edit_item'                => esc_html_x( 'Edit Module', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'view_item'                => esc_html_x( 'View Module', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'view_items'               => esc_html_x( 'View Modules', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'search_items'             => esc_html_x( 'Search Modules', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'not_found'                => esc_html_x( 'No module found', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'not_found_in_trash'       => esc_html_x( 'No module found in trash', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'filter_items_list'        => esc_html_x( 'Filter content modules list', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'items_list_navigation'    => esc_html_x( 'Content Modules list navigation', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'items_list'               => esc_html_x( 'Content Modules list', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'attributes'               => esc_html_x( 'Content Module Attributes', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'item_published'           => esc_html_x( 'Content Module published.', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'item_published_privately' => esc_html_x( 'Content Module published privately.', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'item_reverted_to_draft'   => esc_html_x( 'Content Module reverted to draft.', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'item_scheduled'           => esc_html_x( 'Content Module scheduled.', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
						'item_updated'             => esc_html_x( 'Content Module updated.', 'Custom post labels: Content Modules.', 'webman-amplifier' ),
					)
				) );

				// Register custom post type
				register_post_type( 'wm_modules' , $args );

		}
	} // /wma_modules_cp_register

/**
 * CUSTOM POST LIST TABLE IN ADMIN
 */

	/**
	 * Register table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_modules_cp_columns_register' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_modules_cp_columns_register( array $columns ): array {

			// Variables

				$prefix = 'wmamp-';
				$suffix = '-wm_modules';


			// Processing

				$columns[ $prefix . 'slug' . $suffix ]  = esc_html__( 'Slug', 'webman-amplifier' );
				$columns[ $prefix . 'thumb' . $suffix ] = esc_html__( 'Image', 'webman-amplifier' );


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_modules_cp_columns_register_output', $columns );

		}
	} // /wma_modules_cp_columns_register



	/**
	 * Render table columns
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_modules_cp_columns_render' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_modules_cp_columns_render( string $column ) {

			// Variables

				global $post;

				$prefix = 'wmamp-';
				$suffix = '-wm_modules';


			// Processing

				switch ( $column ) {

					case $prefix . 'slug' . $suffix:
						echo
							'<input
								type="text"
								value="' . esc_attr( get_post_field( 'post_name' ) ) . '"
								class="wma-column--slug"
								readonly="readonly"
								onfocus="this.select()"
								/>';
						break;

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

						$fontIcon    = wma_meta_option( 'icon-font' );
						$iconColor   = wma_meta_option( 'icon-color' );
						$iconBgColor = wma_meta_option( 'icon-color-background' );

						$styleIcon      = ( $iconColor ) ? ( ' style="color: ' . esc_attr( $iconColor ) . '"' ) : ( '' );
						$styleContainer = ( $iconBgColor ) ? ( ' style="background-color: ' . esc_attr( $iconBgColor ) . '"' ) : ( '' );

						if ( $fontIcon ) {
							$image = '<span class="' . esc_attr( $fontIcon ) . '"' . $styleIcon . ' aria-hidden="true"></span>';
						}

						$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

						echo wp_kses( '<span class="wm-image-container' . esc_attr( $hasThumb ) . '"' . $styleContainer . '>', 'wma/inline' );
						if ( get_edit_post_link() ) {
							edit_post_link( $image );
						} else {
							echo wp_kses( $image, 'wma/inline' );
						}
						echo '</span>';
						break;

					default:
						break;
				}

		}
	} // /wma_modules_cp_columns_render



	/**
	 * Enqueue admin assets.
	 *
	 * @since  1.6.0
	 */
	if ( ! function_exists( 'wma_modules_cp_admin_assets' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_modules_cp_admin_assets( string $hook ) {

			// Requirements check

				if ( 'edit.php' !== $hook ) {
					return;
				}

				$screen = get_current_screen();

				if ( 'edit-wm_modules' !== $screen->id ) {
					return;
				}


			// Processing

				wp_enqueue_style( 'wm-fonticons' );

				wp_add_inline_style( 'wm-fonticons', '
					.wp-list-table .wma-column--slug {
						min-height: auto;
						padding: .5em;
						font-size: .9em;
						font-family: monospace;
						line-height: 1;
						background: none;
						border-style: dashed;
					}
				' );

		}
	} // /wma_modules_cp_admin_assets

/**
 * TAXONOMIES
 */

	/**
	 * Register taxonomies
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_modules_cp_taxonomies' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_modules_cp_taxonomies() {

			// Processing

				// Module tags
				$args = apply_filters( 'wmhook_wmamp_cp_taxonomy_module_tag', array(
					'hierarchical'      => false,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => 'module-tag',
					'rewrite'           => false,
					'labels'            => array(
						'name'                       => esc_html_x( 'Module Tags', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'singular_name'              => esc_html_x( 'Module Tag', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'search_items'               => esc_html_x( 'Search Tags', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'popular_items'              => esc_html_x( 'Popular Tags', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'all_items'                  => esc_html_x( 'All Tags', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'edit_item'                  => esc_html_x( 'Edit Tag', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'view_item'                  => esc_html_x( 'View Tag', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'update_item'                => esc_html_x( 'Update Tag', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'add_new_item'               => esc_html_x( 'Add New Tag', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'new_item_name'              => esc_html_x( 'New Tag Title', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'separate_items_with_commas' => esc_html_x( 'Separate tags with commas', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'add_or_remove_items'        => esc_html_x( 'Add or remove tags', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'choose_from_most_used'      => esc_html_x( 'Choose from the most used tags', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'not_found'                  => esc_html_x( 'No tags found', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'no_terms'                   => esc_html_x( 'No tags', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'items_list_navigation'      => esc_html_x( 'Module Tags list navigation', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
						'items_list'                 => esc_html_x( 'Module Tags list', 'Custom taxonomy labels: Content Modules tags.', 'webman-amplifier' ),
					)
				) );

				register_taxonomy( 'module_tag', 'wm_modules', $args );

		}
	} // /wma_modules_cp_taxonomies

/**
 * META BOXES
 */

	/**
	 * Register metabox fields
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_modules_cp_metafields' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_modules_cp_metafields() {

			// Variables

				$fields    = $icons = array();
				$fonticons = get_option( 'wmamp-icons' );

				// Prepare font icons
				if ( isset( $fonticons['icons_select'] ) ) {
					$fonticons = array_merge( array( '' => '' ), $fonticons['icons_select'] );
				} else {
					$fonticons = array();
				}

				// "Settings" tab
				$fields[1000] = array(
					'type'  => 'section-open',
					'id'    => 'module-settings-section',
					'title' => esc_html_x( 'Settings', 'Metabox section title.', 'webman-amplifier' ),
				);

					// Module custom link input field
					$fields[1020] = array(
						'type'        => 'text',
						'id'          => 'link',
						'label'       => esc_html__( 'Custom link URL', 'webman-amplifier' ),
						'description' => esc_html__( 'No link will be displayed / applied when left blank', 'webman-amplifier' ),
						'validate'    => 'url',
					);

					// Module custom link actions
					$fields[1040] = array(
						'type'        => 'select',
						'id'          => 'link-action',
						'label'       => esc_html__( 'Custom link action', 'webman-amplifier' ),
						'description' => esc_html__( 'Choose how to display / apply the link set above', 'webman-amplifier' ),
						'options'     => array(
							'_blank' => esc_html__( 'Open in new tab / window', 'webman-amplifier' ),
							'_self'  => esc_html__( 'Open in same window', 'webman-amplifier' ),
						),
						'default'    => '_self',
					);

					// Module type (setting icon box)
					$fields[1060] = array(
						'type'        => 'checkbox',
						'id'          => 'icon-box',
						'label'       => esc_html__( 'Use as icon box', 'webman-amplifier' ),
						'description' => esc_html__( 'Creates an icon box', 'webman-amplifier' ),
					);

					// Conditional subsection displayed if icon box set
					$fields[1200] = array(
						'type'  => 'sub-section-open',
						'id'    => 'module-icon-section',
					);

						// Featured image setup
						$fields[1220] = array(
							'type'    => 'html',
							'content' => '<tr class="option padding-20"><td colspan="2"><div class="box blue"><a href="#" class="button-primary button-set-featured-image" style="margin-right: 1em">' . esc_html__( 'Set featured image', 'webman-amplifier' ) . '</a> ' . esc_html__( 'Set the icon as featured image of the post. If the font icon is used instead, it will be prioritized.', 'webman-amplifier' ) . '</div></td></tr>',
						);

						if ( ! empty( $fonticons ) ) {

							// Choose font icon
							$fields[1240] = array(
								'type'        => 'radio',
								'id'          => 'icon-font',
								'label'       => esc_html__( '...or choose a font icon', 'webman-amplifier' ),
								'description' => esc_html__( 'Select from predefined font icons', 'webman-amplifier' ),
								'options'     => $fonticons,
								'inline'      => true,
								'filter'      => true,
								'custom'      => '<span class="{{value}}" title="{{value}}" style="display: inline-block; width: 20px; height: 20px; line-height: 1em; font-size: 20px; vertical-align: top; color: #444;" aria-hidden="true"></span>',
								'hide-radio'  => true,
							);

							// Icon color
							$fields[1260] = array(
								'type'        => 'color',
								'id'          => 'icon-color',
								'label'       => esc_html__( 'Font icon color', 'webman-amplifier' ),
								'description' => esc_html__( 'Set the color of the icon font', 'webman-amplifier' ),
								'conditional' => array(
									'option'       => array(
										'tag'  => 'input',
										'name' => 'wm-icon-font',
										'type' => 'radio',
									),
									'option_value' => array( '' ),
									'operand'      => 'IS_NOT',
								),
							);
						}

						// Icon background
						$fields[1280] = array(
							'type'        => 'color',
							'id'          => 'icon-color-background',
							'label'       => esc_html__( 'Icon background color', 'webman-amplifier' ),
							'description' => esc_html__( 'Set the color of the icon background', 'webman-amplifier' ),
						);

					$fields[1480] = array(
						'type'        => 'sub-section-close',
						'id'          => 'module-icon-section',
						'conditional' => array(
							'option'       => array(
								'tag'  => 'input',
								'name' => 'wm-icon-box',
								'type' => 'checkbox',
							),
							'option_value' => array( 1 ),
							'operand'      => 'IS',
						),
					);

				// /"Settings" tab
				$fields[1980] = array(
					'type' => 'section-close',
				);

				// Apply filter to manipulate with metafields array
				$fields = (array) apply_filters( 'wmhook_wmamp_cp_metafields_wm_modules', $fields );

				// Sort the array by the keys
				ksort( $fields );


			// Output

				return (array) apply_filters( 'wmhook_wmamp_wma_modules_cp_metafields_output', $fields );

		}
	} // /wma_modules_cp_metafields



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
			'fields' => 'wma_modules_cp_metafields',

			// Meta box id, unique per meta box.
			'id' => 'wm_modules-metabox',

			// Post types.
			'pages' => array( 'wm_modules' ),

			// Tabbed meta box interface?
			'tabs' => true,

			// Meta box title.
			'title' => esc_html__( 'Module settings', 'webman-amplifier' ),
		) );
	}
