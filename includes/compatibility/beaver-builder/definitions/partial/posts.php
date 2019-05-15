<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [posts]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





$params = array(
	'align',
	'class',
	'columns',
	'content',
	'count',
	'filter',
	'heading_tag',
	'image_size',
	'no_margin',
	'order',
	'pagination',
	'post_type',
	'related',
	'scroll',
	'taxonomy',
);

$taxonomies = get_taxonomies( '', 'names' );
unset( $taxonomies['nav_menu'] );
unset( $taxonomies['link_category'] );
asort( $taxonomies );

$definitions['posts'][ $key ] = array(
	'name'   => esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
	'output' => '[PREFIX_posts{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_posts]',
	'params' => $params,
	'form'   => array(

		// Tab
		'general' => array(
			'title'       => esc_html__( 'General', 'webman-amplifier' ),
			'description' => '',
			'sections'    => array(

				'general' => array(
					'title'  => '',
					'fields' => array(

						'post_type' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Post type', 'webman-amplifier' ),
							'help'    => esc_html__( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
							'options' => $helpers['post_types'],
							'preview' => array( 'type' => 'refresh' ),
						),

						'count' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Count', 'webman-amplifier' ),
							'help'    => esc_html__( 'Number of items to display', 'webman-amplifier' ),
							'default' => 3,
							'preview' => array( 'type' => 'refresh' ),
						),

						'columns' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Columns', 'webman-amplifier' ),
							'default' => 3,
							'options' => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
								5 => 5,
								6 => 6,
							),
							'preview' => array( 'type' => 'refresh' ),
						),

						'order' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Order', 'webman-amplifier' ),
							'options' => array(
								'new'      => esc_html__( 'Newest first', 'webman-amplifier' ),
								'old'      => esc_html__( 'Oldest first', 'webman-amplifier' ),
								'name'     => esc_html__( 'By name', 'webman-amplifier' ),
								'random'   => esc_html__( 'Randomly', 'webman-amplifier' ),
								'menuasc'  => esc_html__( 'Custom, ascending', 'webman-amplifier' ),
								'menudesc' => esc_html__( 'Custom, descending', 'webman-amplifier' ),
							),
							'preview' => array( 'type' => 'refresh' ),
						),

					),
				),

			),
		),

		// Tab
		'description' => array(
			'title'       => esc_html__( 'Description', 'webman-amplifier' ),
			'description' => '',
			'sections'    => array(

				'description' => array(
					'title'  => '',
					'fields' => array(

						'align' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Description alignment', 'webman-amplifier' ),
							'options' => array(
								'left'  => esc_html__( 'Left', 'webman-amplifier' ),
								'right' => esc_html__( 'Right', 'webman-amplifier' ),
							),
							'preview' => array( 'type' => 'refresh' ),
						),

					),
				),

				'content' => array(
					'title'  => esc_html__( 'Content', 'webman-amplifier' ),
					'fields' => array(

						'content' => array(
							'type'    => 'editor',
							'label'   => '',
							'preview' => array( 'type' => 'refresh' ),
						),

					),
				),

			),
		),

		// Tab
		'others' => array(
			'title'       => esc_html__( 'Others', 'webman-amplifier' ),
			'description' => '',
			'sections'    => array(

				'general' => array(
					'title'  => '',
					'fields' => array(

						'no_margin' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
							'options' => array(
								'' => esc_html__( 'No', 'webman-amplifier' ),
								1  => esc_html__( 'Yes', 'webman-amplifier' ),
							),
							'preview' => array( 'type' => 'refresh' ),
						),

						'taxonomy' => array(
							'type'        => 'text',
							'label'       => esc_html__( 'From taxonomy', 'webman-amplifier' ),
							'description' =>
								'<span style="display: block;">'
								. esc_html__( 'Displays items from specific taxonomy term only.', 'webman-amplifier' )
								. '<br>'
								. sprintf(
									esc_html__( 'Example: %s.', 'webman-amplifier' ),
									'<code>category:my-category-slug</code>'
								)
								. '<br><br>'
								. esc_html__( 'Available taxonomy keys:', 'webman-amplifier' )
								. ' <code>' . implode( ', ', $taxonomies ) . '</code>'
								. '</span>',
							'preview'     => array( 'type' => 'refresh' ),
						),

						'filter' => array(
							'type'        => 'text',
							'label'       => esc_html__( 'Animated filter', 'webman-amplifier' ),
							'description' =>
								'<span style="display: block;">'
								. esc_html__( 'Enables animated filter from terms of specified taxonomy.', 'webman-amplifier' )
								. ' '
								. esc_html__( 'Works well only when displaying all items (set the "Count" parameter to 100, for example).', 'webman-amplifier' )
								. '<br>'
								. sprintf(
									esc_html__( 'Example: %1$s or %2$s.', 'webman-amplifier' ),
									'<code>category</code>',
									'<code>category:my-parent-category-slug</code>'
								)
								. '<br><br>'
								. esc_html__( 'Available taxonomy keys:', 'webman-amplifier' )
								. ' <code>' . implode( ', ', $taxonomies ) . '</code>'
								. '</span>',
							'preview'     => array( 'type' => 'refresh' ),
						),

						'filter_layout' => array(
							'type'        => 'text',
							'label'       => esc_html__( 'Filter layout', 'webman-amplifier' ),
							'description' => sprintf( esc_html__( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . esc_html__( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
							'preview'     => array( 'type' => 'refresh' ),
						),

						'scroll' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'Scrolling', 'webman-amplifier' ),
							'help'    => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
							'preview' => array( 'type' => 'refresh' ),
						),

						'related' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Related by', 'webman-amplifier' ),
							'help'    => esc_html__( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ),
							'options' => wma_asort( array_merge( array( '' => '' ), $taxonomies ) ),
							'preview' => array( 'type' => 'none' ),
						),

						'pagination' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Display pagination?', 'webman-amplifier' ),
							'options' => array(
								'' => esc_html__( 'No', 'webman-amplifier' ),
								1  => esc_html__( 'Yes', 'webman-amplifier' ),
							),
							'preview' => array( 'type' => 'refresh' ),
						),

						'image_size' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Image size', 'webman-amplifier' ),
							'options' => wma_asort( array_merge( array( '' => '' ), wma_get_image_sizes() ) ),
							'preview' => array( 'type' => 'refresh' ),
						),

						'heading_tag' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
							'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H2' ),
							'options'     => $helpers['heading_tags'],
							'preview'     => array( 'type' => 'none' ),
						),

					),
				),

			),
		),

	),
	'compatibility/wpml' => array(
		array(
			'field'       => 'taxonomy',
			'type'        => esc_html__( 'From taxonomy', 'webman-amplifier' ),
			'editor_type' => 'LINE',
		),
		array(
			'field'       => 'filter',
			'type'        => esc_html__( 'Filter by', 'webman-amplifier' ),
			'editor_type' => 'LINE',
		),
		array(
			'field'       => 'content',
			'type'        => esc_html__( 'Content', 'webman-amplifier' ),
			'editor_type' => 'VISUAL',
		),
	),
);
