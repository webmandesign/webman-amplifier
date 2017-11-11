<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [content_module]
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
	'layout',
	'module',
	'no_margin',
	'order',
	'pagination',
	'scroll',
	'tag',
);

$content_module_slugs = wma_posts_array( 'post_name', 'wm_modules' );
$content_module_tags  = wma_taxonomy_array( array(
	'all_post_type' => '',
	'all_text'      => '-',
	'hierarchical'  => '0',
	'tax_name'      => 'module_tag'
) );

$definitions['content_module']['bb_plugin'] = array(
	'name'   => esc_html__( 'Content Module', 'webman-amplifier' ),
	'output' => '[PREFIX_content_module{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_content_module]',
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
				'single' => array(
					'title'  => esc_html__( 'Single module display', 'webman-amplifier' ),
					'fields' => array(

						'module' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Single module', 'webman-amplifier' ),
							'help'  => esc_html__( 'Leave empty to display multiple modules', 'webman-amplifier' ),
							//type specific
							'options' => $content_module_slugs,
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /module

					), // /fields
				), // /section

				//Section
				'multiple' => array(
					'title'  => esc_html__( 'Multiple modules display', 'webman-amplifier' ),
					'fields' => array(

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

						'filter' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Filtering', 'webman-amplifier' ),
							'help'  => esc_html__( 'Display the modules filter from module tags?', 'webman-amplifier' ),
							//type specific
							'options' => array(
								'' => esc_html__( 'No', 'webman-amplifier' ),
								1  => esc_html__( 'Yes', 'webman-amplifier' ),
							),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /filter

						'scroll' => array(
							'type' => 'text',
							//description
							'label' => esc_html__( 'Scrolling', 'webman-amplifier' ),
							'help'  => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /scroll

						'tag' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Tagged as', 'webman-amplifier' ),
							'help'  => esc_html__( 'Display specifically tagged items only', 'webman-amplifier' ),
							//type specific
							'options' => $content_module_tags,
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /tag

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

						'layout' => array(
							'type' => 'text',
							//description
							'label'       => esc_html__( 'Custom layout', 'webman-amplifier' ),
							'description' => '<br />' . sprintf( esc_html__( 'Set the custom layout of the output. Order the predefined items (%s) separated with comma (no spaces).', 'webman-amplifier' ), '<code>content,image,morelink,tag,title</code>' ),
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /layout

					), // /fields
				), // /section

			), // /sections
		), // /tab

	),
	'compatibility/wpml' => array(
		array(
			'field'       => 'module',
			'type'        => esc_html__( 'Single module display', 'webman-amplifier' ),
			'editor_type' => 'LINE',
		),
		array(
			'field'       => 'tag',
			'type'        => esc_html__( 'Tagged as', 'webman-amplifier' ),
			'editor_type' => 'LINE',
		),
		array(
			'field'       => 'content',
			'type'        => esc_html__( 'Content', 'webman-amplifier' ),
			'editor_type' => 'VISUAL',
		),
	),
);
