<?php
/**
 * Shortcode definitions array partial: [video]
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
$definitions['video'] = array(
	'since' => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Video', 'webman-amplifier' ),
		'code'  => '[PREFIX_video src="" poster="" autoplay="0/1" loop="0/1" class="" /]',
		'short' => false,
	),
);
