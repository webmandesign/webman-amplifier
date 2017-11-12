<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WPBakery Page Builder element definitions array partial: Page builder related
 *
 * Setting up shortcode aliases for this page builder.
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

$definitions['vc_row'] = array(
	'since'         => '1.0',
	'custom_prefix' => '',
	'renderer'      => array(
		'alias' => 'row',
	),
);

$definitions['vc_row_inner'] = array(
	'since'         => '1.0',
	'custom_prefix' => '',
	'renderer'      => array(
		'alias' => 'row',
	),
);

$definitions['vc_column'] = array(
	'since'         => '1.0',
	'custom_prefix' => '',
	'renderer'      => array(
		'alias' => 'column',
	),
);

$definitions['vc_column_inner'] = array(
	'since'         => '1.0',
	'custom_prefix' => '',
	'renderer'      => array(
		'alias' => 'column',
	),
);
