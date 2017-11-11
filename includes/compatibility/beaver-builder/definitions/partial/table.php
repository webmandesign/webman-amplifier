<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [table]
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
	'appearance',
	'class',
	'content',
	'separator',
);

$definitions['table']['bb_plugin'] = array(
	'name'   => esc_html__( 'Table', 'webman-amplifier' ),
	'output' => '[PREFIX_table{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}}]{{content}}[/PREFIX_table]',
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

						'appearance' => array(
							'type'    => 'select',
							'label'   => esc_html__( 'Appearance', 'webman-amplifier' ),
							'options' => $helpers['table_appearance'],
							'preview' => array( 'type' => 'refresh' ),
						),

						'separator' => array(
							'type'    => 'text',
							'label'   => esc_html__( 'CSV data separator', 'webman-amplifier' ),
							'default' => ',',
							'preview' => array( 'type' => 'none' ),
						),

					),
				),

				'content' => array(
					'title'  => esc_html__( 'CSV data', 'webman-amplifier' ),
					'fields' => array(

						'content' => array(
							'type'    => 'editor',
							'label'   => '',
							'default' => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
							'preview' => array( 'type' => 'none' ),
						),

					),
				),

			),
		),

	),
	'compatibility/wpml' => array(
		array(
			'field'       => 'content',
			'type'        => esc_html__( 'CSV data', 'webman-amplifier' ),
			'editor_type' => 'VISUAL',
		),
		array(
			'field'       => 'separator',
			'type'        => esc_html__( 'CSV data separator', 'webman-amplifier' ),
			'editor_type' => 'LINE',
		),
	),
);
