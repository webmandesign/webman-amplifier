/**
 * Shortcode Generator button
 *
 * @package     WebMan Amplifier
 * @subpackage  Visual Editor
 * @subpackage  Shortcodes
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 */





( function() {

	'use strict';





	tinymce
		.PluginManager
			.add( 'wmShortcodes', function( editor, url ) {

				// Helper variables

					var
						i = 0,
						$menuArray = new Array(),
						$menuArrayShort = new Array(),
						$helper = ( 'undefined' === typeof $wmShortcodesArray ) ? ( [ {
							name  : 'Shortcode',
							code  : '',
							class : 'shortcode'
						} ] ) : ( $wmShortcodesArray ),
						// Allow for multiple instances of TinyMCE on the screen with their specific shortcode generator buttons.
						$buttonID = '_id' + Math.floor( ( Math.random() * 1000 ) + 1 );


				// Processing

					// Helper function

						/**
						 * Set shortcode content based on menu button item ID pressed
						 *
						 * @param      {<type>}  $menuButton  The menu button
						 * @param      {<type>}  $context     The context
						 */
						function setShortcodeContent( $menuButton, $context ) {

							// Helper variables

								var
									$menuId = $menuButton.target.id;

								$menuId = parseInt( $menuId.substring( 2, 4 ) );


							// Processing

								if ( '' != editor.selection.getContent() ) {

									editor
										.selection
											.setContent(
												$context[ $menuId ]['code']
													.replace(
														'{{content}}', // Replace first item found only.
														editor.selection.getContent()
													)
											);

								} else {

									editor
										.selection
											.setContent(
												$context[ $menuId ]['code']
													.replace(
														/{{content}}/g, // Replace all items found.
														'TEXT'
													)
											);

								}

						} // /setShortcodeContent

					// Set the menu button items for full-sized, default shortcode generator

						for ( i = 0; i < $helper.length; i++ ) {
							$menuArray[ i ] = {
								text    : $helper[ i ]['name'],
								id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + $helper[ i ]['class'],
								class   : $helper[ i ]['class'],
								onclick : function( $menuButton ) {

									// Processing

										setShortcodeContent( $menuButton, $helper );

								}
							};
						}

					// Set the menu button items for short, simplified shortcode generator

						if ( 'undefined' != typeof $wmShortcodesArrayShort ) {
							for ( i = 0; i < $wmShortcodesArrayShort.length; i++ ) {
								$menuArrayShort[ i ] = {
									text    : $wmShortcodesArrayShort[ i ]['name'],
									id      : 'wm' + ( '0' + i ).slice( -2 ) + '_' + $wmShortcodesArrayShort[ i ]['class'],
									class   : $wmShortcodesArrayShort[ i ]['class'],
									onclick : function( $menuButton ) {

										// Processing

											setShortcodeContent( $menuButton, $wmShortcodesArrayShort );

									}
								};
							}
						}

					// Add buttons

						// Full-size, default shortcode generator

							editor
								.addButton( 'wm_shortcodes_list', {

									type  : 'menubutton',
									text  : '[…]',
									title : 'Shortcode',
									id    : 'wm_shortcodes_list' + $buttonID,
									icon  : false,
									menu  : $menuArray

								} );

						// Short, simplified shortcode generator

							if ( 'undefined' != typeof $wmShortcodesArrayShort ) {

								editor
									.addButton( 'wm_shortcodes_list_short', {

										type  : 'menubutton',
										text  : '[…]',
										title : 'Shortcode',
										id    : 'wm_shortcodes_list_short' + $buttonID,
										icon  : false,
										menu  : $menuArrayShort

									} );

							}

			} );





} )();
