<?php
/**
 * Shortcode definitions array partial: [divider]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
$definitions['divider'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name' => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
		'code' => '[PREFIX_divider appearance="' . implode( '/', array_keys( wma_ksort( $helpers['divider_appearance'] ) ) ) . '" space_before="" space_after="" class="" /]',
		'short' => true,
	),
	'bb_plugin' => array(
		'name' => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
		'output' => '[PREFIX_divider{{appearance}}{{class}} /]',
		'params' => array( 'appearance', 'class' ),
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
	),
);
