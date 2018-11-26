/**
 * WebMan Shortcode Generator button
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.2
 */





( function() {





	'use strict';





	tinymce.PluginManager.add( 'wmShortcodes', function( editor, url ) {

		var i = 0,
		    wmShortcodesMenuArray      = new Array(),
		    wmShortcodesMenuArrayShort = new Array(),
		    wmShortcodesHelper         = ( 'undefined' === typeof wmShortcodesArray ) ? ( [{name:'Shortcode',code:'',class:'shortcode'}] ) : ( wmShortcodesArray ),
		    wmButtonIdSuffix           = '_id' + Math.floor( ( Math.random() * 1000 ) + 1 ); // This is important to allow multiple instances of TinyMCE on the screen with their specific shortcode generator buttons

		// Set the menu button items (default)

			for ( i = 0; i < wmShortcodesHelper.length; i++ ) {

				wmShortcodesMenuArray[i] = {

						text    : wmShortcodesHelper[i]['name'],
						id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + wmShortcodesHelper[i]['class'],
						class   : wmShortcodesHelper[i]['class'],
						onclick : function( wholeMenuButton ) {

							var menuId = wholeMenuButton.target.id;

							menuId = parseInt( menuId.substring( 2, 4 ) );

							// Retrieve the shortcode content based on menu button item ID pressed

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

		// Set the menu button items (short)

			if ( 'undefined' != typeof wmShortcodesArrayShort ) {

				for ( i = 0; i < wmShortcodesArrayShort.length; i++ ) {

					wmShortcodesMenuArrayShort[i] = {

							text    : wmShortcodesArrayShort[i]['name'],
							id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + wmShortcodesArrayShort[i]['class'],
							class   : wmShortcodesArrayShort[i]['class'],
							onclick : function( wholeMenuButton ) {

								var menuId = wholeMenuButton.target.id;

								menuId = parseInt( menuId.substring( 2, 4 ) );

								// Retrieve the shortcode content based on menu button item ID pressed

									if ( '' != editor.selection.getContent() ) {

										var shortcodeOutput = wmShortcodesArrayShort[menuId]['code'].replace( '{{content}}', editor.selection.getContent() );

										editor.selection.setContent( shortcodeOutput );

									} else {

										var shortcodeOutput = wmShortcodesArrayShort[menuId]['code'].replace( '{{content}}', 'TEXT' );

										editor.selection.setContent( shortcodeOutput );

									}

							}

						};

				}

			}



		// Shortcode Generator Button

			editor.addButton( 'wm_shortcodes_list', {

				type  : 'menubutton',
				text  : '[s]',
				title : 'Shortcode',
				id    : 'wm_shortcodes_list' + wmButtonIdSuffix,
				icon  : false,
				menu  : wmShortcodesMenuArray

			} );

		// Shortcode Generator Short Button

			if ( 'undefined' != typeof wmShortcodesArrayShort ) {

				editor.addButton( 'wm_shortcodes_list_short', {

					type  : 'menubutton',
					text  : '[s]',
					title : 'Shortcode',
					id    : 'wm_shortcodes_list_short' + wmButtonIdSuffix,
					icon  : false,
					menu  : wmShortcodesMenuArrayShort

				} );

			}

	} );





} )();
