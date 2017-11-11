<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [column]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['column'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Column', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_column'
				. ' bg_attachment=""'
				. ' bg_color=""'
				. ' bg_image=""'
				. ' bg_position=""'
				. ' bg_repeat=""'
				. ' bg_size=""'
				. ' class=""'
				. ' font_color=""'
				. ' id=""'
				. ' last="0/1"'
				. ' padding=""'
				. ' width="' . implode( ',', $helpers['column_widths'] ) . '"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_column]',
		'short' => false,
	),
);
