<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [testimonials]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$testimonials_slugs = wma_posts_array( 'post_name', 'wm_testimonials' );
$testimonials_cats  = wma_taxonomy_array( array(
	'all_post_type' => '',
	'all_text'      => '-',
	'hierarchical'  => '0',
	'tax_name'      => 'testimonial_category'
) );



$definitions['testimonials'] = array(
	'since' => '1.0',
	'post_type_required' => 'wm_testimonials',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Testimonials', 'webman-amplifier' ),
		'code'  => '[PREFIX_testimonials testimonial="testimonial-slug" align="left/right" columns="4" count="8" order="new/old/name/random" category="optional-category-slug" scroll="0" pagination="0/1" no_margin="0/1" class=""]{{content}}[/PREFIX_testimonials]',
		'short' => false,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Testimonials', 'webman-amplifier' ),
		'output' => '[PREFIX_testimonials{{testimonial}}{{align}}{{columns}}{{count}}{{order}}{{category}}{{scroll}}{{pagination}}{{no_margin}}{{heading_tag}}{{class}}]{{content}}[/PREFIX_testimonials]',
		'params' => array( 'testimonial', 'align', 'columns', 'count', 'order', 'category', 'scroll', 'pagination', 'no_margin', 'heading_tag', 'class', 'content' ),
		'wpml_fields' => array(
			array(
				'field'       => 'testimonial',
				'type'        => esc_html__( 'Single testimonial', 'webman-amplifier' ),
				'editor_type' => 'LINE',
			),
			array(
				'field'       => 'category',
				'type'        => esc_html__( 'From category', 'webman-amplifier' ),
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
					'single' => array(
						'title'  => esc_html__( 'Single testimonial display', 'webman-amplifier' ),
						'fields' => array(

							'testimonial' => array(
								'type' => 'select',
								//description
								'label' => esc_html__( 'Single testimonial', 'webman-amplifier' ),
								'help'  => esc_html__( 'Leave empty to display multiple testimonials', 'webman-amplifier' ),
								//type specific
								'options' => $testimonials_slugs,
								//preview
								'preview' => array( 'type' => 'refresh' ),
							), // /testimonial

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

							'scroll' => array(
								'type' => 'text',
								//description
								'label' => esc_html__( 'Scrolling', 'webman-amplifier' ),
								'help'  => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
								//preview
								'preview' => array( 'type' => 'refresh' ),
							), // /scroll

							'category' => array(
								'type' => 'select',
								//description
								'label' => esc_html__( 'From category', 'webman-amplifier' ),
								'help'  => esc_html__( 'Displays items only from a specific category', 'webman-amplifier' ),
								//type specific
								'options' => $testimonials_cats,
								//preview
								'preview' => array( 'type' => 'refresh' ),
							), // /category

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
		'name'     => $prefix['name'] . esc_html__( 'Testimonials', 'webman-amplifier' ),
		'base'     => $prefix['code'] . 'testimonials',
		'class'    => 'wm-shortcode-vc-testimonials',
		'icon'     => 'vc_icon-vc-gitem-post-title',
		'category' => esc_html__( 'Content', 'webman-amplifier' ),
		'params'   => array(
			10 => array(
				'heading'     => esc_html__( 'Single testimonial', 'webman-amplifier' ),
				'description' => esc_html__( 'Leave empty to display multiple testimonials', 'webman-amplifier' ),
				'type'        => 'dropdown',
				'param_name'  => 'testimonial',
				'value'       => array_flip( $testimonials_slugs ), // 1st value is empty
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
				'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),
			30 => array(
				'heading'    => esc_html__( 'Columns', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'columns',
				'value'      => array(
					'' => '', // prevent forcing 1
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4,
					5  => 5,
					6  => 6,
				),
				'holder'     => 'hidden',
				'class'      => '',
				'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
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
				'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),
			50 => array(
				'heading'     => esc_html__( 'Scrolling', 'webman-amplifier' ),
				'description' => esc_html__( 'Set 1-999 for manual scrolling, set 1000+ for automatic scrolling. The value for automatic scrolling represents the time of a scroll in miliseconds. Leave empty to disable scrolling.', 'webman-amplifier' ),
				'type'        => 'textfield',
				'param_name'  => 'scroll',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),
			60 => array(
				'heading'     => esc_html__( 'Category', 'webman-amplifier' ),
				'description' => esc_html__( 'Displays items only from a specific category', 'webman-amplifier' ),
				'type'        => 'dropdown',
				'param_name'  => 'category',
				'value'       => array_flip( $testimonials_cats ), // 1st value is empty
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),
			70 => array(
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
				'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),
			80 => array(
				'heading'     => esc_html__( 'Description text (HTML)', 'webman-amplifier' ),
				'description' => '',
				'type'        => 'textarea',
				'param_name'  => 'content',
				'value'       => '',
				'holder'      => 'hidden',
				'class'       => '',
				'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),
			90 => array(
				'heading'    => esc_html__( 'Description alignment', 'webman-amplifier' ),
				'type'       => 'dropdown',
				'param_name' => 'align',
				'value'      => array(
					esc_html__( 'Left', 'webman-amplifier' )  => 'left', // default
					esc_html__( 'Right', 'webman-amplifier' ) => 'right',
				),
				'holder'     => 'hidden',
				'class'      => '',
				'group'      => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),
			100 => array(
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
				'group'       => esc_html__( 'Multiple display', 'webman-amplifier' ),
			),

			110 => array(
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
