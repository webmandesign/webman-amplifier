/**
 * WebMan Metabox Generator scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.2.3
 */





jQuery( function() {





	/**
	 * Basics
	 */

		jQuery( '.no-js' )
			.removeClass( 'no-js' );



	/**
	 * Color picker
	 */

		if ( jQuery().wpColorPicker ) {

			var wmColorPickerOptionsArray = ( typeof wmColorPickerOptions == 'undefined' ) ? ( null ) : ( wmColorPickerOptions );

			jQuery( '.wm-meta-wrap .color-wrap .fieldtype-text' )
				.wpColorPicker( wmColorPickerOptionsArray );

		} // /wpColorPicker



	/**
	 * Default value button
	 */

		jQuery( '.button-default-value' )
			.on( 'click', function() {

				var $this        = jQuery( this ),
				    defaultInput = $this.data( 'option' ),
				    defaultValue = $this.find( 'span' ).text();

				if ( $this.hasClass( 'default-gallery' ) ) {

					jQuery( '#' + defaultInput )
						.attr( 'value', defaultValue );

					jQuery( '.gallery-' + defaultInput )
						.html( '' );

				} else if ( $this.hasClass( 'default-slider' ) && jQuery().slider ) {

					jQuery( '#' + defaultInput + '-slider' )
						.slider( 'option', 'value', defaultValue )
							.find( '.ui-slider-handle' )
								.text( parseInt( defaultValue ) );

					jQuery( '#' + defaultInput )
						.attr( 'value', defaultValue );

				} else {

					var defaultField = '.wm-meta-wrap [name="' + defaultInput + '"]';

					if ( 'radio' === jQuery( defaultField ).attr( 'type' ) ) {

						jQuery( defaultField + '[value="' + defaultValue + '"]' )
							.attr( 'checked', 'checked' );

					} else {

						jQuery( defaultField )
							.val( defaultValue )
							.change();

					}

				}

			} );



	/**
	 * Featured image setup
	 */

		wmFeaturedImage = {



			get : function() {

				return wp.media.view.settings.post.featuredImageId;

			},



			set : function( id ) {

				var settings = wp.media.view.settings;

				settings.post.featuredImageId = id;

				wp.media.post( 'set-post-thumbnail', {
					json         : true,
					post_id      : settings.post.id,
					thumbnail_id : settings.post.featuredImageId,
					_wpnonce     : settings.post.nonce
				} ).done( function( html ) {

					jQuery( '.inside', '#postimagediv' )
						.html( html );

				} );

			},



			frame : function() {

				if ( this._frame ) {
					return this._frame;
				}

				this._frame = wp.media( {
					state  : 'featured-image',
					states : [ new wp.media.controller.FeaturedImage() ]
				} );

				this._frame.on( 'toolbar:create:featured-image', function( toolbar ) {
					this.createSelectToolbar( toolbar, {
						text : wp.media.view.l10n.setFeaturedImage
					} );
				}, this._frame );

				this._frame.state( 'featured-image' ).on( 'select', this.select );

				return this._frame;

			},



			select : function() {

				var settings  = wp.media.view.settings,
				    selection = this.get( 'selection' ).single();

				if ( ! settings.post.featuredImageId ) {
					return;
				}

				wmFeaturedImage.set( selection ? selection.id : -1 );

			},



			init : function() {

				// Open the content media manager to the 'featured image' tab

					jQuery( '.button-set-featured-image' ).on( 'click', function( event ) {
						event.preventDefault();
						event.stopPropagation(); // Stop propagation to prevent thickbox from activating.

						wmFeaturedImage.frame().open();
					} );

			}


		};

		wmFeaturedImage.init();



	/**
	 * Gallery uploader
	 */

		// Upload multiple images (gallery) action

			jQuery( '.wm-meta-wrap .gallery-wrap' )
				.on( 'click', '.button-set-gallery', function( e ) {

					// Check if the wp.media.gallery API exists.

						if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.gallery ) {
							return;
						}

					var galleryID    = jQuery( this ).data( 'id' ),
					    galleryNonce = ( typeof wmGalleryPreviewNonce == 'undefined' ) ? ( '' ) : ( wmGalleryPreviewNonce ),
					    galleryField = jQuery( '#' + galleryID ),
					    wpGallery    = wp.media.gallery,
					    frame        = wpGallery.edit( '[gallery ids="' + galleryField.val() + '"]' ),
					    frameClasses = frame.el.getAttribute( 'class' );

					frame.el.setAttribute( 'class', frameClasses + ' wmamp-gallery' );

					frame.state( 'gallery-edit' ).on( 'update', function( selection ) {

						var imageIDarray = wpGallery.shortcode( selection ).attrs.named.ids,
						    imageIDs     = imageIDarray.join( ',' );

						// Remove existing images and display loader animation

							jQuery( '.gallery-' + galleryID )
								.find( 'a' )
									.hide();

							jQuery( '.gallery-loading-' + galleryID )
								.show();

						// Do AJAX and get response (result)

							if ( imageIDarray.length ) {

								jQuery.post( ajaxurl, {
									action         : 'wm-gallery-preview-refresh',
									fieldID        : galleryID,
									images         : imageIDarray,
									wmGalleryNonce : galleryNonce
								}, function( response ) {

									// Load new images

										jQuery( '.gallery-' + galleryID )
											.html( response );

									// Hide loader animation

										jQuery( '.gallery-loading-' + galleryID )
											.hide();

								} );

							}

						galleryField.val( imageIDs );

					} );

					e.preventDefault();

				} );



	/**
	 * Image uploader
	 */

		// Upload image action

			jQuery( '.wm-meta-wrap .image-wrap label, .wm-meta-wrap .button-set-image' )
				.on( 'click', function( e ) {

					// Check if the wp.media.editor API exists.

						if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.editor ) {
							return;
						}

					var uploadFieldId     = jQuery( this ).data( 'id' ),
					    sendAttachmentBkp = wp.media.editor.send.attachment;

					wp.media.editor.send.attachment = function( props, attachment ) {

						// Set input field values

							jQuery( 'input[name="' + uploadFieldId + '[url]"]' )
								.val( attachment.url );

							jQuery( 'input[name="' + uploadFieldId + '[url]"]' )
								.attr( 'data-preview', attachment.sizes.thumbnail.url );

							jQuery( 'input[name="' + uploadFieldId + '[id]"]' )
								.val( attachment.id );

						// Set preview image

							jQuery( 'div.image-' + uploadFieldId )
								.removeClass( 'hide' )
								.find( 'img' )
									.attr( 'src', attachment.sizes.thumbnail.url );

						wp.media.editor.send.attachment = sendAttachmentBkp;

					}

					wp.media.editor.open();

					e.preventDefault();

				} );

		// Live image preview change

			jQuery( '.wm-meta-wrap .preview-enabled .fieldtype-image' )
				.on( 'change', function() {

					var $this         = jQuery( this ),
					    imageSrc      = $this.val(),
					    uploadFieldId = $this.attr('id'),
					    noThumbSrc    = $this.data( 'nothumb' );

					if ( imageSrc ) {

					  imageSrc = ( $this.data( 'preview' ) ) ? ( $this.data( 'preview' ) ) : ( $this.val() );

						jQuery( 'div.image-' + uploadFieldId )
							.find( 'img' )
								.attr( 'src', imageSrc );

					} else {

						$this.data( 'preview', '' );

						jQuery( 'div.image-' + uploadFieldId )
							.find( 'img' )
								.attr( 'src', noThumbSrc );

					}

				} );

			// Trigger action on page load

				jQuery( '.wm-meta-wrap .fieldtype-image' )
					.change();



	/**
	 * Modal confirmation
	 */

		jQuery( '.wm-meta-wrap .confirm' )
			.on( 'click', function( e ) {

				var btnUrl   = jQuery( this ).attr( 'href' ),
				    modalBox = jQuery( '.wm-meta-wrap .modal-box' ).fadeIn();

				modalBox.find( 'a' )
					.on( 'click', function() {

						var modalAction = jQuery( this ).data( 'action' );

						if ( 'stay' === modalAction ) {

							modalBox
								.fadeOut();

						} else {

							window.location = btnUrl;

						}

					} );

				e.preventDefault();

			} );



	/**
	 * Range (numeric slider)
	 */

		if ( jQuery().slider ) {

			jQuery( '.wm-meta-wrap .range-wrap' )
				.each( function() {

					var sliderOptionId   = '#' + jQuery( this ).data( 'option' ),
					    sliderOptionVal  = jQuery( sliderOptionId + '-slider' ).data( 'value' ),
					    sliderOptionMin  = jQuery( sliderOptionId + '-slider' ).data( 'min' ),
					    sliderOptionMax  = jQuery( sliderOptionId + '-slider' ).data( 'max' ),
					    sliderOptionStep = jQuery( sliderOptionId + '-slider' ).data( 'step' );

					// Make the input field read-only

						jQuery( sliderOptionId )
							.attr( 'type', 'hidden' );

					// Initialize jQuery UI Slider

						jQuery( sliderOptionId + '-slider' )
							.slider( {
								value  : sliderOptionVal,
								min    : sliderOptionMin,
								max    : sliderOptionMax,
								step   : sliderOptionStep,
								create : function( e, ui ) {

									jQuery( this )
										.find( '.ui-slider-handle' )
											.text( parseInt( jQuery( sliderOptionId ).val() ) );

								},
								slide  : function( e, ui ) {

									jQuery( this )
										.find( '.ui-slider-handle' )
											.text( parseInt( ui.value ) );

									jQuery( sliderOptionId )
										.val( parseInt( ui.value ) )
											.change();

								}
							} );

				} );

		} // /slider



	/**
	 * Radio buttons
	 */

		// Add "active" class to radio button items if custom label is used

			jQuery( '.wm-meta-wrap .radio-wrap.custom-label .radio-item' )
				.find( 'input' )
					.on( 'change', function() {

						jQuery( this )
							.parent( '.inline-radio' )
								.addClass( 'active' )
								.siblings( '.inline-radio' )
									.removeClass( 'active' );

					} )
				.end()
				.find( 'input:checked' )
					.parent( '.inline-radio' )
						.addClass( 'active' );

		// Radio buttons filtering

			jQuery( '.filter-text' )
				.on( 'keyup', function() {

					var search = jQuery( this ),
					    text   = search.val();

					search
						.closest( '.filterable' )
						.find( '.radio-item' )
							.each( function() {

								var item  = jQuery( this ),
								    value = item.data( 'value' ).replace( 'icon', '' );

								if ( -1 == value.indexOf( text ) ) {
									item.hide();
								} else {
									item.show();
								}

							} );

				} );



	/**
	 * Repeater (dynamic items)
	 */

		// Helper functions for repeater

			function wm_increase_cell_number( index, name ) {

				return name.replace( /(\[\d+\])/, function( fullMatch, n ) {
						n = n.substr( 1, n.length-2 );
						return '[' + ( Number( n ) + 1 ) + ']';
					} );

			} // /wm_increase_cell_number

		// Adding new cells (items)

			jQuery( '.wm-meta-wrap .button-add-cell' )
				.on( 'click', function( e ) {

					e.preventDefault();

					var $this        = jQuery( this ),
					    cellsWrapper = $this.parent( 'td' ).find( '.repeater-cells' ),
					    cellLocation = $this.parent( 'td' ).find( '.repeater-cell:last' ),
					    cellClone    = cellLocation.clone( true ).off();

					// Alert when there is no repeater cell

						if ( cellLocation.length < 1 ) {
							alert( 'Please, reload the page' );
						}

					// Increase cell index

						// Input fields

							jQuery( '[class*="fieldtype-"]', cellClone )
								.val( '' )
								.attr( 'name', function( index, name ) {
									return wm_increase_cell_number( index, name );
								} )
								.attr( 'id', function( index, name ) {
									return wm_increase_cell_number( index, name );
								} );

						// Labels

							jQuery( 'label', cellClone )
								.attr( 'for', function( index, name ) {
									return wm_increase_cell_number( index, name );
								} );

						// Others

							jQuery( '[data-option]', cellClone )
								.attr( 'data-option', function( index, name ) {
									return wm_increase_cell_number( index, name );
								} );

					// Insert new clonned cell

						cellClone.insertAfter( cellLocation, $this.parent( 'td' ).find( '.repeater-cells' ) );

					// Reactivate remove button when more than one item in stack

						if ( cellsWrapper.children().length > 1 ) {

							cellsWrapper
								.find( '.button-remove-cell' )
									.removeClass( 'button-disabled' );

						}

				} );

		// Removing existing cells (items)

			jQuery( '.wm-meta-wrap .button-remove-cell' )
				.on( 'click', function( e ) {

					var $this        = jQuery( this ),
					    cellsWrapper = $this.closest( '.repeater-cells' );

					// Remove cell only if there is more than one in the stack

						if ( $this.closest( '.repeater-cells' ).children().length > 1 ) {
							$this
								.closest( '.repeater-cell' )
									.remove();
						}

					// Deactivate remove button when only one item in stack

						if ( cellsWrapper.children().length <= 1 ) {
							cellsWrapper
								.find( '.button-remove-cell' )
									.addClass( 'button-disabled' );
						}

					e.preventDefault();

				} );

		// Enable sorting of the cells (items)

			if ( jQuery().sortable ) {

				jQuery( '.wm-meta-wrap .repeater-cells' )
					.sortable( {
						cursor  : 'move',
						handle  : '.button-move-cell',
						items   : '> .repeater-cell',
						opacity : 0.66,
						revert  : true,
					} );

			} // /sortable



	/**
	 * Tabs
	 */

		if ( jQuery().tabs ) {

			jQuery( '.wm-meta-wrap.jquery-ui-tabs' )
				.tabs();

		} // /tabs



	/**
	 * Toggles
	 */

		// Toggle sub-sections

			jQuery( '.wm-meta-wrap .option-heading.toggle' )
				.not( '.open' )
				.closest( 'tbody' )
					.next( 'tbody' )
						.hide();

			jQuery( '.wm-meta-wrap .option-heading.toggle' )
				.on( 'click', function() {

					jQuery( this )
						.closest( 'tbody' )
							.next( 'tbody' )
								.toggle();

				} );



	/**
	 * Visual Composer plugin support
	 */

		// Function to control display CSS class upon Visual Composer visibility

			function wm_vc_visible() {

				if ( jQuery( '#wpb_visual_composer' ).is( ':visible' ) ) {

					jQuery( 'body' )
						.addClass( 'wm-visual-composer-on' );

				} else {

					jQuery( 'body' )
						.removeClass( 'wm-visual-composer-on' );

				}

			} // /wm_vc_visible

		// Cache Visual Composer switch button

			var $WmampVcButton = jQuery( '.composer-switch a' );

		// Run the function first in case there is a Visual Composer globally disabled (in its settings)

			wm_vc_visible();

		// Visual Composer switch button action

			$WmampVcButton
				.live( 'click', function() {
					wm_vc_visible();
				} );



	/**
	 * ZIP uploader
	 */

		// Upload ZIP file action

			jQuery( '.wm-meta-wrap .zip-wrap label, .wm-meta-wrap .zip-wrap .fieldtype-zip, .wm-meta-wrap .button-set-zip' )
				.on( 'click', function( e ) {

					// Check if the wp.media.editor API exists.

						if ( typeof wp === 'undefined' || ! wp.media || ! wp.media.editor ) {
							return;
						}

					var uploadFieldId     = jQuery( this ).data( 'id' ),
					    sendAttachmentBkp = wp.media.editor.send.attachment;

					wp.media.editor.send.attachment = function( props, attachment ) {

						// Set input field values

							if ( 1 < attachment.url.search( '.zip' ) || 1 < attachment.url.search( '.ZIP' ) ) {

								jQuery( 'input[name="' + uploadFieldId + '[url]"]' )
									.val( attachment.url );
								jQuery( 'input[name="' + uploadFieldId + '[id]"]' )
									.val( attachment.id );

							} else {

								alert( 'No ZIP file selected' );

								jQuery( 'input[name="' + uploadFieldId + '[url]"]' )
									.val( '' );
								jQuery( 'input[name="' + uploadFieldId + '[id]"]' )
									.val( '' );

							}

						wp.media.editor.send.attachment = sendAttachmentBkp;

					}

					wp.media.editor.open();

					e.preventDefault();

				} );



	/**
	 * +++ Required actions +++
	 */

		// Required select field changes on load

			jQuery( 'select[name="page_template"], .wm-meta-wrap select' )
				.change();





} );
