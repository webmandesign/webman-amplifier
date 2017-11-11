<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [separator_heading]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['separator_heading'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Separator Heading', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_separator_heading'
				. ' align="' . implode( '/', array( 'left', 'center', 'right' ) ) . '"'
				. ' class=""'
				. ' id=""'
				. ' tag="' . implode( '/', array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) ) . '"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_separator_heading]',
		'short' => true,
	),
	'preprocess' => true,
);
