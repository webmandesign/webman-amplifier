/**
 * WebMan Shortcode Generator button
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */



( function() {

	tinymce.create( 'tinymce.plugins.wmShortcodes', {

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function( n, cm ) {

			//Shortcode Generator
			if ( 'wm_shortcodes_list' == n ) {

				var c = cm.createSplitButton( 'wm_shortcodes_list', {
				    		title : 'Shortcode'
				    	} );

				c.onRenderMenu.add( function( c, m ) {
					//Add menu button items
					wmShortcodesArray = ( 'undefined' === typeof wmShortcodesArray ) ? ( [{name:'Shortcode',code:'',class:''}] ) : ( wmShortcodesArray );
					for ( var i in wmShortcodesArray ) {
						m.add( {
							title   : wmShortcodesArray[i]['name'],
							id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + wmShortcodesArray[i]['class'],
							class   : wmShortcodesArray[i]['class'],
							onclick : function( v ) { //Pass the whole menu button item object
									var menuId = jQuery( v ).attr( 'id' );
									    menuId = parseInt( menuId.substring( 2, 4 ) );
									//Retrieve the shortcode content based on menu button item ID pressed
									if ( '' != tinyMCE.activeEditor.selection.getContent() ) {
										var shortcodeOutput = wmShortcodesArray[menuId]['code'].replace( '{{content}}', tinyMCE.activeEditor.selection.getContent() );
										tinyMCE.activeEditor.selection.setContent( shortcodeOutput );
									} else {
										var shortcodeOutput = wmShortcodesArray[menuId]['code'].replace( '{{content}}', 'TEXT' );
										tinyMCE.activeEditor.selection.setContent( shortcodeOutput );
									}
								}
						} );
					}
				} );

				//Return the new listbox instance
					return c;

			}

			//Shortcode Generator for Visual Composer plugin
			if ( 'wm_shortcodes_list_vc' == n && 'undefined' != typeof wmShortcodesArrayVC ) {

				var c = cm.createSplitButton( 'wm_shortcodes_list_vc', {
				    		title : 'Shortcode'
				    	} );

				c.onRenderMenu.add( function( c, m ) {
					//Add menu button items
					for ( var i in wmShortcodesArrayVC ) {
						m.add( {
							title   : wmShortcodesArrayVC[i]['name'],
							id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + wmShortcodesArrayVC[i]['class'],
							class   : wmShortcodesArrayVC[i]['class'],
							onclick : function( v ) { //Pass the whole menu button item object
									var menuId = jQuery( v ).attr( 'id' );
									    menuId = parseInt( menuId.substring( 2, 4 ) );
									//Retrieve the shortcode content based on menu button item ID pressed
									if ( '' != tinyMCE.activeEditor.selection.getContent() ) {
										var shortcodeOutput = wmShortcodesArrayVC[menuId]['code'].replace( '{{content}}', tinyMCE.activeEditor.selection.getContent() );
										tinyMCE.activeEditor.selection.setContent( shortcodeOutput );
									} else {
										var shortcodeOutput = wmShortcodesArrayVC[menuId]['code'].replace( '{{content}}', 'TEXT' );
										tinyMCE.activeEditor.selection.setContent( shortcodeOutput );
									}
								}
						} );
					}
				} );

				//Return the new listbox instance
					return c;

			}

			return null;

		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {

			return {
				longname  : 'Shortcode Generator',
				author    : 'WebMan - www.webmandesign.eu',
				authorurl : 'http://www.webmandesign.eu',
				infourl   : '',
				version   : '1.0'
			};

		}

	} );

	//Register plugin
		tinymce.PluginManager.add( 'wmShortcodes', tinymce.plugins.wmShortcodes );

} )();