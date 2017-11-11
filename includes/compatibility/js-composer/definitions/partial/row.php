<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [row]
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.0
 */





if (
	! is_callable( 'WM_Amplifier_JS_Composer::is_active' )
	|| ! WM_Amplifier_JS_Composer::is_active()
) {
	return;
}

$definitions['row']['generator']['code'] =
	'[vc_row'
		. ' bg_attachment=""'
		. ' bg_color=""'
		. ' bg_image=""'
		. ' bg_position=""'
		. ' bg_repeat=""'
		. ' bg_size=""'
		. ' class=""'
		. ' font_color=""'
		. ' id=""'
		. ' margin=""'
		. ' padding=""'
		. ' parallax=""'
	. ']'
		. '{{content}}'
	. '[/vc_row]';
