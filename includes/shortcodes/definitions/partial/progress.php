<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [progress]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['progress'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Progress Bar', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_progress'
				. ' class=""'
				. ' color="' . implode( '/', array_keys( wma_ksort( $helpers['colors'] ) ) ) . '"'
				. ' progress="75"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_progress]',
		'short' => false,
	),
);
