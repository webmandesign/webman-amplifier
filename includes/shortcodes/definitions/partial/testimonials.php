<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [testimonials]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





if ( ! post_type_exists( 'wm_testimonials' ) ) {
	return;
}

$definitions['testimonials'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Testimonials', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_testimonials'
				. ' align="left/right"'
				. ' category="optional-category-slug"'
				. ' class=""'
				. ' columns="4"'
				. ' count="8"'
				. ' no_margin="0/1"'
				. ' order="new/old/name/random"'
				. ' pagination="0/1"'
				. ' scroll="0"'
				. ' testimonial="testimonial-slug"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_testimonials]',
		'short' => false,
	),
);
