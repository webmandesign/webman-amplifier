<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: [column]
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

$definitions['column']['generator']['code'] =
	'[vc_column'
		. ' bg_attachment=""'
		. ' bg_color=""'
		. ' bg_image=""'
		. ' bg_position=""'
		. ' bg_repeat=""'
		. ' bg_size=""'
		. ' class=""'
		. ' font_color=""'
		. ' id=""'
		. ' padding=""'
		. ' width="1/1,1/2,1/3,2/3,1/4,3/4,1/6,5/6"'
	. ']'
		. '{{content}}'
	. '[/vc_column]';
