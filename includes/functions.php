<?php
/**
 * WebMan Amplifier global helper functions
 *
 * @package  WebMan Amplifier
 *
 * @since    1.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_asort( array $input_array = array() ): array {

		// Processing

			if ( ! empty( $input_array ) ) {
				asort( $input_array );
			} else {
				$input_array = array();
			}


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_asort_output', $input_array );

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
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_ksort( array $input_array = array() ): array {

		// Processing

			if ( ! empty( $input_array ) ) {
				ksort( $input_array );
			} else {
				$input_array = array();
			}


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_ksort_output', $input_array );

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
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_supports_subfeature( string $subfeature = '' ): bool {

		// Variables

			$supported            = (array) get_theme_support( 'webman-amplifier' );
			$supported_shortcodes = (array) get_theme_support( 'webman-shortcodes' );

			$supported = array_filter( array_merge( (array) $supported[0], (array) $supported_shortcodes[0] ) );


		// Processing

			if (
				trim( $subfeature )
				&& is_array( $supported )
				&& ! empty( $supported )
			) {
				return in_array( $subfeature, $supported );
			}


		// Output

			return false;

	}
} // /wma_supports_subfeature



/**
 * Create permalinks settings field in WordPress admin
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param  array $args
 */
if ( ! function_exists( 'wma_permalinks_render_field' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_permalinks_render_field( array $args = array() ) {

		// Processing

			// Arguments

				if ( ! empty( $args['name'] ) ) {
					$args['name'] = trim( $args['name'] );
				} else {
					return '';
				}

				if ( ! empty( $args['placeholder'] ) ) {
					$args['placeholder'] = trim( $args['placeholder'] );
				}

			// Get value

				$value = get_option( 'wmamp-permalinks' );

				if (
					is_array( $value )
					&& isset( $value[ $args['name'] ] )
				) {
					$value = untrailingslashit( $value[ $args['name'] ] );
				} else {
					$value = '';
				}


		// Output

			echo wp_kses(
				(string) apply_filters(
					'wmhook_wmamp_wma_permalinks_render_field_output',
					'<input '
					. 'name="wmamp-permalinks[' . esc_attr( $args['name'] ) . ']" '
					. 'type="text" '
					. 'value="' . esc_attr( $value ) . '" '
					. 'placeholder="' . esc_attr( $args['placeholder'] ) . '" '
					. 'class="regular-text code" '
					. '/>',
					$args
				),
				WMA_KSES::$prefix . 'form'
			);

	}
} // /wma_permalinks_render_field



/**
 * Get post meta option
 *
 * @since    1.0
 * @version  1.4.4
 *
 * @param    string  $name    Meta option name.
 * @param    integer $post_id Specific post ID.
 *
 * @return   mixed
 */
if ( ! function_exists( 'wma_meta_option' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_meta_option( string $name, $post_id = null ) {

		// Requirements check

			$post_id = absint( $post_id );
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}

			if (
				! trim( $name )
				|| ! $post_id
			) {
				return;
			}


		// Variables

			$output = apply_filters( 'wmhook_wmamp_wma_meta_option_output_pre', '', $name, $post_id );

			// Premature output
			if ( $output ) {
				return $output;
			}

			$meta_array_name = apply_filters( 'wmhook_wmamp_wma_meta_option_meta_array_name', WM_METABOX_SERIALIZED_NAME, $name, $post_id );
			$meta_prefix     = apply_filters( 'wmhook_wmamp_wma_meta_option_meta_prefix', WM_METABOX_FIELD_PREFIX, $name, $post_id );


		// Processing

			$meta = get_post_meta( $post_id, $meta_array_name, true );
			$name = $meta_prefix . $name;

			if ( isset( $meta[ $name ] ) && $meta[ $name ] ) {

				if ( is_array( $meta[ $name ] ) ) {
					$output = $meta[ $name ];
				} else {
					$output = stripslashes( $meta[ $name ] );
				}
			}

		// Output

			return apply_filters( 'wmhook_wmamp_wma_meta_option_output', $output, $name, $post_id );

	}
} // /wma_meta_option



/**
 * Taxonomy list
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param  array $args
 *
 * @return  array Array of taxonomy slug => name.
 */
if ( ! function_exists( 'wma_taxonomy_array' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_taxonomy_array( array $args = array() ): array {

		// Variables

			$output = array();

			$args = wp_parse_args( $args, array(

				// "All" option

					'all'           => true, // Display "all" option?
					'all_post_type' => 'post', // Post type to count posts for "all" option, if left empty, the posts count will not be displayed
					'all_text'      => '- ' . __( 'All posts', 'webman-amplifier' ), // "All" option text

				// Query settings

					'hierarchical' => '1', // Is taxonomy hierarchical?
					'order_by'     => 'name',
					'parents_only' => false, // Should return parent (highest level) terms only?
					'hide_empty'   => 0,

				// Default returns

					'return'   => 'slug', // What should be returned from the term, `slug` or `term_id`?
					'tax_name' => 'category',

			) );


		// Requirements check

			if ( ! taxonomy_exists( $args['tax_name'] ) ) {
				return apply_filters( 'wmhook_wmamp_taxonomy_array', $output, $args );
			}


		// Processing

			// Get terms

				$terms = get_terms( array(
					'taxonomy'     => $args['tax_name'],
					'orderby'      => $args['order_by'],
					'hide_empty'   => $args['hide_empty'],
					'hierarchical' => $args['hierarchical'],
				) );

			// Set "All" option

				if ( $args['all'] ) {

					if ( ! $args['all_post_type'] ) {

						$all_count = '';

					} else {

						$readable  = ( in_array( $args['all_post_type'], array( 'post', 'page' ) ) ) ? ( 'readable' ) : ( null );
						$all_count = wp_count_posts( $args['all_post_type'], $readable );
						$all_count = ' (' . absint( $all_count->publish ) . ')';
					}

					$output[''] = apply_filters( 'wmhook_wmamp_taxonomy_array_all', $args['all_text'] . $all_count, $args, $all_count );
				}

			// Adding actual terms into output array
			if (
				! is_wp_error( $terms )
				&& is_array( $terms )
				&& ! empty( $terms )
			) {

				foreach ( $terms as $term ) {

					$term = (array) $term; // Converting object to array to prevent PHP issues with passing the `$args['return']` value

					if ( ! $args['parents_only'] ) {

						// All terms including children
						$output[ $term[ $args['return'] ] ]  = $term['name'];
						$output[ $term[ $args['return'] ] ] .= ( ! $args['all_post_type'] ) ? ( '' ) : ( apply_filters( 'wmhook_wmamp_taxonomy_array_count', ' (' . $term['count'] . ')', $args, $term['count'] ) );

					} elseif ( $args['parents_only'] && empty( $term['parent'] ) ) {

						// Get only parent terms and no children
						$output[ $term[ $args['return'] ] ]  = $term['name'];
						$output[ $term[ $args['return'] ] ] .= ( ! $args['all_post_type'] ) ? ( '' ) : ( apply_filters( 'wmhook_wmamp_taxonomy_array_count', ' (' . $term['count'] . ')', $args, $term['count'] ) );
					}
				}
			}

			// Sort the array alphabetically
			if ( ! $args['hierarchical'] ) {
				asort( $output );
			}


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_taxonomy_array_output', $output, $args );

	}
} // /wma_taxonomy_array



/**
 * Posts list - returns array [post_name (slug) => name]
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param    string $return    What field to return ('post_name' or 'ID').
 * @param    string $post_type What custom post type to return (defaults to "post").
 *
 * @return   array Array of post slug => name.
 */
if ( ! function_exists( 'wma_posts_array' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_posts_array( string $return = 'post_name', string $post_type = 'post' ): array {

		// Variables

			$args = array(
				'posts_per_page' => -1,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'post_type'      => $post_type,
				'post_status'    => 'publish',
			);

			$posts  = get_posts( $args );
			$output = array();


		// Requirements check

			if ( ! post_type_exists( $post_type ) ) {
				return apply_filters( 'wmhook_wmamp_posts_array', $output, $return, $post_type );
			}


		// Processing

			$output[''] = (string) apply_filters( 'wmhook_wmamp_wma_posts_array_select_text', esc_html__( '- Select item -', 'webman-amplifier' ), $return, $post_type );

			if (
				is_array( $posts )
				&& ! empty( $posts )
			) {

				foreach ( $posts as $post ) {

					//Set return parameter
					$return_param = ( 'post_name' == $return ) ? ( $post->post_name ) : ( $post->ID );

					$output[$return_param] = trim( wp_strip_all_tags( $post->post_title ) );
				}
			}

			// Sort alphabetically
			asort( $output );


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_posts_array_output', $output, $return, $post_type );

	}
} // /wma_posts_array



/**
 * Pages list - returns array [post_name (slug) => name]
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param    string $return What field to return ('post_name' or 'ID').
 *
 * @return   array Array of page slug => name.
 */
if ( ! function_exists( 'wma_pages_array' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_pages_array( string $return = 'post_name' ): array {

		// Variables

			$args = apply_filters(
				'wmhook_wmamp_wma_pages_array_args',
				array(
					'sort_order'  => 'ASC',
					'sort_column' => 'post_title',
				),
				$return
			);

			$pages  = get_pages( $args );
			$output = array();


		// Processing

			$output[''] = (string) apply_filters( 'wmhook_wmamp_wma_pages_array_select_text', esc_html__( '- Select a page -', 'webman-amplifier' ), $return );

			if (
				is_array( $pages )
				&& ! empty( $pages )
			) {

				foreach ( $pages as $page ) {

					$indents   = $page_path = '';
					$ancestors = get_post_ancestors( $page->ID );

					if ( ! empty( $ancestors ) ) {

						// Process ancestors
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

					// Set return parameter
					$return_param = ( 'post_name' == $return ) ? ( $page_path ) : ( $page->ID );

					$output[$return_param] = $indents . trim( wp_strip_all_tags( $page->post_title ) );
				}
			}


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_pages_array_output', $output, $return );

	}
} // /wma_pages_array



/**
 * Get array of widget areas
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @return   array Array of widget area id => name.
 */
if ( ! function_exists( 'wma_widget_areas_array' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_widget_areas_array(): array {

		// Variables

			global $wp_registered_sidebars;

			$output = array();


		// Processing

			$output[''] = (string) apply_filters( 'wmhook_wmamp_wma_widget_areas_array_select_text', esc_html__( '- Select area -', 'webman-amplifier' ) );

			if (
				is_array( $wp_registered_sidebars )
				&& ! empty( $wp_registered_sidebars )
			) {

				foreach ( $wp_registered_sidebars as $area ) {
					$output[ $area['id'] ] = $area['name'];
				}
			}

			// Sort alphabetically
			asort( $output );


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_widget_areas_array_output', $output );

	}
} // /wma_widget_areas_array



/**
 * Sidebar (display widget area)
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param  array $atts Setup attributes.
 *
 * @return  Sidebar HTML (with a special class of number of included widgets).
 */
if ( ! function_exists( 'wma_sidebar' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_sidebar( array $atts = array() ): string {

		// Set default setting attributes
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


		// Variables

			$output = '';


		// Validation

			// class
			$atts['class'] = trim( 'wm-sidebar ' . trim( $atts['class'] ) );

			// max_widgets_count
			$atts['max_widgets_count'] = absint( $atts['max_widgets_count'] );

			// sidebar
			$atts['sidebar'] = trim( $atts['sidebar'] );
			if ( ! $atts['sidebar'] ) {
				$atts['sidebar'] = 'sidebar-1';
			}

			// widgets setup

				/**
				 * Code from `wp_get_sidebars_widgets()` function, which can not be used in plugins.
				 *
				 * @link  https://developer.wordpress.org/reference/functions/wp_get_sidebars_widgets/
				 */

					global $_wp_sidebars_widgets, $sidebars_widgets;

					/*
					 * If loading from front page, consult $_wp_sidebars_widgets rather than options
					 * to see if wp_convert_widget_settings() has made manipulations in memory.
					 */
					if ( ! is_admin() ) {
						if ( empty( $_wp_sidebars_widgets ) ) {
							$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
						}

						$sidebars_widgets = $_wp_sidebars_widgets;
					} else {
						$sidebars_widgets = get_option( 'sidebars_widgets', array() );
					}

					if ( is_array( $sidebars_widgets ) && isset( $sidebars_widgets['array_version'] ) ) {
						unset( $sidebars_widgets['array_version'] );
					}

				// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WordPress filter applied
				$atts['widgets'] = apply_filters( 'sidebars_widgets', $sidebars_widgets );

				if ( ! is_array( $atts['widgets'] ) ) {
					$atts['widgets'] = array();
				}

				if ( isset( $atts['widgets'][ $atts['sidebar'] ] ) ) {
					$atts['widgets'] = $atts['widgets'][ $atts['sidebar'] ];
					$atts['class']  .= ' widgets-count-' . count( $atts['widgets'] );
				} else {
					$atts['widgets'] = array();
				}

			// wrapper
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

			// class
			$atts['class'] = (string) apply_filters( 'wmhook_wmamp_sidebar_classes', $atts['class'] );
			$atts['class'] = (string) apply_filters( 'wmhook_wmamp_sidebar_classes_' . $atts['sidebar'], $atts['class'] );

			// tag
			if ( in_array( 'sidebar', explode( ' ', $atts['class'] ) ) ) {
				$atts['tag'] = 'aside';
			}

			// Allow filtering the attributes
			$atts = (array) apply_filters( 'wmhook_wmamp_sidebar_atts', $atts );
			$atts = (array) apply_filters( 'wmhook_wmamp_sidebar_atts_' . $atts['sidebar'], $atts );


		// Processing

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

					$output .=
						PHP_EOL . PHP_EOL
						. '<' . tag_escape( $atts['tag'] )
						. ' class="' . esc_attr( $atts['class'] ) . '"'
						. ' data-id="' . esc_attr( $atts['sidebar'] ) . '"' // data-id is to prevent double ID attributes on the website
						. ' data-widgets-count="' . esc_attr( count( $atts['widgets'] ) ) . '"'
						. $atts['attributes']
						. '>'
						. PHP_EOL;

						$output .= (string) apply_filters( 'wmhook_wmamp_sidebar_widgets_pre', '', $atts );

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

						$output .= (string) apply_filters( 'wmhook_wmamp_sidebar_widgets_post', '', $atts );

					$output .= PHP_EOL . '</' . tag_escape( $atts['tag'] ) . '>' . PHP_EOL . PHP_EOL;

					if ( function_exists( 'wmhook_sidebars_after' ) ) {
						$output .= wmhook_sidebars_after();
					}

				$output .= $atts['wrapper']['close'];
			}


		// Output

			$output = (string) apply_filters( 'wmhook_wmamp_sidebar', $output, $atts );
			$output = (string) apply_filters( 'wmhook_wmamp_sidebar_' . $atts['sidebar'], $output, $atts );

			return (string) apply_filters( 'wmhook_wmamp_wma_sidebar_output', $output, $atts );

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
 * @since    1.0
 * @version  1.6.0
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
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_shortcode_custom_atts( array $defaults = array(), array $atts = array(), array $remove = array(), array $aside = array(), string $shortcode = '' ): array {

		// Do nothing if $defaults or $atts array is empty

			if ( empty( $defaults ) ) {
				return [];
			}
			$atts = (array) $atts;

		// Backup all initial shortcode attributes
		$atts_custom = $atts;

		// Run the basic shortcodes attributes comparison
		$atts = shortcode_atts( $defaults, $atts, $shortcode );

		// Get the difference between original (backed up) attributes, the default ones, minus the reserved attributes (to be removed)
		$atts_custom = array_diff_key( $atts_custom, $atts, array_flip( $remove ) );

		// Setting up the output

			$atts['attributes'] = '';

			if ( ! empty( $atts_custom ) ) {
				foreach ( $atts_custom as $attribute => $value ) {

					//If you set a "custom-attribute=1" in the shortcode, WordPress just adds the whole attribute+value pair
					//to the attributes array and will not use the attribute name as the key for the array item.
					//That's why we need to check if the key is numeric and if it is, just add the whole value to custom attributes.
					if ( ! is_numeric( $attribute ) ) {

						// Processing aside attributes (excluded from $atts['attributes'])
						if ( in_array( trim( $attribute ), $aside ) ) {
							$atts[trim( $attribute )] = esc_attr( $value );
							continue;
						}

						// Processing "custom_attribute" names
						$attribute           = str_replace( '_', '-', sanitize_title( trim( $attribute ) ) );
						$atts['attributes'] .= ' ' . sanitize_html_class( $attribute ) . '="' . esc_attr( $value ) . '"';

					} else {
						// Processing "custom-attribute" names
						$atts['attributes'] .= ' ' . $value;
					}
				}
			}


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_shortcode_custom_atts_output', $atts, $defaults, $remove, $aside, $shortcode );

	}
} // /wma_shortcode_custom_atts



/**
 * Pagination
 *
 * Supports WP-PageNavi plugin (@link http://wordpress.org/plugins/wp-pagenavi/).
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param  array $atts Setup attributes.
 *
 * @return  Pagination HTML.
 */
if ( ! function_exists( 'wma_pagination' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_pagination( array $atts = array() ) {

		// Set default setting attributes

			$atts = wp_parse_args( $atts, apply_filters( 'wmhook_wmamp_wma_pagination_atts_defaults', array(
				'after_output'   => '</div>',
				'before_output'  => '<div class="wm-pagination">',
				'echo'           => true,
				'label_next'     => '&raquo;',
				'label_previous' => '&laquo;',
				'query'          => null,
			) ) );

			$atts = (array) apply_filters( 'wmhook_wmamp_wma_pagination_atts', $atts );

		// WP-PageNavi plugin support (http://wordpress.org/plugins/wp-pagenavi/)
		if ( function_exists( 'wp_pagenavi' ) ) {

			// Set up WP-PageNavi attributes

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

				$atts_pagenavi = apply_filters( 'wmhook_wmamp_wma_pagination_wppagenavi_atts', $atts_pagenavi, $atts );


			// Output

				$output = (string) apply_filters( 'wmhook_wmamp_wma_pagination_output', $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'], $atts );

				if ( $atts['echo'] ) {
					echo wp_kses_post( $output );
					return;
				} else {
					return $output;
				}
		}

		// If no WP-PageNavi plugin used, output our own pagination (using WordPress native paginate_links() function)

			global $wp_query, $wp_rewrite;

			// Override global WordPress query if custom used
			if ( $atts['query'] ) {
				$wp_query = $atts['query'];
			}

			// WordPress pagination settings
			$pagination = array(
				'prev_text' => $atts['label_previous'],
				'next_text' => $atts['label_next'],
			);


		// Output

			if ( 1 < $wp_query->max_num_pages ) {

				$output = (string) apply_filters( 'wmhook_wmamp_wma_pagination_output', $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'], $atts );

				if ( $atts['echo'] ) {
					echo wp_kses_post( $output );
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
 * @version  1.6.0
 *
 * @param   string|mixed $hex
 *
 * @return  array( 'r' => [0-255], 'g' => [0-255], 'b' => [0-255] )
 */
if ( ! function_exists( 'wma_color_hex_to_rgb' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_color_hex_to_rgb( $hex = '' ): array {

		// Variables

			$rgb = array();
			$hex = (string) $hex;


		// Checking input

			$hex = trim( $hex, '#' );
			$hex = preg_replace( '/[^0-9A-Fa-f]/', '', $hex );
			$hex = substr( $hex, 0, 6 );


		// Converting hex color into rgb

			// Converting hex color into rgb
			$color = (int) hexdec( $hex );

			$rgb['r'] = (int) 0xFF & ( $color >> 0x10 );
			$rgb['g'] = (int) 0xFF & ( $color >> 0x8 );
			$rgb['b'] = (int) 0xFF & $color;


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_color_hex_to_rgb_output', $rgb, $hex );

	}
} // /wma_color_hex_to_rgb



/**
 * Color brightness detection
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param   string|mixed $hex
 *
 * @return  integer (0-255)
 */
if ( ! function_exists( 'wma_color_brightness' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_color_brightness( $hex = '' ): int {

		// Variables

			$output = '';
			$hex    = (string) $hex;


		// Processing

			$rgb = wma_color_hex_to_rgb( $hex );

			if ( ! empty( $rgb ) ) {
				$output = absint( ( ( $rgb['r'] * 299 ) + ( $rgb['g'] * 587 ) + ( $rgb['b'] * 114 ) ) / 1000 ); // returns value from 0 to 255
			}


		// Output

			return absint( apply_filters( 'wmhook_wmamp_wma_color_brightness_output', $output, $hex ) );

	}
} // /wma_color_brightness



/**
 * Alter color brightness
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param   string|mixed $hex
 * @param   integer      $step
 *
 * @return  string Hex color.
 */
if ( ! function_exists( 'wma_alter_color_brightness' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_alter_color_brightness( $hex = '', int $step = 0 ): string {

		// Variables

			$output = '';
			$hex    = (string) $hex;


		// Processing

			$rgb = wma_color_hex_to_rgb( $hex );

			if ( ! empty( $rgb ) ) {

				foreach ( $rgb as $key => $value ) {
					$new_hex_part = dechex( max( 0, min( 255, $value + intval( $step ) ) ) );
					$rgb[ $key ]  = ( 1 == strlen( $new_hex_part ) ) ? ( '0' . $new_hex_part ) : ( $new_hex_part );
				}

				$output = '#' . implode( '', $rgb );
			}


		// Output

			return (string) apply_filters( 'wmhook_wmamp_wma_alter_color_brightness_output', $output, $hex, $step );

	}
} // /wma_alter_color_brightness



/**
 * Modifying input color by changing brightness in response to treshold
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param    string|mixed $color                  Hex color
 * @param    integer      $dark_light [-255,255]  Brightness modification when below treshold (array or number)
 * @param    string       $addons                 Additional CSS rules (such as "!important")
 * @param    integer      $treshold [0,255]
 *
 * @return   string Hex color.
 */
if ( ! function_exists( 'wma_contrast_color' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_contrast_color( $color, int $dark_light, string $addons = '', int $treshold = 0 ): string {

		// Requirements check

			$color = (string) $color;

			if ( ! trim( $color ) ) {
				return '';
			}


		// Variables

			$output = '';

			if ( ! $treshold ) {
				$treshold = absint( apply_filters( 'wmhook_wmamp_wma_contrast_color_default_treshold', WMAMP_COLOR_BRIGHTNESS_TRESHOLD ) );
				$treshold = absint( apply_filters( 'wmhook_wmamp_color_brightness_treshold', $treshold ) );
			}

			if ( is_array( $dark_light ) ) {
				$dark  = intval( $dark_light[0] );
				$light = ( isset( $dark_light[1] ) ) ? ( intval( $dark_light[1] ) ) : ( -$dark );
			} else {
				$dark  = intval( $dark_light );
				$light = -$dark;
			}


		// Processing

			$output = ( $treshold > wma_color_brightness( $color ) ) ? ( wma_alter_color_brightness( $color, $dark ) ) : ( wma_alter_color_brightness( $color, $light ) );

			if ( $output ) {
				$output .= $addons;
			}


		// Output

			return (string) apply_filters( 'wmhook_wmamp_wma_contrast_color_output', $output, $color, $dark_light, $addons, $treshold );

	}
} // /wma_contrast_color



/**
 * CSS3 linear gradient builder
 *
 * IMPORTANT: The first "background-image:" is omitted here (to make it easier as conditional output)!
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param   string|mixed $color                Gradient bottom base hex color
 * @param   integer      $brighten [-255,255]  Gradient top color brightening (default 17 DEC = 11 HEX)
 * @param   string       $addons               Additional CSS rules (such as "!important")
 *
 * @return  string CSS3 gradient styles.
 */
if ( ! function_exists( 'wma_css3_gradient' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_css3_gradient( $color, int $brighten = 17, string $addons = '' ): string {

		// Variables

			$output = '';
			$color  = (string) $color;


		// Processing

			$color  = preg_replace( '/[^0-9A-Fa-f]/', '', $color );
			$color  = ( 6 > strlen( $color ) ) ? ( substr( $color, 0, 3 ) ) : ( substr( $color, 0, 6 ) );
			$addons = ( trim( $addons ) ) ? ( ' ' . trim( $addons ) ) : ( '' );

			if ( $color && 3 <= strlen( $color ) ) {
				$output .=
					"\t"
					. 'background-image: linear-gradient(top, '
					. wma_alter_color_brightness( $color, $brighten )
					. ', '
					. maybe_hash_hex_color( $color )
					. ')'
					. $addons;
			}


		// Output

			return (string) apply_filters( 'wmhook_wmamp_wma_css3_gradient_output', $output, $color, $brighten, $addons );

	}
} // /wma_css3_gradient



/**
 * Get template part (for shortcode templates)
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @param   string $slug
 * @param   string $name
 * @param   mixed  $helper Helper variable to pass into a template file
 *
 * @return  void
 */
if ( ! function_exists( 'wma_get_template_part' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_get_template_part( string $slug, string $name = '', $helper = false ) {

		// Variables

			$template     = '';
			$template_url = (string) apply_filters( 'wmhook_wmamp_wma_get_template_part_template_url', 'webman-amplifier/' );


		// Processing

			// Look in yourtheme/slug-name.php and yourtheme/webman-amplifier/slug-name.php
			if ( $name ) {
				$template = locate_template( array( "{$slug}-{$name}.php", "{$template_url}{$slug}-{$name}.php" ) );
			}

			// Get default slug-name.php
			if (
				! $template
				&& $name
				&& file_exists( WMAMP_PLUGIN_DIR . "templates/{$slug}-{$name}.php" )
			) {
				$template = WMAMP_PLUGIN_DIR . "templates/{$slug}-{$name}.php";
			}

			// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
			if ( ! $template ) {
				$template = locate_template( array( "{$slug}.php", "{$template_url}{$slug}.php" ) );
			}

			// Get default slug.php
			if (
				! $template
				&& file_exists( WMAMP_PLUGIN_DIR . "templates/{$slug}.php" )
			) {
				$template = WMAMP_PLUGIN_DIR . "templates/{$slug}.php";
			}


		// Output

			if ( $template ) {

				if (
					false === $helper
					|| null === $helper
				) {

					// When no `$helper` variable passed, use WordPress default functionality.
					load_template( $template );

				} else {

					/**
					 * Code from load_template() function
					 *
					 * Adapted for use with include() to pass $helper variable.
					 *
					 * @link  https://developer.wordpress.org/reference/functions/load_template/
					 */
					global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

					if ( is_array( $wp_query->query_vars ) ) {
						extract( $wp_query->query_vars, EXTR_SKIP );
					}

					include $template;
				}
			}

	}
} // /wma_get_template_part



/**
 * Minify HTML output (to prevent wpautop)
 *
 * @since    1.1
 * @version  1.6.0
 *
 * @link   http://stackoverflow.com/questions/6225351/how-to-minify-php-page-html-output
 *
 * @param  string $content
 */
if ( ! function_exists( 'wma_minify_html' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_minify_html( string $content ): string {

		// Requirements check

			if ( ! (bool) apply_filters( 'wmhook_wmamp_wma_minify_html_enabled', true ) ) {
				return $content;
			}


		// Processing

			$replacements = array(
				'/\>[^\S ]+/s' => '>',   //strip whitespaces after tags, except space
				'/[^\S ]+\</s' => '<',   //strip whitespaces before tags, except space
				'/(\s)+/s'     => '\\1', //shorten multiple whitespace sequences
			);

			$content = preg_replace( array_keys( $replacements ), $replacements, $content );


		// Output

			return (string) apply_filters( 'wmhook_wmamp_wma_minify_html_output', $content );

	}
} // /wma_minify_html



/**
 * Get registered image sizes with dimensions
 *
 * @since    1.0
 * @version  1.6.0
 *
 * @return  array Image sizes.
 */
if ( ! function_exists( 'wma_get_image_sizes' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_get_image_sizes(): array {

		// Variables

			global $_wp_additional_image_sizes;

			$output   = array( 'full' => esc_html__( 'Original image size (full)', 'webman-amplifier' ) );
			$cropping = array(
				esc_html_x( 'scaled', 'WordPress image size actions.', 'webman-amplifier' ),
				esc_html_x( 'cropped', 'WordPress image size actions.', 'webman-amplifier' ),
			);


		// Processing

			foreach( get_intermediate_image_sizes() as $size ) {

				$crop            = '';
				$output[ $size ] = $size;

				if ( in_array( $size, array( 'thumbnail', 'medium', 'large' ) ) ) {

					if ( get_option( $size . '_crop' ) ) {
						$crop = ' / ' . $cropping[1];
					} else {
						$crop = ' / ' . $cropping[0];
					}

					$output[ $size ] .=
						' ('
						. get_option( $size . '_size_w' )
						. 'x'
						. get_option( $size . '_size_h' )
						. $crop
						. ')';

				} else {

					if (
						isset( $_wp_additional_image_sizes )
						&& isset( $_wp_additional_image_sizes[ $size ] )
					) {

						if ( $_wp_additional_image_sizes[ $size ]['crop'] ) {
							$crop = ' / ' . $cropping[1];
						} else {
							$crop = ' / ' . $cropping[0];
						}

						$output[ $size ] =
							$size
							. ' ('
							. $_wp_additional_image_sizes[ $size ]['width']
							. 'x'
							. $_wp_additional_image_sizes[ $size ]['height']
							. $crop
							. ')';
					}
				}
			}


		// Output

			return (array) apply_filters( 'wmhook_wmamp_wma_get_image_sizes_output', $output );

	}
} // /wma_get_image_sizes



/**
 * Check if page builder plugin is active
 *
 * @since    1.1
 * @version  1.6.0
 *
 * @return  boolean
 */
if ( ! function_exists( 'wma_is_active_page_builder' ) ) {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
	function wma_is_active_page_builder(): bool {

		// Output

			return (bool) apply_filters(
				'wmhook_wmamp_wma_is_active_page_builder_output',
				( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_enabled() )
			);

	}
} // /wma_is_active_page_builder



	/**
	 * Check if Beaver Builder plugin is active
	 *
	 * Using loop functions, so needs to be hooked in `wp` rather then `init`.
	 *
	 * @since    1.1
	 * @version  1.1.6
	 *
	 * @return  boolean
	 */
	if ( ! function_exists( 'wma_is_active_bb' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_is_active_bb(): bool {

			// Variables

				$supported_post_types = get_option( '_fl_builder_post_types' );


			// Output

				if (
					class_exists( 'FLBuilder' )
					&& ! is_admin()
					&& ! empty( $supported_post_types )
					&& is_singular( (array) $supported_post_types )
					&& class_exists( 'FLBuilderModel' )
					&& FLBuilderModel::is_builder_active()
				) {
					return true;
				}

				return false;

		}
	} // /wma_is_active_bb
