<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Beaver Builder module definitions array partial: [divider]
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
);

$definitions['divider'][ $key ] = array(
	'name'   => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
	'output' => '[PREFIX_divider{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}} /]',
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
							'options' => $helpers['divider_appearance'],
							'preview' => array( 'type' => 'refresh' ),
						),

					),
				),

			),
		),

	),
);
