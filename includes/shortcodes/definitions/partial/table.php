<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [table]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$definitions['table'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Table', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_table'
				. ' appearance="' . implode( '/', array_keys( wma_ksort( $helpers['table_appearance'] ) ) ) . '"'
				. ' class=""'
				. ' separator=","'
			. ']'
				. '{{content}}'
			. '[/PREFIX_table]',
		'short' => false,
	),
);
