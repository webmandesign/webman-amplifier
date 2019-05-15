<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [posts]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['posts'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Posts / Custom Posts', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_posts'
				. ' class=""'
				. ' columns="4"'
				. ' count="8"'
				. ' filter="taxonomy_key"'
				. ' image_size=""'
				. ' layout=""'
				. ' no_margin="0/1"'
				. ' order="new/old/name/random"'
				. ' pagination="0/1"'
				. ' post_type="' . implode( '/', array_keys( wma_ksort( $helpers['post_types'] ) ) ) . '" align="left/right"'
				. ' related="0/1"'
				. ' scroll="0"'
				. ' taxonomy="taxonomy_key:term-slug"'
			. ']'
				. '{{content}}'
			. '[/PREFIX_posts]',
		'short' => false,
	),
);
