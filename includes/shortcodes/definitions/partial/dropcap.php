<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [dropcap]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['dropcap'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name' => esc_html__( 'Dropcap', 'webman-amplifier' ),
		'code' =>
			'[PREFIX_dropcap'
				. ' class=""'
				. ' color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '"'
				. ' shape="' . implode( '/', array_keys( wma_ksort( $helpers['dropcap_shapes'] ) ) ) . '"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_dropcap]',
		'short' => true,
	),
	'preprocess' => true,
);
