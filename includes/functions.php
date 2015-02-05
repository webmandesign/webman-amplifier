<?php
/**
 * WebMan Amplifier global helper functions
 *
 * @package  WebMan Amplifier
 *
 * @since    1.0
 * @version  1.1.2
 */



	/**
	 * Array values sorting
	 *
	 * @since   1.0
	 *
	 * @param   array $input_array
	 *
	 * @return  array Sorted array.
	 */
	if ( ! function_exists( 'wma_asort' ) ) {
		function wma_asort( $input_array = array() ) {
			//Processing
				if ( ! empty( $input_array ) ) {
					asort( $input_array );
				} else {
					$input_array = array();
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_asort' . '_output', $input_array );
		}
	} // /wma_asort



	/**
	 * Array keys sorting
	 *
	 * @since   1.0
	 *
	 * @param   array $input_array
	 *
	 * @return  array Sorted array.
	 */
	if ( ! function_exists( 'wma_ksort' ) ) {
		function wma_ksort( $input_array = array() ) {
			//Processing
				if ( ! empty( $input_array ) ) {
					ksort( $input_array );
				} else {
					$input_array = array();
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_ksort' . '_output', $input_array );
		}
	} // /wma_ksort



	/**
	 * Is plugin's subfeature supported by the theme?
	 *
	 * @since   1.0.9.15
	 *
	 * @param   string $subfeature
	 *
	 * @return  bool
	 */
	if ( ! function_exists( 'wma_supports_subfeature' ) ) {
		function wma_supports_subfeature( $subfeature = '' ) {
			//Helper variables
				$supported            = (array) get_theme_support( 'webman-amplifier' );
				$supported_shortcodes = (array) get_theme_support( 'webman-shortcodes' );

				$supported = array_filter( array_merge( (array) $supported[0], (array) $supported_shortcodes[0] ) );

			//Processing
				if (
						trim( $subfeature )
						&& is_array( $supported )
						&& ! empty( $supported )
					) {
					return in_array( $subfeature, $supported );
				}

			//Output
				return false;
		}
	} // /wma_supports_subfeature



	/**
	 * Create permalinks settings field in WordPress admin
	 *
	 * @since  1.0
	 *
	 * @param  array $args
	 */
	if ( ! function_exists( 'wma_permalinks_render_field' ) ) {
		function wma_permalinks_render_field( $args = array() ) {
			//Processing arguments
				if ( isset( $args['name'] ) && $args['name'] ) {
					$args['name'] = trim( $args['name'] );
				} else {
					return;
				}
				if ( isset( $args['placeholder'] ) && $args['placeholder'] ) {
					$args['placeholder'] = trim( $args['placeholder'] );
				}

			//Get value
				$value = get_option( 'wmamp-permalinks' );
				if ( is_array( $value ) && isset( $value[ $args['name'] ] ) ) {
					$value = untrailingslashit( $value[ $args['name'] ] );
				} else {
					$value = '';
				}

			//Output
				echo apply_filters( WMAMP_HOOK_PREFIX . 'wma_permalinks_render_field' . '_output', '<input name="wmamp-permalinks[' . $args['name'] . ']" type="text" value="' . $value . '" placeholder="' . $args['placeholder'] . '" class="regular-text code" />', $args );
		}
	} // /wma_permalinks_render_field



	/**
	 * Create a folder
	 *
	 * This function creates a folder within WP uploads dir.
	 * Also, applies 0755 permission on the created folder.
	 *
	 * @since    1.0
	 * @version  1.1.2
	 *
	 * @param  array $folder
	 * @param  bool  $add_indexphp
	 */
	if ( ! function_exists( 'wma_create_folder' ) ) {
		function wma_create_folder( $folder = '', $add_indexphp = true ) {
			//Check if folder exists already
				if ( is_dir( $folder ) ) {
					return true;
				}

			//Let WordPress to create a folder
				$created = wp_mkdir_p( trailingslashit( $folder ) );

			//Set privilegues
				@chmod( $folder, 0755 );

			//Need for index.php file inside the folder?
				if ( ! $add_indexphp ) {

					return $created;

				} else {

					$index_file = trailingslashit( $folder ) . 'index.php';

					if ( file_exists( $index_file ) ) {
						return $created;
					} else {
						$file_handle = @fopen( $index_file, 'w' );
						if ( $file_handle ) {
							fwrite( $file_handle, '<?php // Silence is golden' );
							fclose( $file_handle );
						}
					}

					@chmod( $index_file, 0644 );

				}

			//Return
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_create_folder' . '_output', $created, $folder, $add_indexphp );
		}
	} // /wma_create_folder



	/**
	 * Get post meta option
	 *
	 * @since    1.0
	 * @version  1.1.1
	 *
	 * @param    string  $name    Meta option name.
	 * @param    integer $post_id Specific post ID.
	 *
	 * @return   mixed
	 */
	if ( ! function_exists( 'wma_meta_option' ) ) {
		function wma_meta_option( $name, $post_id = null ) {
			//Requirements check
				$post_id = absint( $post_id );
				if ( ! $post_id ) {
					$post_id = get_the_ID();
				}

				if ( ! trim( $name ) || ! $post_id ) {
					return;
				}

			//Helper variables
				$output = apply_filters( WMAMP_HOOK_PREFIX . 'wma_meta_option' . '_output_pre', '', $name, $post_id );

				//Premature output
					if ( $output ) {
						return apply_filters( WMAMP_HOOK_PREFIX . 'wma_meta_option' . '_output', $output, $name, $post_id );
					}

				$meta_array_name = apply_filters( WMAMP_HOOK_PREFIX . 'wma_meta_option' . '_meta_array_name', WM_METABOX_SERIALIZED_NAME, $name, $post_id );
				$meta_prefix     = apply_filters( WMAMP_HOOK_PREFIX . 'wma_meta_option' . '_meta_prefix', WM_METABOX_FIELD_PREFIX, $name, $post_id );

			//Preparing output
				$meta = get_post_meta( $post_id, $meta_array_name, true );
				$name = $meta_prefix . $name;

				if ( isset( $meta[ $name ] ) && $meta[ $name ] ) {

					if ( is_array( $meta[ $name ] ) ) {
						$output = $meta[ $name ];
					} else {
						$output = stripslashes( $meta[ $name ] );
					}

				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_meta_option' . '_output', $output, $name, $post_id );
		}
	} // /wma_meta_option



	/**
	 * Taxonomy list
	 *
	 * @since    1.0
	 * @version  1.0.5
	 *
	 * @param    array $args
	 *
	 * @return   array Array of taxonomy slug => name.
	 */
	if ( ! function_exists( 'wma_taxonomy_array' ) ) {
		function wma_taxonomy_array( $args = array() ) {
			$args = wp_parse_args( $args, array(
					//"All" option
						'all'           => true,                           //whether to display "all" option
						'all_post_type' => 'post',                         //post type to count posts for "all" option, if left empty, the posts count will not be displayed
						'all_text'      => __( 'All posts', 'wm_domain' ), //"all" option text
					//Query settings
						'hierarchical'  => '1',                            //whether taxonomy is hierarchical
						'order_by'      => 'name',                         //in which order the taxonomy titles should appear
						'parents_only'  => false,                          //will return only parent (highest level) categories
						'hide_empty'    => 0,                              //whether to display only used taxonomies
					//Default returns
						'return'        => 'slug',                         //what to return as a value (slug, or term_id?)
						'tax_name'      => 'category',                     //taxonomy name
				) );

			//Helper variables
				$output = array();

			//Check
				if ( ! taxonomy_exists( $args['tax_name'] ) ) {
					return apply_filters( WMAMP_HOOK_PREFIX . 'taxonomy_array', $output, $args );
				}

			//Get terms
				$terms  = get_terms( $args['tax_name'], 'orderby=' . $args['order_by'] . '&hide_empty=' . $args['hide_empty'] . '&hierarchical=' . $args['hierarchical'] );

			//Preparing output array
				if ( $args['all'] ) {
				//Set "All" option
					if ( ! $args['all_post_type'] ) {
						$all_count = '';
					} else {
						$readable  = ( in_array( $args['all_post_type'], array( 'post', 'page' ) ) ) ? ( 'readable' ) : ( null );
						$all_count = wp_count_posts( $args['all_post_type'], $readable );
						$all_count = ' (' . absint( $all_count->publish ) . ')';
					}
					$output[''] = apply_filters( WMAMP_HOOK_PREFIX . 'taxonomy_array_all', '- ' . $args['all_text'] . $all_count . ' -', $args, $all_count );
				}

				if ( ! is_wp_error( $terms ) && is_array( $terms ) && ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						if ( ! $args['parents_only'] ) {
						//All taxonomies (categories) including children
							$output[$term->$args['return']]  = $term->name;
							$output[$term->$args['return']] .= ( ! $args['all_post_type'] ) ? ( '' ) : ( apply_filters( WMAMP_HOOK_PREFIX . 'taxonomy_array_count', ' (' . $term->count . ')', $args, $term->count ) );
						} elseif ( $args['parents_only'] && ! $term->parent ) {
						//Get only parent taxonomies (categories), no children
							$output[$term->$args['return']]  = $term->name;
							$output[$term->$args['return']] .= ( ! $args['all_post_type'] ) ? ( '' ) : ( apply_filters( WMAMP_HOOK_PREFIX . 'taxonomy_array_count', ' (' . $term->count . ')', $args, $term->count ) );
						}
					}
				}

				//Sort alphabetically
					if ( ! $args['hierarchical'] ) {
						asort( $output );
					}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_taxonomy_array' . '_output', $output, $args );
		}
	} // /wma_taxonomy_array



	/**
	 * Posts list - returns array [post_name (slug) => name]
	 *
	 * @since    1.0
	 * @version  1.0.5
	 *
	 * @param    string $return    What field to return ('post_name' or 'ID').
	 * @param    string $post_type What custom post type to return (defaults to "post").
	 *
	 * @return   array Array of post slug => name.
	 */
	if ( ! function_exists( 'wma_posts_array' ) ) {
		function wma_posts_array( $return = 'post_name', $post_type = 'post' ) {
			//Helper variables
				$args = array(
						'posts_per_page' => -1,
						'orderby'        => 'title',
						'order'          => 'ASC',
						'post_type'      => $post_type,
						'post_status'    => 'publish',
					);
				$posts  = get_posts( $args );
				$output = array();

			//Check
				if ( ! post_type_exists( $post_type ) ) {
					return apply_filters( WMAMP_HOOK_PREFIX . 'posts_array', $output, $return, $post_type );
				}

			//Preparing output array
				$output[''] = apply_filters( WMAMP_HOOK_PREFIX . 'wma_posts_array_select_text', __( '- Select item -', 'wm_domain' ), $return, $post_type );

				if ( is_array( $posts ) && ! empty( $posts ) ) {
					foreach ( $posts as $post ) {
						//Set return parameter
							$return_param = ( 'post_name' == $return ) ? ( $post->post_name ) : ( $post->ID );

						$output[$return_param] = trim( strip_tags( $post->post_title ) );
					}
				}

				//Sort alphabetically
					asort( $output );

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_posts_array' . '_output', $output, $return, $post_type );
		}
	} // /wma_posts_array



	/**
	 * Pages list - returns array [post_name (slug) => name]
	 *
	 * @since    1.0
	 * @version  1.0.5
	 *
	 * @param    string $return What field to return ('post_name' or 'ID').
	 *
	 * @return   array Array of page slug => name.
	 */
	if ( ! function_exists( 'wma_pages_array' ) ) {
		function wma_pages_array( $return = 'post_name' ) {
			//Helper variables
				$args   = apply_filters( WMAMP_HOOK_PREFIX . 'wma_pages_array_args', array(
						'sort_order'  => 'ASC',
						'sort_column' => 'post_title',
					), $return );
				$pages  = get_pages( $args );
				$output = array();

			//Preparing output array
				$output[''] = apply_filters( WMAMP_HOOK_PREFIX . 'wma_pages_array_select_text', __( '- Select a page -', 'wm_domain' ), $return );

				if ( is_array( $pages ) && ! empty( $pages ) ) {
					foreach ( $pages as $page ) {
						$indents   = $page_path = '';
						$ancestors = get_post_ancestors( $page->ID );

						if ( ! empty( $ancestors ) ) {
						//Process ancestors
							$indent    = ( $page->post_parent ) ? ( '&ndash; ' ) : ( '' );
							$ancestors = array_reverse( $ancestors ); //Need to reverse the array for proper usage in get_page_by_path() function.
							foreach ( $ancestors as $ancestor ) {
								if ( 'post_name' == $return ) {
									$parent     = get_page( $ancestor );
									$page_path .= $parent->post_name . '/';
								}
								$indents .= $indent;
							}
						}

						$page_path .= $page->post_name;

						//Set return parameter
							$return_param = ( 'post_name' == $return ) ? ( $page_path ) : ( $page->ID );

						$output[$return_param] = $indents . trim( strip_tags( $page->post_title ) );
					}
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_pages_array' . '_output', $output, $return );
		}
	} // /wma_pages_array



	/**
	 * Get array of widget areas
	 *
	 * @since    1.0
	 * @version  1.0.5
	 *
	 * @return   array Array of widget area id => name.
	 */
	if ( ! function_exists( 'wma_widget_areas_array' ) ) {
		function wma_widget_areas_array() {
			//Helper variables
				global $wp_registered_sidebars;

				$output = array();

			//Preparing output array
				$output[''] = apply_filters( WMAMP_HOOK_PREFIX . 'wma_widget_areas_array_select_text', __( '- Select area -', 'wm_domain' ) );

				if ( is_array( $wp_registered_sidebars ) && ! empty( $wp_registered_sidebars ) ) {
					foreach ( $wp_registered_sidebars as $area ) {
						$output[ $area['id'] ] = $area['name'];
					}
				}

				//Sort alphabetically
					asort( $output );

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_widget_areas_array' . '_output', $output );
		}
	} // /wma_widget_areas_array



	/**
	 * Sidebar (display widget area)
	 *
	 * @since   1.0
	 *
	 * @param   array $atts Setup attributes.
	 *
	 * @return  Sidebar HTML (with a special class of number of included widgets).
	 */
	if ( ! function_exists( 'wma_sidebar' ) ) {
		function wma_sidebar( $atts = array() ) {
			//Set default setting attributes
				$atts = wp_parse_args( $atts, array(
						'attributes'        => '',
						'class'             => 'widget-area',
						'max_widgets_count' => 0,
						'sidebar'           => 'sidebar-1',
						'tag'               => 'div',
						'wrapper'           => array(
								'open'  => '',
								'close' => '',
							),
					) );

			//Helper variables
				$output = '';

			//Validation
				//class
					$atts['class'] = trim( 'wm-sidebar ' . trim( $atts['class'] ) );
				//max_widgets_count
					$atts['max_widgets_count'] = absint( $atts['max_widgets_count'] );
				//sidebar
					$atts['sidebar'] = trim( $atts['sidebar'] );
					if ( ! $atts['sidebar'] ) {
						$atts['sidebar'] = 'sidebar-1';
					}
				//widgets setup
					$atts['widgets'] = wp_get_sidebars_widgets();
					if ( ! is_array( $atts['widgets'] ) ) {
						$atts['widgets'] = array();
					}
					if ( isset( $atts['widgets'][ $atts['sidebar'] ] ) ) {
						$atts['widgets'] = $atts['widgets'][ $atts['sidebar'] ];
						$atts['class']  .= ' widgets-count-' . count( $atts['widgets'] );
					} else {
						$atts['widgets'] = array();
					}
				//wrapper
					if (
							! is_array( $atts['wrapper'] )
							&& ! isset( $atts['wrapper']['open'] )
							&& ! isset( $atts['wrapper']['close'] )
						) {
						$atts['wrapper'] = array(
								'open'  => '',
								'close' => '',
							);
					}
				//class
					$atts['class'] = apply_filters( WMAMP_HOOK_PREFIX . 'sidebar_classes', $atts['class'] );
					$atts['class'] = apply_filters( WMAMP_HOOK_PREFIX . 'sidebar_classes_' . $atts['sidebar'], $atts['class'] );
				//tag
					if ( in_array( 'sidebar', explode( ' ', $atts['class'] ) ) ) {
						$atts['tag'] = 'aside';
					}

				//Allow filtering the attributes
					$atts = apply_filters( WMAMP_HOOK_PREFIX . 'sidebar_atts', $atts );
					$atts = apply_filters( WMAMP_HOOK_PREFIX . 'sidebar_atts_' . $atts['sidebar'], $atts );

			//Preparing output
				if (
						is_active_sidebar( $atts['sidebar'] )
						&& (
								0 === $atts['max_widgets_count']
								|| $atts['max_widgets_count'] >= count( $atts['widgets'] )
							)
					) {

					$output .= $atts['wrapper']['open'];

						if ( function_exists( 'wmhook_sidebars_before' ) ) {
							$output .= wmhook_sidebars_before();
						}

						$output .= "\r\n\r\n" . '<' . $atts['tag'] . ' class="' . $atts['class'] . '" data-id="' . $atts['sidebar'] . '" data-widgets-count="' . count( $atts['widgets'] ) . '"' . $atts['attributes'] . '>' . "\r\n"; //data-id is to prevent double ID attributes on the website

							$output .= apply_filters( WMAMP_HOOK_PREFIX . 'sidebar_widgets_pre', '', $atts );

							if ( function_exists( 'wmhook_sidebar_top' ) ) {
								$output .= wmhook_sidebar_top();
							}

							if (
									function_exists( 'ob_start' )
									&& function_exists( 'ob_get_clean' )
								) {
								ob_start();
								dynamic_sidebar( $atts['sidebar'] );
								$output .= ob_get_clean();
							}

							if ( function_exists( 'wmhook_sidebar_bottom' ) ) {
								$output .= wmhook_sidebar_bottom();
							}

							$output .= apply_filters( WMAMP_HOOK_PREFIX . 'sidebar_widgets_post', '', $atts );

						$output .= "\r\n" . '</' . $atts['tag'] . '>' . "\r\n\r\n";

						if ( function_exists( 'wmhook_sidebars_after' ) ) {
							$output .= wmhook_sidebars_after();
						}

					$output .= $atts['wrapper']['close'];

				}

			//Output
				$output = apply_filters( WMAMP_HOOK_PREFIX . 'sidebar', $output, $atts );
				$output = apply_filters( WMAMP_HOOK_PREFIX . 'sidebar_' . $atts['sidebar'], $output, $atts );
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_sidebar' . '_output', $output, $atts );
		}
	} // /wma_sidebar



	/**
	 * WebMan custom shortcode attributes parser
	 *
	 * Matches predefined array ($defaults) in attributes array ($atts)
	 * and creates a new item $atts['attributes'] with all the additional
	 * custom attributes and their values set for shortcode.
	 * Custom attributes can be written as "custom_attribute" while they
	 * will be outputted as "custom-attribute". The "customAttribute"
	 * attribute name is outputted as "customattribute".
	 * No need to put the attribute names to lowercase as WordPress
	 * does this automatically.
	 *
	 * @since   1.0
	 *
	 * @param   array  $defaults
	 * @param   array  $atts
	 * @param   array  $remove    The array of custom attributes to remove (like basic required HTML element attributes for example).
	 * @param   array  $aside     All the custom attributes of names from this array will be put as new $atts item ($atts[aside]=value).
	 * @param   string $shortcode
	 *
	 * @return  array Custom attributes are returned as sting of custom-attribute="value" inside the $atts['attributes'].
	 */
	if ( ! function_exists( 'wma_shortcode_custom_atts' ) ) {
		function wma_shortcode_custom_atts( $defaults = array(), $atts = array(), $remove = array(), $aside = array(), $shortcode = '' ) {
			//Do nothing if $defaults or $atts array is empty
				if ( empty( $defaults ) ) {
					return;
				}
				$atts = (array) $atts;

			//Backup all initial shortcode attributes
				$atts_custom = $atts;

			//Run the basic shortcodes attributes comparison
				$atts = shortcode_atts( $defaults, $atts, $shortcode );

			//Get the difference between original (backed up) attributes, the default ones, minus the reserved attributes (to be removed)
				$atts_custom = array_diff_key( $atts_custom, $atts, array_flip( $remove ) );

			//Setting up the output
				$atts['attributes'] = '';
				if ( ! empty( $atts_custom ) ) {
					foreach ( $atts_custom as $attribute => $value ) {
						//If you set a "custom-attribute=1" in the shortcode, WordPress just adds the whole attribute+value pair
						//to the attributes array and will not use the attribute name as the key for the array item.
						//That's why we need to check if the key is numeric and if it is, just add the whole value to custom attributes.
						if ( ! is_numeric( $attribute ) ) {
							//Processing aside attributes (excluded from $atts['attributes'])
								if ( in_array( trim( $attribute ), $aside ) ) {
									$atts[trim( $attribute )] = esc_attr( $value );
									continue;
								}
							//Processing "custom_attribute" names
								$attribute           = str_replace( '_', '-', sanitize_title( trim( $attribute ) ) );
								$atts['attributes'] .= ' ' . $attribute . '="' . esc_attr( $value ) . '"';
						} else {
							//Processing "custom-attribute" names
								$atts['attributes'] .= ' ' . $value;
						}
					}
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_shortcode_custom_atts' . '_output', $atts, $defaults, $remove, $aside, $shortcode );
		}
	} // /wma_shortcode_custom_atts



	/**
	 * Pagination
	 *
	 * Supports WP-PageNavi plugin (@link http://wordpress.org/plugins/wp-pagenavi/).
	 *
	 * @since   1.0
	 *
	 * @param   array $atts Setup attributes.
	 *
	 * @return  Pagination HTML.
	 */
	if ( ! function_exists( 'wma_pagination' ) ) {
		function wma_pagination( $atts = array() ) {
			//Set default setting attributes
				$atts = wp_parse_args( $atts, apply_filters( WMAMP_HOOK_PREFIX . 'wma_pagination' . '_atts_defaults', array(
						'after_output'   => '</div>',
						'before_output'  => '<div class="wm-pagination">',
						'echo'           => true,
						'label_next'     => '&raquo;',
						'label_previous' => '&laquo;',
						'query'          => null,
					) ) );
				$atts = apply_filters( WMAMP_HOOK_PREFIX . 'wma_pagination' . '_atts', $atts );

			//WP-PageNavi plugin support (http://wordpress.org/plugins/wp-pagenavi/)
				if ( function_exists( 'wp_pagenavi' ) ) {
					//Set up WP-PageNavi attributes
						$atts_pagenavi = array(
								'echo'    => false,
								'options' => array(
										'next_text' => $atts['label_next'],
										'prev_text' => $atts['label_previous'],
									),
							);
						if ( $atts['query'] ) {
							$atts_pagenavi['query'] = $atts['query'];
						}
						$atts_pagenavi = apply_filters( WMAMP_HOOK_PREFIX . 'wma_pagination' . '_wppagenavi_atts', $atts_pagenavi, $atts );

					//Output
						$output = apply_filters( WMAMP_HOOK_PREFIX . 'wma_pagination' . '_output', $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'], $atts );
						if ( $atts['echo'] ) {
							echo $output;
							return;
						} else {
							return $output;
						}
				}

			//If no WP-PageNavi plugin used, output our own pagination (using WordPress native paginate_links() function)
				global $wp_query, $wp_rewrite;

				//Override global WordPress query if custom used
					if ( $atts['query'] ) {
						$wp_query = $atts['query'];
					}

				//WordPress pagination settings
					$pagination = array(
							'base'      => @add_query_arg( 'paged', '%#%' ),
							'format'    => '',
							'current'   => max( 1, get_query_var( 'paged' ) ),
							'total'     => $wp_query->max_num_pages,
							'prev_text' => $atts['label_previous'],
							'next_text' => $atts['label_next'],
						);

				//Nice URLs
					if ( $wp_rewrite->using_permalinks() ) {
						$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
					}

				//Search page
					if ( get_query_var( 's' ) ) {
						$pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );
					}

				//Output
					if ( 1 < $wp_query->max_num_pages ) {
						$output = apply_filters( WMAMP_HOOK_PREFIX . 'wma_pagination' . '_output', $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'], $atts );
						if ( $atts['echo'] ) {
							echo $output;
						} else {
							return $output;
						}
					}
		}
	} // /wma_pagination



	/**
	 * Hex color to RGB
	 *
	 * @since    1.0
	 * @version  1.1.2
	 *
	 * @param   string $hex
	 *
	 * @return  array( 'r' => [0-255], 'g' => [0-255], 'b' => [0-255] )
	 */
	if ( ! function_exists( 'wma_color_hex_to_rgb' ) ) {
		function wma_color_hex_to_rgb( $hex ) {
			//Helper variables
				$rgb = array();

			//Checking input
				$hex = trim( $hex, '#' );
				$hex = preg_replace( '/[^0-9A-Fa-f]/', '', $hex );
				$hex = substr( $hex, 0, 6 );

			//Converting hex color into rgb
				//Converting hex color into rgb
					$color = (int) hexdec( $hex );

					$rgb['r'] = (int) 0xFF & ( $color >> 0x10 );
					$rgb['g'] = (int) 0xFF & ( $color >> 0x8 );
					$rgb['b'] = (int) 0xFF & $color;

			//Return RGB array
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_color_hex_to_rgb' . '_output', $rgb, $hex );
		}
	} // /wma_color_hex_to_rgb



	/**
	 * Color brightness detection
	 *
	 * @since   1.0
	 *
	 * @param   string $hex
	 *
	 * @return  integer (0-255)
	 */
	if ( ! function_exists( 'wma_color_brightness' ) ) {
		function wma_color_brightness( $hex ) {
			//Helper variables
				$output = '';

			//Processing
				$rgb = wma_color_hex_to_rgb( $hex );
				if ( ! empty( $rgb ) ) {
					$output = absint( ( ( $rgb['r'] * 299 ) + ( $rgb['g'] * 587 ) + ( $rgb['b'] * 114 ) ) / 1000 ); //returns value from 0 to 255
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_color_brightness' . '_output', $output, $hex );
		}
	} // /wma_color_brightness



	/**
	 * Alter color brightness
	 *
	 * @since   1.0
	 *
	 * @param   string  $hex
	 * @param   integer $step
	 *
	 * @return  string Hex color.
	 */
	if ( ! function_exists( 'wma_alter_color_brightness' ) ) {
		function wma_alter_color_brightness( $hex, $step ) {
			//Helper variables
				$output = '';

			//Processing
				$rgb = wma_color_hex_to_rgb( $hex );
				if ( ! empty( $rgb ) ) {
					foreach ( $rgb as $key => $value ) {
						$new_hex_part = dechex( max( 0, min( 255, $value + intval( $step ) ) ) );
						$rgb[ $key ]  = ( 1 == strlen( $new_hex_part ) ) ? ( '0' . $new_hex_part ) : ( $new_hex_part );
					}
					$output = '#' . implode( '', $rgb );
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_alter_color_brightness' . '_output', $output, $hex, $step );
		}
	} // /wma_alter_color_brightness



	/**
	 * Modifying input color by changing brightness in response to treshold
	 *
	 * @since    1.0
	 * @version  1.0.9
	 *
	 * @param    string  $color                 Hex color
	 * @param    integer $dark_light [-255,255] Brightness modification when below treshold (array or number)
	 * @param    string  $addons                Additional CSS rules (such as "!important")
	 * @param    integer $treshold [0,255]
	 *
	 * @return   string Hex color.
	 */
	if ( ! function_exists( 'wma_contrast_color' ) ) {
		function wma_contrast_color( $color, $dark_light, $addons = '', $treshold = 0 ) {
			//Requirements check
				if ( ! trim( $color ) ) {
					return;
				}

			//Helper variables
				$output = '';

				if ( ! $treshold ) {
					$treshold = apply_filters( WMAMP_HOOK_PREFIX . 'wma_contrast_color' . '_default_treshold', WMAMP_COLOR_BRIGHTNESS_TRESHOLD );
					$treshold = apply_filters( WMAMP_HOOK_PREFIX . 'color_brightness_treshold', $treshold );
				}

				if ( is_array( $dark_light ) ) {
					$dark  = intval( $dark_light[0] );
					$light = ( isset( $dark_light[1] ) ) ? ( intval( $dark_light[1] ) ) : ( -$dark );
				} else {
					$dark  = intval( $dark_light );
					$light = -$dark;
				}

			//Processing
				$output = ( $treshold > wma_color_brightness( $color ) ) ? ( wma_alter_color_brightness( $color, $dark ) ) : ( wma_alter_color_brightness( $color, $light ) );
				if ( $output ) {
					$output .= $addons;
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_contrast_color' . '_output', $output, $color, $dark_light, $addons, $treshold );
		}
	} // /wma_contrast_color



	/**
	 * CSS3 linear gradient builder
	 *
	 * IMPORTANT: The first "background-image:" is omitted here (to make it easier as conditional output)!
	 *
	 * @since   1.0
	 *
	 * @param   string  $color               Gradient bottom base hex color
	 * @param   integer $brighten [-255,255] Gradient top color brightening (default 17 DEC = 11 HEX)
	 * @param   string  $addons              Additional CSS rules (such as "!important")
	 *
	 * @return  string CSS3 gradient styles.
	 */
	if ( ! function_exists( 'wma_css3_gradient' ) ) {
		function wma_css3_gradient( $color, $brighten = 17, $addons = '' ) {
			//Helper variables
				$output = '';

			//Processing
				$color  = preg_replace( '/[^0-9A-Fa-f]/', '', $color );
				$color  = ( 6 > strlen( $color ) ) ? ( substr( $color, 0, 3 ) ) : ( substr( $color, 0, 6 ) );
				$addons = ( trim( $addons ) ) ? ( ' ' . trim( $addons ) ) : ( '' );

				if ( $color && 3 <= strlen( $color ) ) {
					$output .=                          '-webkit-linear-gradient(top, ' . wma_alter_color_brightness( $color, $brighten ) . ', #' . $color . ')' . $addons . ';' . "\r\n";
					$output .= "\t" . 'background-image:    -moz-linear-gradient(top, ' . wma_alter_color_brightness( $color, $brighten ) . ', #' . $color . ')' . $addons . ';' . "\r\n";
					$output .= "\t" . 'background-image:     -ms-linear-gradient(top, ' . wma_alter_color_brightness( $color, $brighten ) . ', #' . $color . ')' . $addons . ';' . "\r\n";
					$output .= "\t" . 'background-image:      -o-linear-gradient(top, ' . wma_alter_color_brightness( $color, $brighten ) . ', #' . $color . ')' . $addons . ';' . "\r\n";
					$output .= "\t" . 'background-image:         linear-gradient(top, ' . wma_alter_color_brightness( $color, $brighten ) . ', #' . $color . ')' . $addons;
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_css3_gradient' . '_output', $output, $color, $brighten, $addons );
		}
	} // /wma_css3_gradient



	/**
	 * Schema.org markup on HTML tags
	 *
	 * By default, the Schema.org markup is disabled. Please enable it in your theme
	 * by hooking onto WMAMP_HOOK_PREFIX.'disable_schema_org' filter.
	 *
	 * @link  http://schema.org/docs/gs.html
	 * @link  http://leaves-and-love.net/how-to-improve-wordpress-seo-with-schema-org/
	 *
	 * @uses  schema.org
	 *
	 * @since    1.0
	 * @version  1.1.1
	 *
	 * @param  string  $element
	 * @param  boolean $output_meta_tag  Wraps output in a <meta> tag.
	 *
	 * @return  string Schema.org HTML attributes
	 */
	if ( ! function_exists( 'wma_schema_org' ) ) {
		function wma_schema_org( $element = '', $output_meta_tag = false ) {
			//Requirements check
				if ( ! $element || apply_filters( WMAMP_HOOK_PREFIX . 'disable_schema_org', true ) ) {
					return;
				}

			//Helper variables
				$output = apply_filters( WMAMP_HOOK_PREFIX . 'schema_org_output_pre', '', $element, $output_meta_tag );

				if ( $output ) {
					return apply_filters( WMAMP_HOOK_PREFIX . 'wma_schema_org' . '_output', ' ' . $output, $element, $output_meta_tag );
				}

				$base    = apply_filters( WMAMP_HOOK_PREFIX . 'schema_org_base', 'http://schema.org/', $element, $output_meta_tag );
				$post_id = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
				$type    = wma_meta_option( 'schemaorg-type', $post_id );

				if ( empty( $type ) ) {
					$type = get_post_meta( $post_id, 'schemaorg_type', true );
				}

				//Add custom post types that describe a single item to this array
					$itempage_array = (array) apply_filters( WMAMP_HOOK_PREFIX . 'schema_org_itempage_array', array( 'wm_projects', 'jetpack-portfolio' ), $element, $output_meta_tag );

			//Generate output
				switch ( $element ) {
					case 'article':
							$output = 'itemscope itemtype="' . $base . 'Article"';
						break;

					case 'article_body':
							$output = 'itemprop="articleBody"';
						break;

					case 'author':
							$output = 'itemprop="author"';
						break;

					case 'bookmark':
							$output = 'itemprop="url"';
						break;

					case 'comment':
							$output = 'itemprop="comment"';
						break;

					case 'creative_work':
							$output = 'itemscope itemtype="' . $base . 'CreativeWork"';
						break;

					case 'creator':
							$output = 'itemprop="creator" itemscope itemtype="' . $base . 'Person"';
						break;

					case 'date_modified':
							$output = 'itemprop="dateModified"';
						break;

					case 'date_published':
					case 'publish_date':
					case 'datePublished':
							$output = 'itemprop="datePublished"';
						break;

					case 'description':
							$output = 'itemprop="description"';
						break;

					case 'entry':
							$output = 'itemscope ';

							if ( is_page() ) {
								$output .= 'itemtype="' . $base . 'WebPage"';

							} elseif ( is_singular( $itempage_array ) ) {
								$output .= 'itemprop="workExample" itemtype="' . $base . 'CreativeWork"';

							} elseif ( 'audio' === get_post_format() ) {
								$output .= 'itemtype="' . $base . 'AudioObject"';

							} elseif ( 'gallery' === get_post_format() ) {
								$output .= 'itemprop="ImageGallery" itemtype="' . $base . 'ImageGallery"';

							} elseif ( 'video' === get_post_format() ) {
								$output .= 'itemprop="video" itemtype="' . $base . 'VideoObject"';

							} else {
								$output .= 'itemprop="blogPost" itemtype="' . $base . 'BlogPosting"';

							}
						break;

					case 'entry_body':
							if ( ! is_single() ) {
								$output = 'itemprop="description"';

							} elseif ( is_page() ) {
								$output = 'itemprop="mainContentOfPage"';

							} else {
								$output = 'itemprop="articleBody"';

							}
						break;

					case 'footer':
					case 'WPFooter':
							$output = 'itemscope itemtype="' . $base . 'WPFooter"';
						break;

					case 'header':
					case 'WPHeader':
							$output = 'itemscope itemtype="' . $base . 'WPHeader"';
						break;

					case 'headline':
							$output = 'itemprop="headline"';
						break;

					case 'html':
							if ( ! $type ) {
								if ( is_singular( $itempage_array ) ) {
									$type = 'ItemPage';

								} elseif( is_singular( 'post' ) ) {
									$type = 'BlogPosting';

								} elseif( is_single() ) {
									$type = 'Article';

								} elseif( is_author() ) {
									$type = 'ProfilePage';

								} elseif( is_search() ) {
									$type = 'SearchResultsPage';

								} elseif( is_archive() ) {
									$type = 'CollectionPage';

								} else {
									$type = 'WebPage';
								}
							}
							$output = 'itemscope itemtype="' . $base . $type . '"';
						break;

					case 'image':
							$output = 'itemprop="image"';
						break;

					case 'item_list':
					case 'ItemList':
							$output = 'itemscope itemtype="' . $base . 'ItemList"';
						break;

					case 'keywords':
							$output = 'itemprop="keywords"';
						break;

					case 'main_content':
							$output = 'itemprop="mainContentOfPage" itemscope itemtype="' . $base . 'WebPageElement"';
						break;

					case 'name':
							$output = 'itemprop="name"';
						break;

					case 'navigation':
							$output = 'itemscope itemtype="' . $base . 'SiteNavigationElement"';
						break;

					case 'person':
					case 'Person':
							$output = 'itemscope itemtype="' . $base . 'Person"';
						break;

					case 'review':
							$output = 'itemprop="review" itemscope itemtype="' . $base . 'Review"';
						break;

					case 'review_body':
							$output = 'itemprop="reviewBody"';
						break;

					case 'sidebar':
					case 'WPSideBar':
							$output = 'itemscope itemtype="' . $base . 'WPSideBar"';
						break;

					case 'SiteNavigationElement':
							$output = 'itemscope itemtype="' . $base . 'SiteNavigationElement"';
						break;

					case 'text':
							$output = 'itemprop="text"';
						break;

					case 'url':
							$output = 'itemprop="url"';
						break;

					default:
							$output = $element;
						break;
				}

				$output = ' ' . $output;

				//Output in <meta> tag
					if ( $output_meta_tag ) {
						if ( false === strpos( $output, 'content=' ) ) {
							$output .= ' content="true"';
						}
						$output = '<meta ' . trim( $output ) . ' />';
					}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_schema_org' . '_output', $output, $element, $output_meta_tag );
		}
	} // /wma_schema_org



	/**
	 * Get template part (for shortcode templates)
	 *
	 * @since   1.0
	 *
	 * @param   mixed  $slug
	 * @param   string $name
	 * @param   mixed  $helper Helper variable to pass into a template file
	 *
	 * @return  void
	 */
	if ( ! function_exists( 'wma_get_template_part' ) ) {
		function wma_get_template_part( $slug, $name = '', $helper = '' ) {
			//Helper variables
				$template = '';

				$template_url = apply_filters( WMAMP_HOOK_PREFIX . 'wma_get_template_part' . '_template_url', 'webman-amplifier/' );

			//Preparing output
				//Look in yourtheme/slug-name.php and yourtheme/webman-amplifier/slug-name.php
					if ( $name ) {
						$template = locate_template( array( "{$slug}-{$name}.php", "{$template_url}{$slug}-{$name}.php" ) );
					}

				//Get default slug-name.php
					if (
							! $template
							&& $name
							&& file_exists( WMAMP_PLUGIN_DIR . "templates/{$slug}-{$name}.php" ) ) {
						$template = WMAMP_PLUGIN_DIR . "templates/{$slug}-{$name}.php";
					}

				//If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
					if ( ! $template ) {
						$template = locate_template( array( "{$slug}.php", "{$template_url}{$slug}.php" ) );
					}

				//Get default slug.php
					if (
							! $template
							&& file_exists( WMAMP_PLUGIN_DIR . "templates/{$slug}.php" ) ) {
						$template = WMAMP_PLUGIN_DIR . "templates/{$slug}.php";
					}

			//Output
				if ( $template ) {
					if ( ! $helper ) {

						load_template( $template );

					} else {

						/**
						 * Code from load_template() function
						 *
						 * Adapted for use with include() to pass $helper variable.
						 */
						global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

						if ( is_array( $wp_query->query_vars ) ) {
							extract( $wp_query->query_vars, EXTR_SKIP );
						}

						include( $template );

					}
				}
		}
	} // /wma_get_template_part



	/**
	 * Gets content of the local file
	 *
	 * @since  1.0
	 *
	 * @param  string $path
	 */
	if ( ! function_exists( 'wma_read_local_file' ) ) {
		function wma_read_local_file( $path ) {
			//Helper variables
				$output = '';

			//Preparing output
				if ( file_exists( $path ) ) {
					$fp     = fopen( $path, 'r' );
					$output = fread( $fp, filesize( $path ) );
					fclose( $fp );
				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_read_local_file' . '_output', ' ' . $output, $path );
		}
	} // /wma_read_local_file



	/**
	 * Puts content into the local file
	 *
	 * This function creates a file if it doesn't exist.
	 * Also, applies 0755 permission on the file.
	 *
	 * @since    1.0
	 * @version  1.1.2
	 *
	 * @param  string $path  Full file path.
	 * @param  string $content
	 */
	if ( ! function_exists( 'wma_write_local_file' ) ) {
		function wma_write_local_file( $path, $content ) {
			//Output
			//If file does not exist, the file is created. Otherwise, the existing file is overwritten.
				if ( file_put_contents( $path, $content, LOCK_EX ) ) {
					if ( apply_filters( WMAMP_HOOK_PREFIX . 'wma_write_local_file' . '_chmod755_enabled', true ) ) {
						@chmod( $path, 0755 );
					}

					return true;
				}
		}
	} // /wma_write_local_file



	/**
	 * Minify HTML output (to prevent wpautop)
	 *
	 * @since    1.1
	 * @version  1.1
	 *
	 * @link   http://stackoverflow.com/questions/6225351/how-to-minify-php-page-html-output
	 *
	 * @param  string $content
	 */
	if ( ! function_exists( 'wma_minify_html' ) ) {
		function wma_minify_html( $content ) {
			//Requirements check
				if (
						( isset( $_GET['wma_minify_html'] ) && ! $_GET['wma_minify_html'] )
						|| ! apply_filters( WMAMP_HOOK_PREFIX . 'wma_minify_html_enabled', true )
					) {
					return $content;
				}

			//Preparing output
				$replacements = array(
						'/\>[^\S ]+/s' => '>',   //strip whitespaces after tags, except space
						'/[^\S ]+\</s' => '<',   //strip whitespaces before tags, except space
						'/(\s)+/s'     => '\\1', //shorten multiple whitespace sequences
					);
				$content = preg_replace( array_keys( $replacements ), $replacements, $content );

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_minify_html_output', $content );
		}
	} // /wma_minify_html



	/**
	 * Get registered image sizes with dimensions
	 *
	 * @since    1.0
	 * @version  1.1
	 *
	 * @return  array Image sizes.
	 */
	if ( ! function_exists( 'wma_get_image_sizes' ) ) {
		function wma_get_image_sizes() {
			//Helper variables
				global $_wp_additional_image_sizes;

				$output   = array( 'full' => __( 'Original image size (full)', 'wm_domain' ) );
				$cropping = array( _x( 'scaled', 'WordPress image size actions.', 'wm_domain' ), _x( 'cropped', 'WordPress image size actions.', 'wm_domain' ) );

			//Preparing output
				foreach( get_intermediate_image_sizes() as $size ) {

					$crop            = '';
					$output[ $size ] = $size;

					if ( in_array( $size, array( 'thumbnail', 'medium', 'large' ) ) ) {

						if ( get_option( $size . '_crop' ) ) {
							$crop = ' / ' . $cropping[1];
						} else {
							$crop = ' / ' . $cropping[0];
						}

						$output[ $size ] .= ' (' . get_option( $size . '_size_w' ) . 'x' . get_option( $size . '_size_h' ) . $crop . ')';

					} else {

						if ( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $size ] ) ) {
							if ( $_wp_additional_image_sizes[ $size ]['crop'] ) {
								$crop = ' / ' . $cropping[1];
							} else {
								$crop = ' / ' . $cropping[0];
							}

							$output[ $size ] = $size . ' (' . $_wp_additional_image_sizes[ $size ]['width'] . 'x' . $_wp_additional_image_sizes[ $size ]['height'] . $crop . ')';
						}

					}

				}

			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_get_image_sizes_output', $output );
		}
	} // /wma_get_image_sizes



	/**
	 * Check if page builder plugin is active
	 *
	 * @since    1.1
	 * @version  1.1
	 *
	 * @return  boolean
	 */
	if ( ! function_exists( 'wma_is_active_page_builder' ) ) {
		function wma_is_active_page_builder() {
			//Output
				return apply_filters( WMAMP_HOOK_PREFIX . 'wma_is_active_page_builder_output', ( wma_is_active_vc() || ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_enabled() ) ) );
		}
	} // /wma_is_active_page_builder



		/**
		 * Check if Beaver Builder plugin is active
		 *
		 * Using loop functions, so needs to be hooked in `wp` rather then `init`.
		 *
		 * @since    1.1
		 * @version  1.1
		 *
		 * @return  boolean
		 */
		if ( ! function_exists( 'wma_is_active_bb' ) ) {
			function wma_is_active_bb() {
				//Helper variables
					$supported_post_types = get_option( '_fl_builder_post_types' );

				//Output
					if (
							class_exists( 'FLBuilder' )
							&& ! is_admin()
							&& ! empty( $supported_post_types )
							&& is_singular( (array) $supported_post_types )
							&& (
									get_post_meta( get_the_ID(), '_fl_builder_enabled', true )
									|| isset( $_GET['fl_builder'] )
								)
						) {
						return true;
					}

					return false;
			}
		} // /wma_is_active_bb



		/**
		 * Check if Visual Composer plugin is active
		 *
		 * Supports both 4.2+ plugin versions and older too.
		 *
		 * @since    1.1
		 * @version  1.1
		 *
		 * @return  boolean
		 */
		if ( ! function_exists( 'wma_is_active_vc' ) ) {
			function wma_is_active_vc() {
				//Output
					return apply_filters( WMAMP_HOOK_PREFIX . 'wma_is_active_vc_output', ( class_exists( 'Vc_Manager' ) || class_exists( 'WPBakeryVisualComposer' ) ) );
			}
		} // /wma_is_active_vc

?>