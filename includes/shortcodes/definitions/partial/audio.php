<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [audio]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['audio'] = array(
	'since'      => '1.0.0',
	'preprocess' => false,
	'generator'  => array(
		'name'  => esc_html__( 'Audio', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_audio'
				. ' autoplay="0/1"'
				. ' class=""'
				. ' loop="0/1"'
				. ' src=""'
			. ' /]',
		'short' => false,
	),
);
