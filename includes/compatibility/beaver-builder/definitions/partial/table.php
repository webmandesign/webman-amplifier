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

						'appearance' => array(
							'type' => 'select',
							//description
							'label' => esc_html__( 'Appearance', 'webman-amplifier' ),
							//type specific
							'options' => $helpers['table_appearance'],
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /appearance

						'separator' => array(
							'type' => 'text',
							//description
							'label' => esc_html__( 'CSV data separator', 'webman-amplifier' ),
							//default
							'default' => ',',
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /separator

					), // /fields
				), // /section

				//Section
				'content' => array(
					'title'  => esc_html__( 'CSV data', 'webman-amplifier' ),
					'fields' => array(

						'content' => array(
							'type' => 'editor',
							//description
							'label' => '',
							//default
							'default' => "Column 1, Colum 2, Column 3\r\nValue 1, Value 2, Value 3",
							//preview
							'preview' => array( 'type' => 'none' ),
						), // /content

					), // /fields
				), // /section

			), // /sections
		), // /tab

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
