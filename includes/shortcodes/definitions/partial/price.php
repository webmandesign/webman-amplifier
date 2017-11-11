<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [price]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['price'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Price', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_price'
				. ' appearance="default/featured/legend"'
				. ' caption="' . esc_html__( 'Title', 'webman-amplifier' ) . '"'
				. ' class=""'
				. ' color=""'
				. ' color_text=""'
				. ' cost="99$"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_price]',
		'short' => false,
	),
);
