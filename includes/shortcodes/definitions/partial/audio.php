<?php
/**
 * Shortcode definitions array partial: [audio]
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
$definitions['audio'] = array(
	'since'  => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Audio', 'webman-amplifier' ),
		'code'  => '[PREFIX_audio src="" autoplay="0/1" loop="0/1" class="" /]',
		'short' => false,
	),
);
