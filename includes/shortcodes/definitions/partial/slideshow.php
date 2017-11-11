<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [slideshow]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['slideshow'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Slideshow', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_slideshow'
				. ' class=""'
				. ' ids=""'
				. ' nav="none/thumbs/pagination"'
				. ' size="full/' . implode( '/', get_intermediate_image_sizes() ) . '"'
				. ' speed="3000"'
			. ' /]',
		'short' => false,
	),
);
