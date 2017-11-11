<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [content_module]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





if ( ! post_type_exists( 'wm_modules' ) ) {
	return;
}

$definitions['content_module'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Content Module', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_content_module'
				. ' align="left/right"'
				. ' class=""'
				. ' columns="4"'
				. ' count="8"'
				. ' filter="0/1"'
				. ' image_size=""'
				. ' layout=""'
				. ' module="module-slug"'
				. ' no_margin="0/1"'
				. ' order="new/old/name/random"'
				. ' pagination="0/1"'
				. ' scroll="0"'
				. ' tag=""'
			. ']'
				. '{{content}}'
			. '[/PREFIX_content_module]',
		'short' => false,
	),
);
