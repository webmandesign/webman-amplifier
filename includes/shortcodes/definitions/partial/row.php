<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [row]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['row'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Row', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_row'
				. ' bg_attachment=""'
				. ' bg_color=""'
				. ' bg_image=""'
				. ' bg_position=""'
				. ' bg_repeat=""'
				. ' bg_size=""'
				. ' class=""'
				. ' font_color=""'
				. ' id=""'
				. ' margin=""'
				. ' padding=""'
				. ' parallax=""'
			. ']'
				. '{{content}}'
			. '[/PREFIX_row]',
		'short' => false,
	),
);
