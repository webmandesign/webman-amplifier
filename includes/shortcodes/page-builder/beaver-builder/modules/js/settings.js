/**
 * Custom Beaver Builder module settings scripts
 *
 * This works as a global `settings.js` file for all custom modules.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.1
 * @version  1.1
 */



jQuery( function() {



	/**
	 * Required fields
	 */

		FLBuilder.registerModuleHelper( 'button', {
			rules : {
				content : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'call_to_action', {
			rules : {
				content : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'countdown_timer', {
			rules : {
				time : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'icon', {
			rules : {
				icon : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'list', {
			rules : {
				content : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'message', {
			rules : {
				content : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'progress', {
			rules : {
				content : {
					required : true
				},
				progress : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'separator_heading', {
			rules : {
				content : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'slideshow', {
			rules : {
				ids : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'table', {
			rules : {
				content : {
					required : true
				},
				separator : {
					required : true
				}
			}
		} );

		FLBuilder.registerModuleHelper( 'widget_area', {
			rules : {
				area : {
					required : true
				}
			}
		} );



} );