<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [marker]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['marker'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Marker', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_marker'
				. ' class=""'
				. ' color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_marker]',
		'short' => true,
	),
	'preprocess' => true,
);
