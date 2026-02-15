<?php
/**
 * Shortcode definitions array partial: [list]
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
$definitions['list'] = array(
	'since'  => '1.0',
	'preprocess' => false,
	'generator' => array(
		'name'  => esc_html__( 'Icon List', 'webman-amplifier' ),
		'code'  => '[PREFIX_list bullet="icon-class" class=""]<ul><li>{{content}}</li><li>' . esc_html__( 'List item', 'webman-amplifier' ) . '</li></ul>[/PREFIX_list]',
		'short' => true,
	),
);
