<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode definitions array partial: [accordion]
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.5.0
 * @version  1.6.0
 */





$i = 0;

$definitions['accordion'] = array(
	'since'      => '1.0.0',
	'preprocess' => false,
	'generator'  => array(
		'name'  => esc_html__( 'Accordion', 'webman-amplifier' ),
		'code'  =>
			'[PREFIX_accordion'
				. ' active="0"'
				. ' class=""'
				. ' filter="0/1"'
				. ' mode="accordion/toggle"'
			. ']'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

				. '[PREFIX_item'
					. ' heading_tag=""'
					. ' icon=""'
					. ' tags=""'
					/* translators: %d: section order number. */
					. ' title="' . sprintf( esc_html__( 'Section %d', 'webman-amplifier' ), ++$i ) . '"'
				. ']'
					. '{{content}}'
				. '[/PREFIX_item]'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

				. '[PREFIX_item'
					. ' heading_tag=""'
					. ' icon=""'
					. ' tags=""'
					/* translators: %d: section order number. */
					. ' title="' . sprintf( esc_html__( 'Section %d', 'webman-amplifier' ), ++$i ) . '"'
				. ']'
					. '{{content}}'
				. '[/PREFIX_item]'

				. '<br>' // Simple "\r\n" line break wouldn't work in TinyMCE.

			. '[/PREFIX_accordion]',
		'short' => false,
	),
);
