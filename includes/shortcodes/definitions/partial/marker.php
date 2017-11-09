<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [marker]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['marker'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Marker', 'webman-amplifier' ),
		'code'  => '[PREFIX_marker color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '" class=""]{{content}}[/PREFIX_marker]',
		'short' => true,
	),
);
