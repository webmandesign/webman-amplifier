<?php
/**
 * Shortcode definitions array partial: [icon]
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
$social_icons = $helpers['social_icons'];
array_push(
	$social_icons,
	'',
	'background-light',
	'background-dark'
);
asort( $social_icons );

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
$social_icons = array_combine(
	$social_icons, // keys
	$social_icons // values
);

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- not global
$definitions['icon'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Icon / Social Icon', 'webman-amplifier' ),
		'code'  => '[PREFIX_icon class="icon-class" social="' . implode( '/', $social_icons ) . '" url="" size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '" /]',
		'short' => true,
	),
);
