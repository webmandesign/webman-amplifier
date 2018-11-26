<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [pre]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.5.0
 */





$definitions['pre'] = array(
	'since' => '1.0',
	'preprocess' => true,
	'generator' => array(
		'name'  => esc_html__( 'Preformated Text', 'webman-amplifier' ),
		'code'  => '[PREFIX_pre]{{content}}[/PREFIX_pre]',
		'short' => true,
	),
);
