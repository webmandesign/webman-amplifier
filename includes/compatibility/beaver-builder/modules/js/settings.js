/**
 * Custom Beaver Builder module settings scripts
 *
 * This works as a global `settings.js` file for all custom modules.
 *
 * @package     WebMan Amplifier
 * @subpackage  Compatibility
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.1.0
 * @version  1.6.0
 *
 * Contents:
 *
 * 10) Required fields
 */





( function( $ ) {





	/**
	 * 10) Required fields
	 */

		FLBuilder.registerModuleHelper( 'wm_button', {
			rules : {
				content : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'wm_table', {
			rules : {
				content : {
					required : true
				},
				separator : {
					required : true
				}
			}
		} );





} )( jQuery );
