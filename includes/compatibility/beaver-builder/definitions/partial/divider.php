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

$definitions['divider']['bb_plugin'] = array(
	'name'   => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
	'output' => '[PREFIX_divider{{' . implode( '}}{{', array_diff( $params, array( 'content' ) ) ) . '}} /]',
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
							'options' => $helpers['divider_appearance'],
							//preview
							'preview' => array( 'type' => 'refresh' ),
						), // /appearance

					), // /fields
				), // /section

			), // /sections
		), // /tab

	),
);
