/**
 * WebMan Visual Composer plugin additional scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */



( function( $ ) {



	/**
	 * Extending VC shortcode attributes
	 *
	 * From "composer-atts.js" file.
	 */

		/**
		 * Radio buttons
		 */

			_.extend( vc.atts, {
				wm_radio : {
					parse : function( param ) {
						var arr       = [],
						    new_value = '';

						$( 'input[name=' + param.param_name + ']', this.$content ).each( function(index ) {
							var self = $( this );
							if ( self.is( ':checked' ) ) {
								arr.push( self.attr( 'value' ) );
								self.parent( '.input-item' ).addClass( 'active' );
							}
						} );

						if ( arr.length > 0 ) {
							new_value = arr.join( ',' );
						}

						return new_value;
					}
				}
			} );





	/**
	 * Extending VC ViewModel objects for shortcodes with custom functionality
	 *
	 * From "composer-custom-views.js" file.
	 */

		/**
		 * Accordions / tabs behaviour
		 */

			window.VcCustomAccordionView = vc.shortcode_view.extend( {
				adding_new_tab : false,
				events : {
					'click .add_tab'                   : 'addTab',
					'click > .controls .column_delete' : 'deleteShortcode',
					'click > .controls .column_edit'   : 'editElement',
					'click > .controls .column_clone'  : 'clone'
				},
				render : function () {
					window.VcCustomAccordionView.__super__.render.call( this );
					this.$content.sortable( {
						axis   : "y",
						handle : "h3",
						stop   : function ( event, ui ) {
							// IE doesn't register the blur when sorting
							// so trigger focusout handlers to remove .ui-state-focus
							ui.item.prev().triggerHandler( "focusout" );
							$( this ).find( '> .wpb_sortable' ).each( function () {
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
						this.$content.accordion( "option", "collapsible", collapsible );
					}
				},
				changedContent : function ( view ) {
					if ( this.$content.hasClass( 'ui-accordion' ) ) this.$content.accordion( 'destroy' );
					var collapsible = true;
					this.$content.accordion( {
						header      : "h3",
						navigation  : false,
						autoHeight  : true,
						heightStyle : "content",
						collapsible : collapsible,
						active      : this.adding_new_tab === false && view.model.get( 'cloned' ) !== true ? 0 : view.$el.index()
					} );
					this.adding_new_tab = false;
				},
				addTab : function ( e ) {
					this.adding_new_tab = true;
					//Picks the values of these HTML attributes from the button element:
					var newItemCode  = jQuery( e.currentTarget ).data( 'item' ),
					    newItemTitle = jQuery( e.currentTarget ).data( 'item-title' );
					e.preventDefault();
					vc.shortcodes.create( { shortcode : newItemCode, params : { title : newItemTitle }, parent_id : this.model.id } );
				},
				_loadDefaults : function () {
					window.VcCustomAccordionView.__super__._loadDefaults.call( this );
				}
			} ); // /VcCustomAccordionView



		/**
		 * Accordions / tabs sections behaviour
		 */

			window.VcCustomAccordionTabView = window.VcColumnView.extend( {
				events : {
					'click > [data-element_type] > .controls .column_delete'                : 'deleteShortcode',
					'click > [data-element_type] > .controls .column_add'                   : 'addElement',
					'click > [data-element_type] > .controls .column_edit'                  : 'editElement',
					'click > [data-element_type] > .controls .column_clone'                 : 'clone',
					'click > [data-element_type] > .wpb_element_wrapper > .empty_container' : 'addToEmpty'
				},
				setContent : function () {
					this.$content = this.$el.find( '> [data-element_type] > .wpb_element_wrapper > .vc_container_for_children' );
				},
				changeShortcodeParams : function ( model ) {
					var params = model.get( 'params' );
					window.VcCustomAccordionTabView.__super__.changeShortcodeParams.call( this, model );
					if ( _.isObject( params ) && _.isString( params.title ) ) {
						this.$el.find( '> h3 .tab-label' ).text( params.title );
					}
				},
				setEmpty : function () {
					$( '> [data-element_type]', this.$el ).addClass( 'empty_column' );
					this.$content.addClass( 'empty_container' );
				},
				unsetEmpty : function () {
					$( '> [data-element_type]', this.$el ).removeClass( 'empty_column' );
					this.$content.removeClass( 'empty_container' );
				}
			} ); // /VcCustomAccordionTabView



		/**
		 * Pricing Table behaviour
		 */

			window.VcCustomPricingTableView = vc.shortcode_view.extend( {
				adding_new_tab : false,
				events : {
					'click .add_tab'                   : 'addTab',
					'click > .controls .column_delete' : 'deleteShortcode',
					'click > .controls .column_edit'   : 'editElement',
					'click > .controls .column_clone'  : 'clone'
				},
				render : function () {
					window.VcCustomPricingTableView.__super__.render.call( this );
					this.$content.sortable( {
						axis   : "y",
						handle : ".wpb_element_wrapper",
						stop   : function ( event, ui ) {
							// IE doesn't register the blur when sorting
							// so trigger focusout handlers to remove .ui-state-focus
							ui.item.prev().triggerHandler( "focusout" );
							$( this ).find( '> .wpb_sortable' ).each( function () {
									var shortcode = $( this ).data( 'model' );
									shortcode.save( { 'order' : $( this ).index() } ); // Optimize
								} );
						}
					} );
					return this;
				},
				addTab : function ( e ) {
					this.adding_new_tab = true;
					//Picks the values of these HTML attributes from the button element:
					var newItemCode  = jQuery( e.currentTarget ).data( 'item' ),
					    newItemTitle = jQuery( e.currentTarget ).data( 'item-title' );
					e.preventDefault();
					vc.shortcodes.create( { shortcode : newItemCode, params : { caption : newItemTitle }, parent_id : this.model.id } );
				},
				_loadDefaults : function () {
					window.VcCustomPricingTableView.__super__._loadDefaults.call( this );
				}
			} ); // /VcCustomPricingTableView




} )( window.jQuery );



/* END OF FILE */