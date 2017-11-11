<?php if ( ! defined( 'ABSPATH' ) ) exit;

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





$definitions['divider'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name' => esc_html__( 'Divider / Gap', 'webman-amplifier' ),
		'code' =>
			'[PREFIX_divider'
				. ' appearance="' . implode( '/', array_keys( wma_ksort( $helpers['divider_appearance'] ) ) ) . '"'
				. ' class=""'
				. ' space_after=""'
				. ' space_before=""'
			. ' /]',
		'short' => true,
	),
);
