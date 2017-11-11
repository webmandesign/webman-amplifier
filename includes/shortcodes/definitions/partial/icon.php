<?php if ( ! defined( 'ABSPATH' ) ) exit;

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





$social_icons = $helpers['social_icons'];
array_push(
	$social_icons,
	'',
	'background-light',
	'background-dark'
);
asort( $social_icons );
$social_icons = array_combine(
	$social_icons, // keys
	$social_icons // values
);

$definitions['icon'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Icon / Social Icon', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_icon'
				. ' class="icon-class"'
				. ' size="' . implode( '/', array_keys( wma_ksort( $helpers['sizes']['options'] ) ) ) . '"'
				. ' social="' . implode( '/', $social_icons ) . '"'
				. ' url=""'
			. ' /]',
		'short' => true,
	),
	'preprocess' => true,
);
