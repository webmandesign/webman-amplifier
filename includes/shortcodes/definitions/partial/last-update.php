<?php
/**
 * Shortcode definitions array partial: [last_update]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
$definitions['last_update'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Last Update Time', 'webman-amplifier' ),
		'code'  => '[PREFIX_last_update post_type="' . implode( '/', array_merge( array( 'post', 'page' ), get_post_types( array( '_builtin' => false ) ) ) ) . '" format="" class="" /]',
		'short' => true,
	),
);
