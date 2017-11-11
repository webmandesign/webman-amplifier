<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [item]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['item'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Item (Accordion or Tab Section)', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_item'
				. ' heading_tag=""'
				. ' icon=""'
				. ' tags=""'
				. ' title="' . esc_html__( 'Title', 'webman-amplifier' ) . '"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_item]',
		'short' => false,
	),
);
