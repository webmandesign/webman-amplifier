<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [posts]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.8
 */





$taxonomies = get_taxonomies( '', 'names' );
unset( $taxonomies['nav_menu'] );
unset( $taxonomies['link_category'] );
asort( $taxonomies );



$definitions['posts'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
		'code'  => '[PREFIX_posts post_type="' . implode( '/', array_keys( wma_ksort( $helpers['post_types'] ) ) ) . '" align="left/right" columns="4" count="8" image_size="" order="new/old/name/random" taxonomy="taxonomy_key:term-slug" filter="taxonomy_key" scroll="0" pagination="0/1" related="0/1" no_margin="0/1" layout="" class=""]{{content}}[/PREFIX_posts]',
		'short' => false,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
		'output' => '[PREFIX_posts{{post_type}}{{align}}{{columns}}{{count}}{{order}}{{taxonomy}}{{image_size}}{{filter}}{{scroll}}{{pagination}}{{related}}{{no_margin}}{{heading_tag}}{{class}}]{{content}}[/PREFIX_posts]',
		'params' => array( 'post_type', 'align', 'columns', 'count', 'order', 'taxonomy', 'image_size', 'filter', 'scroll', 'pagination', 'related', 'no_margin', 'heading_tag', 'class', 'content' ),
		'wpml_fields' => array(
			array(
				'field'       => 'taxonomy',
				'type'        => esc_html__( 'From taxonomy', 'webman-amplifier' ),
				'editor_type' => 'LINE',
			),
			array(
				'field'       => 'filter',
				'type'        => esc_html__( 'Animated filter', 'webman-amplifier' ),
				'editor_type' => 'LINE',
			),
			array(
				'field'       => 'content',
				'type'        => esc_html__( 'Content', 'webman-amplifier' ),
				'editor_type' => 'VISUAL',
			),
		),
		'form' => array(

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
								'description' => '<span style="display: block;">'
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
								//preview
								'preview' => array( 'type' => 'refresh' ),
							), // /taxonomy

							'filter' => array(
								'type' => 'text',
								//description
								'label'       => esc_html__( 'Animated filter', 'webman-amplifier' ),
								'description' => '<span style="display: block;">'
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
	),
	'vc_plugin' => array(
		'name'     => $prefix['name'] . esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'posts',
		'class'    => 'wm-shortcode-vc-posts',
		'icon'     => 'icon-wpb-vc_carousel',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Post type', 'webman-amplifier' ),
				'description' => esc_html__( 'This shortcode can display several post types. Choose the one you want to display.', 'webman-amplifier' ),
				'type'        => 'dropdown',
				'param_name'  => 'post_type',
				'value'       => array( '' => '' ) + array_flip( $helpers['post_types'] ),
				'holder'      => 'div',
				'class'       => '',
			),
			20 => array(
				'heading'     => esc_html__( 'Count', 'webman-amplifier' ),
				'description' => esc_html__( 'Number of items to display', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'count',
				'value'       => 3,
				'holder'      => 'hidden',
				'class'       => '',
			),
			30 => array(
				'heading'    => esc_html__( 'Columns', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'columns',
				'value'      => array(
					'' => '', // prevent forcing 1 as default
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4,
					5  => 5,
					6  => 6,
				),
				'holder'     => 'hidden',
				'class'      => '',
			),
			40 => array(
				'heading'    => esc_html__( 'Order', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'order',
				'value'      => array(
					esc_html__( 'Newest first', 'webman-amplifier' )       => 'new', // default
					esc_html__( 'Oldest first', 'webman-amplifier' )       => 'old',
					esc_html__( 'By name', 'webman-amplifier' )            => 'name',
					esc_html__( 'Randomly', 'webman-amplifier' )           => 'random',
					esc_html__( 'Custom, ascending', 'webman-amplifier' )  => 'menuasc',
					esc_html__( 'Custom, descending', 'webman-amplifier' ) => 'menudesc',
				),
				'holder'     => 'hidden',
				'class'      => '',
			),

			50 => array(
				'heading'     => esc_html__( 'Taxonomy', 'webman-amplifier' ),
				'description' => esc_html__( 'Displays items only from a specific taxonomy. Set a taxonomy name and taxonomy slug separated with colon.', 'webman-amplifier' ) . '<br />' . esc_html__( 'For example: "category:category-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $taxonomies ) . '</code>',
				'type'        => 'textfield',
				'param_name'  => 'taxonomy',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Taxonomy', 'webman-amplifier' ),
			),
			60 => array(
				'heading'     => esc_html__( 'Relation', 'webman-amplifier' ),
				'description' => esc_html__( 'Use only on single post/custom post pages. Displays items related to recently displayed item through a specific taxonomy. Set a taxonomy name only.', 'webman-amplifier' ) . ' ' . esc_html__( 'For example: "category".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $taxonomies ) . '</code>',
				'type'        => 'textfield',
				'param_name'  => 'related',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Taxonomy', 'webman-amplifier' ),
			),

			70 => array(
				'heading'     => esc_html__( 'Filter', 'webman-amplifier' ),
				'description' => esc_html__( 'If set, the items will be filtered. Set a taxonomy name (and optional parent taxonomy slug separated with colon - filter will be created from sub-taxonomies) which will be used to filter the items.', 'webman-amplifier' ) . '<br />' . esc_html__( 'For example: "category" or "category:parent-category-slug".', 'webman-amplifier' ) . '<br />' . esc_html__( 'Available taxonomy names:', 'webman-amplifier' ) . ' <code>' . implode( '</code>, <code>', $taxonomies ) . '</code>',
				'type'        => 'textfield',
				'param_name'  => 'filter',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
			),
			80 => array(
				'heading'     => esc_html__( 'Filter layout', 'webman-amplifier' ),
				'description' => sprintf( esc_html__( 'Use one of <a%s>Isotope</a> layouts.', 'webman-amplifier' ), ' href="http://isotope.metafizzy.co/layout-modes.html" target="_blank"' ) . ' ' . esc_html__( 'Default is set to <code>fitRows</code>.', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'filter_layout',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
			),
			90 => array(
				'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
				'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'scroll',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Filter / Scroll', 'webman-amplifier' ),
			),

			100 => array(
				'heading'     => esc_html__( 'Display pagination?', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'pagination',
				'value'       => array(
					esc_html__( 'No', 'webman-amplifier' )  => '',
					esc_html__( 'Yes', 'webman-amplifier' ) => 1,
				),
				'holder'      => 'hidden',
				'class'       => '',
			),

			110 => array(
				'heading'     => esc_html__( 'Description text', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textarea_html',
				'param_name'  => 'content',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Description', 'webman-amplifier' ),
			),
			120 => array(
				'heading'     => esc_html__( 'Description alignment', 'webman-amplifier' ),
				'type'        => 'dropdown',
				'param_name'  => 'align',
				'value'       => array(
					esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
					esc_html__( 'Right', 'webman-amplifier' ) => 'right',
				),
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Description', 'webman-amplifier' ),
			),

			130 => array(
				'heading'     => esc_html__( 'Remove gap between items?', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'dropdown',
				'param_name'  => 'no_margin',
				'value'       => array(
					esc_html__( 'No', 'webman-amplifier' )  => '',
					esc_html__( 'Yes', 'webman-amplifier' ) => 1,
				),
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Layout', 'webman-amplifier' ),
			),
			140 => array(
				'heading'    => esc_html__( 'Image size', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'image_size',
				'value'      => wma_asort( array( '' => '' ) + array_flip( wma_get_image_sizes() ) ),
				'holder'     => 'hidden',
				'class'      => '',
				'group'      => esc_html__( 'Layout', 'webman-amplifier' ),
			),

			150 => array(
				'heading'     => esc_html__( 'CSS class', 'webman-amplifier' ),
				'description' => esc_html__( 'Optional CSS additional classes', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'class',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
			),
		),
	),
);
