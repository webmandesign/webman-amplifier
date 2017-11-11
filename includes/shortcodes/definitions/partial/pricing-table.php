<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [pricing_table]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$i = 0;

$definitions['pricing_table'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Pricing Table', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_pricing_table'
				. ' class=""'
				. ' no_margin="0/1"'
			. ']'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

				. '[PREFIX_price'
					. ' appearance="NONE/featured/legend"'
					/* translators: %d: Pricing table item (price) order number. */
					. ' caption="' . sprintf( esc_html__( 'Price %d', 'webman-amplifier' ), ++$i ) . '"'
					. ' class=""'
					. ' color=""'
					. ' color_text=""'
					. ' cost=""'
					. ' heading_tag=""'
				. ' ]'
					. '{{content}}'
				. '[/PREFIX_price]'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

				. '[PREFIX_price'
					. ' appearance="NONE/featured/legend"'
					/* translators: %d: Pricing table item (price) order number. */
					. ' caption="' . sprintf( esc_html__( 'Price %d', 'webman-amplifier' ), ++$i ) . '"'
					. ' class=""'
					. ' color=""'
					. ' color_text=""'
					. ' cost=""'
					. ' heading_tag=""'
				. ' ]'
					. '{{content}}'
				. '[/PREFIX_price]'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

			. '[/PREFIX_pricing_table]',
		'short' => false,
	),
);
