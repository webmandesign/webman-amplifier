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

$definitions['posts']['bb_plugin'] = array(
	'name'   => esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
	'output' => '[PREFIX_posts{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_posts]',
	'params' => $params,
	'form'   => array(

		//Tab
		'general' => array(
			//Title
			'title'       => esc_html__( 'General', 'webman-amplifier' ),
			'description' => '',
			//Sections
			'sections' => array(

				//Section
				'general' => array(
					'title'  => '',
					'fields' => array(

						'post_type' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Post type', 'webman-amplifier' ),
							'help'  => esc_html__( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
							//type specific
							'options' => $helpers['post_types'],
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /post_type

						'count' => array(
							'type' => 'text',
							//description
							'label' => esc_html__( 'Count', 'webman-amplifier' ),
							'help'  => esc_html__( 'Number of items to display', 'webman-amplifier' ),
							//default
							'default' => 3,
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /count

						'columns' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Columns', 'webman-amplifier' ),
							//default
							'default' => 3,
							//type specific
							'options' => array(
									1 => 1,
									2 => 2,
									3 => 3,
									4 => 4,
									5 => 5,
									6 => 6,
								),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /columns

						'order' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Order', 'webman-amplifier' ),
							//type specific
							'options' => array(
									'new'      => esc_html__( 'Newest first', 'webman-amplifier' ),
									'old'      => esc_html__( 'Oldest first', 'webman-amplifier' ),
									'name'     => esc_html__( 'By name', 'webman-amplifier' ),
									'random'   => esc_html__( 'Randomly', 'webman-amplifier' ),
									'menuasc'  => esc_html__( 'Custom, ascending', 'webman-amplifier' ),
									'menudesc' => esc_html__( 'Custom, descending', 'webman-amplifier' ),
								),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /order

					), // /fields
				), // /section

			), // /sections
		), // /tab

		//Tab
		'description' => array(
			//Title
			'title'       => esc_html__( 'Description', 'webman-amplifier' ),
			'description' => '',
			//Sections
			'sections' => array(

				//Section
				'description' => array(
					'title'  => '',
					'fields' => array(

						'align' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Description alignment', 'webman-amplifier' ),
							//type specific
							'options' => array(
								'left'  => esc_html__( 'Left', 'webman-amplifier' ),
								'right' => esc_html__( 'Right', 'webman-amplifier' ),
							),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /align

					), // /fields
				), // /section

				//Section
				'content' => array(
					'title'  => esc_html__( 'Content', 'webman-amplifier' ),
					'fields' => array(

						'content' => array(
							'type' => 'editor',
							//description
							'label' => '',
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /content

					), // /fields
				), // /section

			), // /sections
		), // /tab

		//Tab
		'others' => array(
			//Title
			'title'       => esc_html__( 'Others', 'webman-amplifier' ),
			'description' => '',
			//Sections
			'sections' => array(

				//Section
				'general' => array(
					'title'  => '',
					'fields' => array(

						'no_margin' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
							//type specific
							'options' => array(
								'' => esc_html__( 'No', 'webman-amplifier' ),
								1  => esc_html__( 'Yes', 'webman-amplifier' ),
							),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /no_margin

						'taxonomy' => array(
							'type' => 'text',
							//description
							'label'       => esc_html__( 'From taxonomy', 'webman-amplifier' ),
							'description' => '<br />' . esc_html__( 'Example: "taxonomy_name" or more specific "taxonomy_name:taxonomy-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( ', ', $taxonomies ) . '</code>',
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /taxonomy

						'filter' => array(
							'type' => 'text',
							//description
							'label'       => esc_html__( 'Filter by', 'webman-amplifier' ),
							'description' => '<br />' . esc_html__( 'Example: "taxonomy_name" or more specific "taxonomy_name:taxonomy-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( ', ', $taxonomies ) . '</code>',
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /filter

						'filter_layout' => array(
							'type' => 'text',
							//description
							'label'       => esc_html__( 'Filter layout', 'webman-amplifier' ),
							'description' => sprintf( esc_html__( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . esc_html__( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /filter_layout

						'scroll' => array(
							'type' => 'text',
							//description
							'label' => esc_html__( 'Scrolling', 'webman-amplifier' ),
							'help'  => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /scroll

						'related' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Related by', 'webman-amplifier' ),
							'help'  => esc_html__( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ),
							//type specific
							'options' => wma_asort( array_merge( array( '' => '' ), $taxonomies ) ),
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /related

						'pagination' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Display pagination?', 'webman-amplifier' ),
							//type specific
							'options' => array(
								'' => esc_html__( 'No', 'webman-amplifier' ),
								1  => esc_html__( 'Yes', 'webman-amplifier' ),
							),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /pagination

						'image_size' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Image size', 'webman-amplifier' ),
							//type specific
							'options' => wma_asort( array_merge( array( '' => '' ), wma_get_image_sizes() ) ),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /image_size

						'heading_tag' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Heading HTML tag', 'webman-amplifier' ),
							'description' => sprintf( esc_html__( 'Default value: %s', 'webman-amplifier' ), 'H2' ),
							//type specific
							'options' => $helpers['heading_tags'],
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /heading_tag

					), // /fields
				), // /section

			), // /sections
		), // /tab

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
