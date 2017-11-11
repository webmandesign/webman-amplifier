<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [tabs]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$i = 0;

$definitions['tabs'] = array(
	'since'     => '1.0.0',
	'generator' => array(
		'name'  => esc_html__( 'Tabs', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_tabs'
				. ' active="0"'
				. ' class=""'
				. ' layout="top/left/right"'
				. ' tour="0/1"'
			. ']'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

				. '[PREFIX_item'
					. ' heading_tag=""'
					. ' icon=""'
					/* translators: %d: tab order number. */
					. ' title="' . sprintf( esc_html__( 'Tab %d', 'webman-amplifier' ), ++$i ) . '"'
				. ']'
					. '{{content}}'
				. '[/PREFIX_item]'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

				. '[PREFIX_item'
					. ' heading_tag=""'
					. ' icon=""'
					/* translators: %d: tab order number. */
					. ' title="' . sprintf( esc_html__( 'Tab %d', 'webman-amplifier' ), ++$i ) . '"'
				. ']'
					. '{{content}}'
				. '[/PREFIX_item]'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

			. '[/PREFIX_tabs]',
		'short' => false,
	),
);
