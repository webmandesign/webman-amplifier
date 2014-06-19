/**
 * WebMan Shortcode Generator button
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 * @version     1.0.9.2
 */



( function() {

	'use strict';

	tinymce.PluginManager.add( 'wmShortcodes', function( editor, url ) {

		var wmShortcodesMenuArray   = new Array(),
		    wmShortcodesMenuArrayVC = new Array(),
		    wmShortcodesHelper      = ( 'undefined' === typeof wmShortcodesArray ) ? ( [{name:'Shortcode',code:'',class:'shortcode'}] ) : ( wmShortcodesArray ),
		    wmButtonIdSuffix        = '_id' + Math.floor( ( Math.random() * 1000 ) + 1 ); //This is important to allow multiple instances of TinyMCE on the screen with their specific shortcode generator buttons

		//Set the menu button items (default)
			for ( var i in wmShortcodesHelper ) {
				wmShortcodesMenuArray[i] = {
						text    : wmShortcodesHelper[i]['name'],
						id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + wmShortcodesHelper[i]['class'],
						class   : wmShortcodesHelper[i]['class'],
						onclick : function( wholeMenuButton ) {
								var menuId = wholeMenuButton.target.id;

								menuId = parseInt( menuId.substring( 2, 4 ) );

								//Retrieve the shortcode content based on menu button item ID pressed
								if ( '' != editor.selection.getContent() ) {

									var shortcodeOutput = wmShortcodesHelper[menuId]['code'].replace( '{{content}}', editor.selection.getContent() );

									editor.selection.setContent( shortcodeOutput );

								} else {

									var shortcodeOutput = wmShortcodesHelper[menuId]['code'].replace( '{{content}}', 'TEXT' );

									editor.selection.setContent( shortcodeOutput );

								}
							}
					};
			}

		//Set the menu button items (VC)
			if ( 'undefined' != typeof wmShortcodesArrayVC ) {

				for ( var i in wmShortcodesArrayVC ) {
					wmShortcodesMenuArrayVC[i] = {
							text    : wmShortcodesArrayVC[i]['name'],
							id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + wmShortcodesArrayVC[i]['class'],
							class   : wmShortcodesArrayVC[i]['class'],
							onclick : function( wholeMenuButton ) {
									var menuId = wholeMenuButton.target.id;

									menuId = parseInt( menuId.substring( 2, 4 ) );

									//Retrieve the shortcode content based on menu button item ID pressed
									if ( '' != editor.selection.getContent() ) {

										var shortcodeOutput = wmShortcodesArrayVC[menuId]['code'].replace( '{{content}}', editor.selection.getContent() );

										editor.selection.setContent( shortcodeOutput );

									} else {

										var shortcodeOutput = wmShortcodesArrayVC[menuId]['code'].replace( '{{content}}', 'TEXT' );

										editor.selection.setContent( shortcodeOutput );

									}
								}
						};
				}

			}



		//Shortcode Generator Button
			editor.addButton( 'wm_shortcodes_list', {

				type  : 'menubutton',
				text  : '[s]',
				title : 'Shortcode',
				id    : 'wm_shortcodes_list' + wmButtonIdSuffix,
				icon  : false,
				menu  : wmShortcodesMenuArray

			} );

		//Shortcode Generator VC Button
			if ( 'undefined' != typeof wmShortcodesArrayVC ) {

				editor.addButton( 'wm_shortcodes_list_vc', {

					type  : 'menubutton',
					text  : '[s]',
					title : 'Shortcode',
					id    : 'wm_shortcodes_list_vc' + wmButtonIdSuffix,
					icon  : false,
					menu  : wmShortcodesMenuArrayVC

				} );

			}

	} );

} )();