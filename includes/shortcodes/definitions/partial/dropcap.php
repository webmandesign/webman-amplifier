<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [dropcap]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['dropcap'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name' => esc_html__( 'Dropcap', 'webman-amplifier' ),
		'code' => '[PREFIX_dropcap color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" shape="' . implode( '/', array_keys( wma_ksort( $helpers['dropcap_shapes'] ) ) ) . '" class=""]{{content}}[/PREFIX_dropcap]',
		'short' => true,
	),
);
