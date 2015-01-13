<?php
/**
 * Content Module
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1
 *
 * @param  string align
 * @param  string class
 * @param  integer columns
 * @param  integer count
 * @param  integer desc_column_size
 * @param  boolean filter
 * @param  string filter_layout
 * @param  string heading_tag (heading tag setup option for better SEO)
 * @param  string image_size
 * @param  string layout (available options: content, image, morelink, tag, title)
 * @param  string module (ID or slug, if this is set, a single module will be displayed only)
 * @param  boolean no_margin
 * @param  string order
 * @param  boolean pagination
 * @param  integer scroll (value ranges: 0, 1-999, 1000+)
 * @param  string tag (module tag slug)
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'align'            => 'left',
			'class'            => '',
			'columns'          => 4,
			'count'            => -1,
			'desc_column_size' => 4,
			'filter'           => false,
			'filter_layout'    => 'fitRows',
			'heading_tag'      => 'h3',
			'image_size'       => '',
			'layout'           => '',
			'module'           => '',
			'no_margin'        => false,
			'order'            => 'new',
			'pagination'       => false,
			'scroll'           => 0,
			'tag'              => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Helper variables
	global $page, $paged;
	if ( ! isset( $paged ) ) {
		$paged = 1;
	}
	$paged                 = max( $page, $paged );
	$output                = $filter_content = '';
	$image_size            = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_image_size', 'medium' );
	$filter_settings       = false;
	$posts_container_class = 'wm-content-module-container wm-items-container';
	$masonry_layout        = false;

	//Set layouts for custom post types
		$layouts = array(
				'wm_modules' => array( 'image', 'title', 'content', 'morelink' ),
			);
		$layouts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_layouts', $layouts, $atts );

//Validation
	//post_type
		$atts['post_type'] = 'wm_modules';
	//align
		$atts['align'] = ( 'right' === trim( $atts['align'] ) ) ? ( trim( $atts['align'] ) ) : ( 'left' );
	//columns
		$atts['columns'] = absint( $atts['columns'] );
		if ( 1 > $atts['columns'] || 6 < $atts['columns'] ) {
			$atts['columns'] = 4;
		}
	//count
		$atts['count'] = intval( $atts['count'] );
	//desc_column_size
		$atts['desc_column_size'] = absint( $atts['desc_column_size'] );
		if ( 1 > $atts['desc_column_size'] || 6 < $atts['desc_column_size'] ) {
			$atts['desc_column_size'] = 4;
		}
	//filter
		$atts['filter'] = ( $atts['filter'] ) ? ( 'module_tag' ) : ( '' );
	//filter_layout
		$atts['filter_layout'] = trim( $atts['filter_layout'] );
		if ( ! $atts['filter_layout'] ) {
			$atts['filter_layout'] = 'fitRows';
		}
	//image_size
		$atts['image_size'] = trim( $atts['image_size'] );
		if ( $atts['image_size'] ) {
			$image_size = $atts['image_size'];
		}
	//layout
		$atts['layout'] = explode( ',', str_replace( ' ', '', $atts['layout'] ) );
		$atts['layout'] = array_filter( $atts['layout'] );
		if ( empty( $atts['layout'] ) ) {
			$atts['layout'] = $layouts[ $atts['post_type'] ];
		}
		foreach ( $atts['layout'] as $key => $layout ) {
			if ( strpos( $layout, ':' ) ) {
				$layout = explode( ':', trim( $layout ) );
				$atts['layout'][$layout[0]] = $layout[1];
			} else {
				$atts['layout'][$layout] = '';
			}
			unset( $atts['layout'][$key] );
		}
	//no_margin
		$atts['no_margin']      = ( trim( $atts['no_margin'] ) ) ? ( ' no-margin' ) : ( ' with-margin' );
		$posts_container_class .= $atts['no_margin'];
	//order
		$atts['order'] = trim( $atts['order'] );
		$order_method = array(
				'new'    => array( 'date', 'DESC' ),
				'old'    => array( 'date', 'ASC' ),
				'name'   => array( 'title', 'ASC' ),
				'random' => array( 'rand', '' )
			);
		$atts['order'] = ( in_array( $atts['order'], array_keys( $order_method ) ) ) ? ( $order_method[ $atts['order'] ] ) : ( $order_method['new'] );
	//tag
		$atts['tag'] = ( ! $atts['filter'] && trim( $atts['tag'] ) ) ? ( array( 'module_tag', trim( $atts['tag'] ) ) ) : ( '' );
	//module
		$atts['module'] = trim( $atts['module'] );
		if ( $atts['module'] && is_numeric( $atts['module'] ) ) {
			$atts['module'] = array( 'p', absint( $atts['module'] ) );
		} elseif ( $atts['module'] ) {
			$atts['module'] = array( 'name', $atts['module'] );
		}
		if ( $atts['module'] ) {
			$content            = '';
			$atts['class']     .= ' wm-content-module-singular';
			$atts['filter']     = false;
			$atts['pagination'] = false;
			$atts['scroll']     = 0;
		}
	//scroll
		$atts['scroll'] = absint( $atts['scroll'] );
		if ( $atts['scroll'] && 999 < $atts['scroll'] ) {
			$atts['class'] .= ' scrollable-auto';
		} elseif ( $atts['scroll'] ) {
			$atts['class'] .= ' scrollable-manual';
		}
	//content
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $content, $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//class
		if (
				! $atts['filter']
				&& false !== strpos( $atts['class'], 'masonry' )
			) {
			//Use masonry when "masonry" class set
			$posts_container_class .= ' masonry-this';
			$atts['class']          = str_replace( 'masonry', 'wm-posts-masonry-enabled', $atts['class'] );
			$masonry_layout         = true;
		}
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( trim( 'wm-content-module wm-posts-wrap clearfix ' . trim( $atts['class'] ) ) ) );

//Preparing content
	//Get the posts
		//Set query arguments
			if ( $atts['module'] ) {
				$query_args = array(
						'post_type'        => $atts['post_type'],
						$atts['module'][0] => $atts['module'][1],
					);
			} else {
				$query_args = array(
						'paged'               => ( $atts['pagination'] ) ? ( $paged ) : ( 1 ),
						'post_type'           => $atts['post_type'],
						'posts_per_page'      => $atts['count'],
						'ignore_sticky_posts' => 1,
						'orderby'             => $atts['order'][0],
						'order'               => $atts['order'][1]
					);
				if ( $atts['tag'] ) {
					$query_args['tax_query'] = array( array(
						'taxonomy' => $atts['tag'][0],
						'field'    => 'slug',
						'terms'    => explode( ',', $atts['tag'][1] )
					) );
				}
			}

			//Allow filtering the query
				$query_args = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_query_args', $query_args );

		//Set query and loop through it
			$posts = new WP_Query( $query_args );

			//Set pagination output
				if ( $atts['pagination'] ) {
					$atts['pagination'] = wma_pagination( array( 'echo' => false, 'query' => $posts ) );
				}

		if ( $posts->have_posts() ) {

			//Filter HTML
				if ( $atts['filter'] ) {

					//Continue only if the taxonomy exists
						if ( taxonomy_exists( $atts['filter'] ) ) {

							//Save the filter taxonomy settings for later use
								$filter_settings = $atts['filter'];

							//"All" item
								$filter_content .= '<li class="wm-filter-items-all active"><a href="#" data-filter="*">' . __( 'All', 'wm_domain' ) . '</a></li>';

							//Other items
								$terms = get_terms( $atts['filter'] );
								$count = count( $terms );
								if ( ! is_wp_error( $terms ) && 0 < $count ) {
									foreach ( $terms as $term ) {
										$filter_content .= '<li class="wm-filter-items-' . $term->slug . '"><a href="#" data-filter=".' . $atts['filter'] . '-' . $term->slug . '">' . $term->name . '<span class="count"> (' . $term->count . ')</span></a></li>';
									}
								}

							//Filter wrapper
								$filter_content = '<div class="wm-filter"><ul>' . $filter_content . '</ul></div>';

							//Set posts container class
								$posts_container_class .= ' filter-this';

							//Filter is prioritized over scrolling functionality, so just turn it off
								$atts['scroll'] = 0;

						} // /check if taxonomy exists

				} // /if filter

				$atts['filter'] = $filter_content;

			//Scrollable posts
				if ( $atts['scroll'] ) {

					//Set posts container class
						$posts_container_class .= ' stack';

				} // /if scroll

			//Posts grid container openings
				if ( ! $atts['module'] ) {
					$posts_container_class = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_posts_container_class', $posts_container_class );
					if ( $atts['content'] ) {
						if ( 'right' == $atts['align'] ) {
						//open posts container div only
							$output .= '<div class="wm-column width-' . ( $atts['desc_column_size'] - 1 ) . '-' . $atts['desc_column_size'] . '">' . $atts['filter'] . '<div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '" data-layout-mode="' . $atts['filter_layout'] . '">';
						} else {
						//insert posts description (shortcode content) in a column and open the posts container div
							$output .= '<div class="wm-column width-1-' . $atts['desc_column_size'] . ' wm-content-module-description">' . $atts['content'] . '</div><div class="wm-column width-' . ( $atts['desc_column_size'] - 1 ) . '-' . $atts['desc_column_size'] . ' last">' . $atts['filter'] . '<div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '" data-layout-mode="' . $atts['filter_layout'] . '">';
						}
					} else {
						$output .= $atts['filter'] . '<div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '" data-layout-mode="' . $atts['filter_layout'] . '">';
					}
				}

			//Row
				$row_condition  = ( ! $atts['module'] && ! $atts['filter'] && ! $atts['scroll'] && 1 != $atts['columns'] && ! $masonry_layout );
				$output        .= ( $row_condition ) ? ( '<div class="wm-row">' ) : ( '' );

			//Alternative item class and helper variables
				$alt = '';
				$row = $i = 0;

		//Loop the posts
			while ( $posts->have_posts() ) :
				$posts->the_post();

				$post_id = get_the_id();

				//Row
					if ( $row_condition ) {
						$row     = ( ++$i % $atts['columns'] === 1 ) ? ( $row + 1 ) : ( $row );
						$output .= ( $i % $atts['columns'] === 1 && 1 < $row ) ? ( '</div><div class="wm-row">' ) : ( '' );
					}

				//Setting up layout elements HTML
					$link = '';
					$link_atts = array( wma_meta_option( 'link-page', $post_id ), wma_meta_option( 'link', $post_id ), wma_meta_option( 'link-action', $post_id ) );
					if ( $link_atts[0] ) {
						$page_object = get_page_by_path( $link_atts[0] );
						$link = ( $page_object ) ? ( ' href="' . get_permalink( $page_object->ID ) . '"' ) : ( '#' );
					} elseif ( $link_atts[1] ) {
						$link = ' href="' . esc_url( $link_atts[1] ) . '"';
					} else {
						$link = '';
					}
					if ( $link && $link_atts[2] ) {
						$link .= ( in_array( $link_atts[2], array( '_self', '_blank' ) ) ) ? ( ' target="' . esc_attr( $link_atts[2] ) . '"' ) : ( ' data-target="' . esc_attr( $link_atts[2] ) . '"' );
					}

					$helpers = array(
							'link' => $link,
							'tag'  => ( isset( $atts['layout']['tag'] ) ) ? ( 'module_tag' ) : ( '' ),
						);
					$helpers = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_layout_elements_helpers', $helpers, $post_id, $atts );

					$layout_elements = array(
							'content'  => do_shortcode( '<div class="wm-content-module-element wm-html-element content">' . wpautop( get_the_content() ) . '</div>' ),
							'image'    => '',
							'morelink' => ( $helpers['link'] ) ? ( '<div class="wm-content-module-element wm-html-element more-link"><a' . $helpers['link'] . '>' . apply_filters( WM_SHORTCODES_HOOK_PREFIX . 'read_more_text', __( 'Read more', 'wm_domain' ), $shortcode, $post_id, $atts ) . '</a></div>' ) : ( '' ),
							'tag'      => '',
							'title'    => ( $helpers['link'] ) ? ( '<header class="wm-content-module-element wm-html-element title"><' . $atts['heading_tag'] . '><a' . $helpers['link'] . '>' . get_the_title() . '</a></' . $atts['heading_tag'] . '></header>' ) : ( '<header class="wm-content-module-element wm-html-element title"><' . $atts['heading_tag'] . '>' . get_the_title() . '</' . $atts['heading_tag'] . '></header>' ),
						);

					//image layout element
						$image = ( has_post_thumbnail( $post_id ) ) ? ( get_the_post_thumbnail( $post_id, $image_size, array( 'title' => esc_attr( get_the_title( get_post_thumbnail_id( $post_id ) ) ) ) ) ) : ( '' );

						$icon = array(
								'box'              => wma_meta_option( 'icon-box', $post_id ),
								'font'             => wma_meta_option( 'icon-font', $post_id ),
								'color'            => wma_meta_option( 'icon-color', $post_id ),
								'color-background' => wma_meta_option( 'icon-color-background', $post_id ),
							);

						$image_class     = ' featured-image';
						$style_icon      = ( $icon['color'] ) ? ( ' style="color: ' . $icon['color'] . '"' ) : ( '' );
						$style_container = ( $icon['color-background'] ) ? ( ' style="background-color: ' . $icon['color-background'] . '"' ) : ( '' );

						if ( $icon['box'] && $icon['font'] ) {
							$image       = '<i class="' . $icon['font'] . '"' . $style_icon . '></i>';
							$image_class = ' font-icon';
						}
						if ( $image && $helpers['link'] ) {
							$image = '<a' .  $helpers['link'] . '>' . $image . '</a>';
						}
						if ( $image ) {
							$layout_elements['image'] = '<div class="wm-content-module-element wm-html-element image image-container' . $image_class . '"' . $style_container . '>' . $image . '</div>';
						}

					//tag layout element
						if ( $helpers['tag'] ) {
							$terms       = get_the_terms( $post_id, $helpers['tag'] );
							$terms_array = array();
							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
								foreach( $terms as $term ) {
									$terms_array[] = '<span class="term term-' . sanitize_html_class( $term->slug ) . '">' . $term->name . '</span>';
								}
								$layout_elements['tag'] = '<div class="wm-content-module-element wm-html-element tag">' . implode( ', ', $terms_array ) . '</div>' ;
							}
						}

					//filter the elements html
						$layout_elements = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_layout_elements', $layout_elements, $post_id, $helpers, $atts );

				//Output the posts item
					$output_item = $class_item = '';
					foreach ( array_keys( $atts['layout'] ) as $layout_element ) {
						if ( isset( $layout_elements[$layout_element] ) ) {
							$output_item .= $layout_elements[$layout_element];
						}
					}

					//filter the posts item html output
						$output_item = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_item_html', $output_item, $post_id );

					//posts single item output
						$class_item .= 'wm-content-module-item wm-content-module-item-' . $post_id;
						if ( $icon['box'] ) {
							$class_item .= ' wm-iconbox-module';
						}
						if ( ! $atts['module'] ) {
							$class_item .= ' wm-column width-1-' . $atts['columns'] . $atts['no_margin'] . $alt;
						}
						if (
								! $atts['module']
								&& ( ! $atts['no_margin'] || ' with-margin' === $atts['no_margin'] )
								&& ! $atts['filter']
								&& ! $atts['scroll']
								&& ! $masonry_layout
								&& ( $i % $atts['columns'] === 0 )
							) {
							$class_item .= ' last';
						}
						if ( $atts['filter'] && $filter_settings ) {
							$terms = get_the_terms( $post_id, $filter_settings );
							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
								foreach( $terms as $term ) {
									$class_item .= ' ' . $filter_settings . '-' . $term->slug;
								}
							}
						}
						$class_item  = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_item_class', $class_item, $post_id );
						$output_item = '<div class="' . $class_item . '">' . $output_item . '</div>';

				$output .= $output_item;

				$alt = ( $alt ) ? ( '' ) : ( ' alt' );

			endwhile;

			//Row
				$output .= ( $row_condition ) ? ( '</div>' ) : ( '' );

			//Posts grid container closings
				if ( ! $atts['module'] ) {
					if ( $atts['content'] ) {
						if ( 'right' == $atts['align'] ) {
						//close posts container div and output description column
							$output .= '</div>' . $atts['pagination'] . '</div><div class="wm-column width-1-' . $atts['desc_column_size'] . ' last wm-content-module-description">' . $atts['content'] . '</div>';
						} else {
						//close the posts container div
							$output .= '</div>' . $atts['pagination'] . '</div>';
						}
					} else {
						$output .= '</div>' . $atts['pagination'];
					}
				}

		}

		//Reset query
			wp_reset_query();

	$atts['content'] = $output;

		//Enqueue scripts
			$enqueue_scripts = array();
			if ( $atts['scroll'] ) {
				$enqueue_scripts = array(
						'wm-jquery-owl-carousel',
						'wm-shortcodes-posts'
					);
			} elseif ( $atts['filter'] ) {
				$enqueue_scripts = array(
						'wm-isotope',
						'wm-shortcodes-posts'
					);
			} elseif ( $masonry_layout ) {
				$enqueue_scripts = array(
						'jquery-masonry',
						'wm-shortcodes-posts'
					);
			}

			wma_shortcode_enqueue_scripts( $shortcode, $enqueue_scripts, $atts );

//Output
	$output = '<div class="' . $atts['class'] . '">' . $atts['content'] . '</div>';

?>