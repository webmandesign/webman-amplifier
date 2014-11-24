<?php
/**
 * Posts and custom post types
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 * Contains Schema.org markup function.
 *
 * @since    1.0
 * @version  1.0.9.13
 *
 * @uses   $codes_globals['post_types']
 *
 * @param  string align
 * @param  string class
 * @param  integer columns
 * @param  integer count
 * @param  integer desc_column_size
 * @param  string filter (example: "taxonomy_name:taxonomy_slug" - "taxonomy_slug" is optional and will act like parent category)
 * @param  string filter_layout
 * @param  string heading_tag (heading tag setup option for better SEO)
 * @param  string image_size
 * @param  string layout (layout template file name)
 * @param  boolean no_margin
 * @param  string order
 * @param  boolean pagination
 * @param  string post_type
 * @param  string related (example: "taxonomy_name" - a taxonomy which should be considered as for related posts)
 * @param  integer scroll (value ranges: 0, 1-999, 1000+)
 * @param  string taxonomy (example: "taxonomy_name:taxonomy_slug" - both are required)
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'align'            => 'left',
			'class'            => '',
			'columns'          => 4,
			'count'            => -1,
			'desc_column_size' => 4,
			'filter'           => '',
			'filter_layout'    => 'fitRows',
			'heading_tag'      => 'h3',
			'image_size'       => '',
			'layout'           => '',
			'no_margin'        => false,
			'order'            => 'new',
			'pagination'       => false,
			'post_type'        => 'post',
			'related'          => '',
			'scroll'           => 0,
			'taxonomy'         => '',
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
	$excerpt_length        = 10;
	$filter_settings       = false;
	$posts_container_class = 'wm-posts-container wm-items-container';
	$masonry_layout        = false;



//Validation
	//post_type
		$atts['post_type'] = trim( $atts['post_type'] );
		$post_type         = ( ! in_array( $atts['post_type'], array_keys( $codes_globals['post_types'] ) ) ) ? ( 'default' ) : ( $atts['post_type'] );
		$image_size        = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_image_size_' . $atts['post_type'], $image_size );
	//align
		$atts['align'] = ( 'right' === trim( $atts['align'] ) ) ? ( trim( $atts['align'] ) ) : ( 'left' );
	//columns
		$atts['columns'] = absint( $atts['columns'] );
		$max_columns     = ( 'wm_logos' == $atts['post_type'] ) ? ( 9 ) : ( 6 );
		if ( 1 > $atts['columns'] || $max_columns < $atts['columns'] ) {
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
		$atts['filter'] = trim( $atts['filter'] );
		if ( strpos( $atts['filter'], ':' ) && ! $atts['taxonomy'] ) {
			$atts['taxonomy'] = $atts['filter'];
		}
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
		$atts['layout'] = trim( $atts['layout'] );
		if ( $atts['layout'] ) {
			$atts['class'] .= ' wm-posts-layout-' . $atts['layout'];
		} else {
			$atts['class'] .= ' wm-posts-layout-default';
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
	//scroll
		$atts['scroll'] = absint( $atts['scroll'] );
		if ( ! $atts['filter'] ) {
			if ( $atts['scroll'] && 999 < $atts['scroll'] ) {
				$atts['class'] .= ' scrollable-auto';
			} elseif ( $atts['scroll'] ) {
				$atts['class'] .= ' scrollable-manual';
			}
		}
	//taxonomy
		$atts['taxonomy'] = explode( ':', trim( $atts['taxonomy'] ) );
	//related
		$atts['related'] = trim( $atts['related'] );
		if (
				$atts['related']
				&& get_the_ID()
				&& taxonomy_exists( $atts['related'] )
			) {
			$atts['taxonomy'] = $atts['related'] . ':';

			$terms = get_the_terms( get_the_ID() , $atts['related'] );
			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$separator = '';
				foreach( $terms as $term ) {
					$atts['taxonomy'] .= $separator . $term->slug;
					$separator = ',';
				}
			}
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
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( trim( 'wm-posts wm-posts-wrap clearfix wm-posts-' . $atts['post_type'] . ' ' . trim( $atts['class'] ) ) ) );

//Preparing content
	//Get the posts
		//Set query arguments
			$query_args = array(
					'paged'               => ( $atts['pagination'] ) ? ( $paged ) : ( 1 ),
					'post_type'           => $atts['post_type'],
					'posts_per_page'      => $atts['count'],
					'ignore_sticky_posts' => 1,
					'orderby'             => $atts['order'][0],
					'order'               => $atts['order'][1]
				);
			if (
					is_array( $atts['taxonomy'] )
					&& 2 === count( $atts['taxonomy'] )
					&& taxonomy_exists( $atts['taxonomy'][0] )
				) {
				$query_args['tax_query'] = array( array(
					'taxonomy' => $atts['taxonomy'][0],
					'field'    => 'slug',
					'terms'    => explode( ',', $atts['taxonomy'][1] )
				) );
			}
			if ( $atts['related'] && get_the_ID() ) {
				$query_args['post__not_in'] = array( get_the_ID() );
			}

			//Allow filtering the query
				$query_args = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_query_args', $query_args );
				$query_args = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_query_args_' . $atts['post_type'], $query_args );

		//Set query and loop through it
			$posts = new WP_Query( $query_args );

			//Set pagination output
				if ( $atts['pagination'] ) {
					$atts['pagination'] = wma_pagination( array( 'echo' => false, 'query' => $posts ) );
				}

		if ( $posts->have_posts() ) {

			//Filter HTML
				if ( $atts['filter'] ) {

					//Prepare the filter taxonomy settings
						$atts['filter'] = explode( ':', $atts['filter'] );

					//Continue only if the taxonomy exists
						if ( taxonomy_exists( $atts['filter'][0] ) ) {

							//Check if parent taxonomy set, if not, set empty one
								if (
										! is_taxonomy_hierarchical( $atts['filter'][0] )
										|| ! isset( $atts['filter'][1] )
									) {
									$atts['filter'][1] = '';
								}

							//Save the filter taxonomy settings for later use
								$filter_settings = $atts['filter'];

							if ( $atts['filter'][1] ) {
							//If parent taxonomy set - filter from child taxonomies

								//"All" item
								$parent_tax = get_term_by( 'slug', $atts['filter'][1], $atts['filter'][0] );
								$filter_content .= '<li class="wm-filter-items-all active"><a href="#" data-filter="*">' . sprintf( __( 'All <span>%s</span>', 'wm_domain' ), $parent_tax->name ) . '</a></li>';

								//Other items
								$terms  = get_term_children( $parent_tax->term_id, $atts['filter'][0] );
								$count  = count( $terms );
								if ( ! is_wp_error( $terms ) && 0 < $count ) {
									$output_array = array();
									foreach ( $terms as $child ) {
										$child = get_term_by( 'id', $child, $atts['filter'][0] );
										$output_array['<li class="wm-filter-items-' . $child->slug . '"><a href="#" data-filter=".' . $atts['filter'][0] . '-' . $child->slug . '">' . $child->name . '<span class="count"> (' . $child->count . ')</span></a></li>'] = $child->name;
									}
									asort( $output_array );
									$output_array = array_flip( $output_array );
									$filter_content .= implode( '', $output_array );
								}

							} else {
							//No parent taxonomy - filter from all taxonomies

								//"All" item
								$filter_content .= '<li class="wm-filter-items-all active"><a href="#" data-filter="*">' . __( 'All', 'wm_domain' ) . '</a></li>';

								//Other items
								$terms = get_terms( $atts['filter'][0] );
								$count = count( $terms );
								if ( ! is_wp_error( $terms ) && 0 < $count ) {
									foreach ( $terms as $term ) {
										$filter_content .= '<li class="wm-filter-items-' . $term->slug . '"><a href="#" data-filter=".' . $atts['filter'][0] . '-' . $term->slug . '">' . $term->name . '<span class="count"> (' . $term->count . ')</span></a></li>';
									}
								}

							}

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
				$posts_container_class = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_posts_container_class', $posts_container_class );
				if ( $atts['content'] ) {
					if ( 'right' == $atts['align'] ) {
					//open posts container div only
						$output .= '<div class="wm-column width-' . ( $atts['desc_column_size'] - 1 ) . '-' . $atts['desc_column_size'] . '">' . $atts['filter'] . '<div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '" data-layout-mode="' . $atts['filter_layout'] . '"' . wma_schema_org( 'item_list' ) . '>';
					} else {
					//insert posts description (shortcode content) in a column and open the posts container div
						$output .= '<div class="wm-column width-1-' . $atts['desc_column_size'] . ' wm-posts-description">' . $atts['content'] . '</div><div class="wm-column width-' . ( $atts['desc_column_size'] - 1 ) . '-' . $atts['desc_column_size'] . ' last">' . $atts['filter'] . '<div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '" data-layout-mode="' . $atts['filter_layout'] . '"' . wma_schema_org( 'item_list' ) . '>';
					}
				} else {
					$output .= $atts['filter'] . '<div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '" data-layout-mode="' . $atts['filter_layout'] . '"' . wma_schema_org( 'item_list' ) . '>';
				}

			//Row
				$row_condition  = ( ! $atts['filter'] && ! $atts['scroll'] && 1 != $atts['columns'] && ! $masonry_layout );
				$output        .= ( $row_condition ) ? ( '<div class="wm-row' . $atts['no_margin'] . '">' ) : ( '' );

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
						$output .= ( $i % $atts['columns'] === 1 && 1 < $row ) ? ( '</div><div class="wm-row' . $atts['no_margin'] . '">' ) : ( '' );
					}

				//Output the posts item
					//helper variables
						$output_item = '';

						$helper = array();

						//shortcode atts
							$helper['atts'] = $atts;
						//excerpt_length
							$helper['excerpt_length'] = $excerpt_length;
						//image_size
							$helper['image_size'] = $image_size;
						//item_class
							$helper['item_class'] = 'wm-posts-item wm-posts-item-' . $post_id . ' wm-column width-1-' . $atts['columns'] . $atts['no_margin'] . $alt;
							if (
									( ! $atts['no_margin'] || ' with-margin' === $atts['no_margin'] )
									&& ! $atts['filter']
									&& ! $atts['scroll']
									&& ! $masonry_layout
									&& ( $i % $atts['columns'] === 0 )
								) {
								$helper['item_class'] .= ' last';
							}
							if ( $atts['filter'] && isset( $filter_settings[0] ) ) {
								$terms = get_the_terms( $post_id , $filter_settings[0] );
								if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
									foreach( $terms as $term ) {
										$helper['item_class'] .= ' ' . $filter_settings[0] . '-' . $term->slug;
									}
								}
							}
						//link
							$helper['link'] = '';
							$link_atts = array( wma_meta_option( 'link-page', $post_id ), wma_meta_option( 'link', $post_id ), wma_meta_option( 'link-action', $post_id ) );
							if (
									'wm_projects' == $atts['post_type']
									&& ! $link_atts[2]
								) {
								$helper['link'] = ' href="' . get_permalink() . '"';
							} elseif ( $link_atts[0] ) {
								$page_object = get_page_by_path( $link_atts[0] );
								$helper['link'] = ( $page_object ) ? ( ' href="' . get_permalink( $page_object->ID ) . '"' ) : ( '#' );
							} elseif ( $link_atts[1] ) {
								$helper['link'] = ' href="' . esc_url( $link_atts[1] ) . '"';
							} else {
								$helper['link'] = ' href="' . get_permalink() . '"';
							}
							if (
									( 'wm_staff' == $atts['post_type'] || 'wm_logos' == $atts['post_type'] )
									&& ! $link_atts[0]
									&& ! $link_atts[1]
								) {
								$helper['link'] = '';
							}
							if (
									$helper['link']
									&& $link_atts[2]
								) {
								$helper['link'] .= ( in_array( $link_atts[2], array( '_self', '_blank' ) ) ) ? ( ' target="' . esc_attr( $link_atts[2] ) . '"' ) : ( ' data-target="' . esc_attr( $link_atts[2] ) . '"' );
							}
						//post_id
							$helper['post_id'] = $post_id;

						$helper = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_helper', $helper, $post_id );

					//single post output template
						if (
								function_exists( 'ob_start' )
								&& function_exists( 'ob_get_clean' )
							) {
							ob_start();
							$template = $post_type;
							if ( $atts['layout'] ) {
								$template .= '-' . $atts['layout'];
							}
							wma_get_template_part( 'content-shortcode-' . $shortcode, $template, $helper );
							$output_item = ob_get_clean();
						}

					//filter the posts item html output
						$output_item = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_item_html', $output_item, $post_id, $atts );

				$output .= $output_item;

				$alt = ( $alt ) ? ( '' ) : ( ' alt' );

			endwhile;

			//Row
				$output .= ( $row_condition ) ? ( '</div>' ) : ( '' );

			//Posts grid container closings
				if ( $atts['content'] ) {
					if ( 'right' == $atts['align'] ) {
					//close posts container div and output description column
						$output .= '</div>' . $atts['pagination'] . '</div><div class="wm-column width-1-' . $atts['desc_column_size'] . ' last wm-posts-description">' . $atts['content'] . '</div>';
					} else {
					//close the posts container div
						$output .= '</div>' . $atts['pagination'] . '</div>';
					}
				} else {
					$output .= '</div>' . $atts['pagination'];
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