<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [video]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['video'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Video', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_video'
				. ' autoplay="0/1"'
				. ' class=""'
				. ' loop="0/1"'
				. ' poster=""'
				. ' src=""'
			. ' /]',
		'short' => false,
	),
);
