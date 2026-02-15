<?php
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

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
$definitions['slideshow'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Slideshow', 'webman-amplifier' ),
		'code'  => '[PREFIX_slideshow ids="" nav="none/thumbs/pagination" size="full/' . implode( '/', get_intermediate_image_sizes() ) . '" speed="3000" class="" /]',
		'short' => false,
	),
);
