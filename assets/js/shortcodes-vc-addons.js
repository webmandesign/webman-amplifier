/**
 * WebMan Visual Composer plugin additional scripts
 *
 * Compatible also with Visual Composer v4.3+
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.2.8
 */





( function( $ ) {





	/**
	 * Extending VC shortcode attributes
	 *
	 * From "assets/js/params/composer-atts.js" file.
	 */

		/**
		 * Radio buttons
		 *
		 * @since    1.0
		 * @version  1.2.8
		 */
		vc.atts.wm_radio = {



			parse : function( param ) {

				return jQuery( 'input[name=' + param.param_name + ']:checked', this.content() ).val();

			} // /parse



		};





	/**
	 * Extending VC ViewModel objects for shortcodes with custom functionality
	 *
	 * From "assets/js/backend/composer-custom-views.js" file.
	 */

		/**
		 * Accordions / tabs behaviour
		 *
		 * @since  1.0
		 */
		window.VcCustomAccordionView = vc.shortcode_view.extend( {



			adding_new_tab : false,

			events : {
				'click .add_tab'                                                                                         : 'addTab',
				'click > .controls .column_delete, > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete' : 'deleteShortcode',
				'click > .controls .column_edit, > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit'       : 'editElement',
				'click > .controls .column_clone, > .vc_controls .column_clone, > .vc_controls .vc_control-btn-clone'    : 'clone'
			},



			render : function () {

				window.VcCustomAccordionView.__super__.render.call( this );

				this.$content
					.sortable( {
						axis   : 'y',
						handle : 'h3',
						stop   : function ( event, ui ) {

							// IE doesn't register the blur when sorting
							// so trigger focusout handlers to remove .ui-state-focus

								ui.item.prev().triggerHandler( 'focusout' );

							$( this )
								.find( '> .wpb_sortable' )
									.each( function () {

										var shortcode = $( this ).data( 'model' );

										shortcode.save( { 'order' : $( this ).index() } ); // Optimize

									} );

						}
					} );

				return this;

			},



			changeShortcodeParams : function ( model ) {

				window.VcCustomAccordionView.__super__.changeShortcodeParams.call( this, model );

				var collapsible = _.isString( this.model.get( 'params' ).collapsible ) && this.model.get( 'params' ).collapsible === 'yes' ? true : false;

				if ( this.$content.hasClass( 'ui-accordion' ) ) {
					this.$content.accordion( 'option', 'collapsible', collapsible );
				}

			},



			changedContent : function ( view ) {

				if ( this.$content.hasClass( 'ui-accordion' ) ) {
					this.$content.accordion( 'destroy' );
				}

				var collapsible = true;

				this.$content
					.accordion( {
						header      : 'h3',
						navigation  : false,
						autoHeight  : true,
						heightStyle : 'content',
						collapsible : collapsible,
						active      : this.adding_new_tab === false && view.model.get( 'cloned' ) !== true ? 0 : view.$el.index()
					} );

				this.adding_new_tab = false;

			},


			addTab : function ( e ) {

				this.adding_new_tab = true;

				// Picks the values of these HTML attributes from the button element:

					var newItemCode  = jQuery( e.currentTarget ).data( 'item' ),
					    newItemTitle = jQuery( e.currentTarget ).data( 'item-title' );

				e.preventDefault();

				vc.shortcodes
					.create( {
						shortcode : newItemCode,
						parent_id : this.model.id,
						params    : {
							title : newItemTitle
						}
					} );

			},



			_loadDefaults : function () {

				window.VcCustomAccordionView.__super__._loadDefaults.call( this );

			}



		} ); // /VcCustomAccordionView



		/**
		 * Accordions / tabs sections behaviour
		 *
		 * @since  1.0
		 */
		window.VcCustomAccordionTabView = window.VcColumnView.extend( {



			events : {
				'click > .vc_controls .column_delete, .wpb_vc_accordion_tab > .vc_controls .vc_control-btn-delete' : 'deleteShortcode',
				'click > .vc_controls .column_add, .wpb_vc_accordion_tab >  .vc_controls .vc_control-btn-prepend'  : 'addElement',
				'click > .vc_controls .column_edit, .wpb_vc_accordion_tab >  .vc_controls .vc_control-btn-edit'    : 'editElement',
				'click > .vc_controls .column_clone, .wpb_vc_accordion_tab > .vc_controls .vc_control-btn-clone'   : 'clone',
				'click > [data-element_type] > .wpb_element_wrapper > .vc_empty-container'                         : 'addToEmpty'
			},



			setContent : function () {

				this.$content = this.$el.find( '> [data-element_type] > .wpb_element_wrapper > .vc_container_for_children' );

			},



			changeShortcodeParams : function ( model ) {

				var params = model.get( 'params' );

				window.VcCustomAccordionTabView.__super__.changeShortcodeParams.call( this, model );

				if ( _.isObject( params ) && _.isString( params.title ) ) {

					this.$el
						.find( '> h3 .tab-label' )
							.text( params.title );

				}

			},



			setEmpty : function () {

				$( '> [data-element_type]', this.$el )
					.addClass( 'empty_column vc_empty-column' );

				this.$content
					.addClass( 'empty_container vc_empty-container' );

			},



			unsetEmpty : function () {

				$( '> [data-element_type]', this.$el )
					.removeClass( 'empty_column vc_empty-column' );

				this.$content
					.removeClass( 'empty_container vc_empty-container' );

			}



		} ); // /VcCustomAccordionTabView



		/**
		 * Pricing Table behaviour
		 *
		 * @since  1.0
		 */
		window.VcCustomPricingTableView = vc.shortcode_view.extend( {



			adding_new_tab : false,

			events : {
				'click .add_tab'                                                                                         : 'addTab',
				'click > .controls .column_delete, > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete' : 'deleteShortcode',
				'click > .controls .column_edit, > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit'       : 'editElement',
				'click > .controls .column_clone, > .vc_controls .column_clone, > .vc_controls .vc_control-btn-clone'    : 'clone'
			},



			render : function () {

				window.VcCustomPricingTableView.__super__.render.call( this );

				this.$content
					.sortable( {
						axis   : 'y',
						handle : '.wpb_element_wrapper',
						stop   : function ( event, ui ) {

							// IE doesn't register the blur when sorting
							// so trigger focusout handlers to remove .ui-state-focus

								ui.item.prev().triggerHandler( 'focusout' );

							$( this )
								.find( '> .wpb_sortable' )
									.each( function () {

										var shortcode = $( this ).data( 'model' );

										shortcode.save( { 'order' : $( this ).index() } ); // Optimize

									} );

						}
					} );

				return this;

			},



			addTab : function ( e ) {

				this.adding_new_tab = true;

				// Pick the values of these HTML attributes from the button element:

					var newItemCode  = jQuery( e.currentTarget ).data( 'item' ),
					    newItemTitle = jQuery( e.currentTarget ).data( 'item-title' );

				e.preventDefault();

				vc.shortcodes
					.create( {
						shortcode : newItemCode,
						parent_id : this.model.id,
						params    : {
							caption : newItemTitle
						}
					} );

			},



			_loadDefaults : function () {

				window.VcCustomPricingTableView.__super__._loadDefaults.call( this );

			}



		} ); // /VcCustomPricingTableView





} )( window.jQuery );
