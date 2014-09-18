<?php
/**
 * Testimonials
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.0.9.8
 *
 * @param  string align
 * @param  string category (testimonials category slug)
 * @param  string class
 * @param  integer columns
 * @param  integer count
 * @param  integer desc_column_size
 * @param  boolean no_margin
 * @param  string order
 * @param  boolean pagination
 * @param  integer scroll (value ranges: 0, 1-999, 1000+)
 * @param  string testimonial (ID or slug, if this is set, a single module will be displayed only)
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'align'            => 'left',
			'category'         => '',
			'class'            => '',
			'columns'          => 4,
			'count'            => -1,
			'desc_column_size' => 4,
			'no_margin'        => false,
			'order'            => 'new',
			'pagination'       => false,
			'scroll'           => 0,
			'testimonial'      => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Helper variables
	global $page, $paged;
	if ( ! isset( $paged ) ) {
		$paged = 1;
	}
	$paged                 = max( $page, $paged );
	$output                = '';
	$image_size            = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_image_size', 'thumbnail' );
	$posts_container_class = 'wm-testimonials-container wm-items-container';
	$masonry_layout        = false;

//Validation
	//post_type
		$atts['post_type'] = 'wm_testimonials';
	//align
		$atts['align'] = ( 'right' === trim( $atts['align'] ) ) ? ( trim( $atts['align'] ) ) : ( 'left' );
	//category
		$atts['category'] = ( trim( $atts['category'] ) ) ? ( array( 'testimonial_category', trim( $atts['category'] ) ) ) : ( '' );
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
	//testimonial
		$atts['testimonial'] = trim( $atts['testimonial'] );
		if ( $atts['testimonial'] && is_numeric( $atts['testimonial'] ) ) {
			$atts['testimonial'] = array( 'p', absint( $atts['testimonial'] ) );
		} elseif ( $atts['testimonial'] ) {
			$atts['testimonial'] = array( 'name', $atts['testimonial'] );
		}
		if ( $atts['testimonial'] ) {
			$content            = '';
			$atts['class']     .= ' wm-testimonials-singular';
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
		if ( false !== strpos( $atts['class'], 'masonry' ) ) {
			//Use masonry when "masonry" class set
			$posts_container_class .= ' masonry-this';
			$atts['class']          = str_replace( 'masonry', 'wm-posts-masonry-enabled', $atts['class'] );
			$masonry_layout         = true;
		}
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( trim( 'wm-testimonials wm-posts-wrap clearfix ' . trim( $atts['class'] ) ) ) );

//Preparing content
	//Get the posts
		//Set query arguments
			if ( $atts['testimonial'] ) {
				$query_args = array(
						'post_type'        => $atts['post_type'],
						$atts['testimonial'][0] => $atts['testimonial'][1],
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
				if ( $atts['category'] ) {
					$query_args['tax_query'] = array( array(
						'taxonomy' => $atts['category'][0],
						'field'    => 'slug',
						'terms'    => explode( ',', $atts['category'][1] )
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

			//Scrollable posts
				if ( $atts['scroll'] ) {

					//Set posts container class
						$posts_container_class .= ' stack';

				} // /if scroll

			//Posts grid container openings
				if ( ! $atts['testimonial'] ) {
					$posts_container_class = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_posts_container_class', $posts_container_class );
					if ( $atts['content'] ) {
						if ( 'right' == $atts['align'] ) {
						//open posts container div only
							$output .= '<div class="wm-column width-' . ( $atts['desc_column_size'] - 1 ) . '-' . $atts['desc_column_size'] . '"><div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '"' . wma_schema_org( 'item_list' ) . '>';
						} else {
						//insert posts description (shortcode content) in a column and open the posts container div
							$output .= '<div class="wm-column width-1-' . $atts['desc_column_size'] . ' wm-testimonials-description">' . $atts['content'] . '</div><div class="wm-column width-' . ( $atts['desc_column_size'] - 1 ) . '-' . $atts['desc_column_size'] . ' last"><div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '"' . wma_schema_org( 'item_list' ) . '>';
						}
					} else {
						$output .= '<div class="' . $posts_container_class . '" data-columns="' . $atts['columns'] . '" data-time="' . absint( $atts['scroll'] ) . '"' . wma_schema_org( 'item_list' ) . '>';
					}
				}

			//Row
				$row_condition  = ( ! $atts['testimonial'] && ! $atts['scroll'] && 1 != $atts['columns'] && ! $masonry_layout );
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

				//Setting up custom link
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

				//Output the posts item
					$output_item = $class_item = '';

					//Testimonial content
						$output_item .= do_shortcode( '<blockquote class="wm-testimonials-element wm-html-element content"' . wma_schema_org( 'review_body' ) . '>' . wpautop( preg_replace( '/<(\/?)blockquote(.*?)>/', '', get_the_content() ) ) . '</blockquote>' );
					//Testimonial author
						if ( trim( wma_meta_option( 'author', $post_id ) ) ) {
							$output_item .= '<cite class="wm-testimonials-element wm-html-element source">';
								$output_item .= ( $link ) ? ( '<a' . $link . wma_schema_org( 'bookmark' ) . '>' ) : ( '' );
									$output_item .= ( has_post_thumbnail( $post_id ) ) ? ( '<span class="wm-testimonials-element wm-html-element image image-container"' . wma_schema_org( 'image' ) . '>' . get_the_post_thumbnail( $post_id, $image_size, array( 'title' => esc_attr( get_the_title( get_post_thumbnail_id( $post_id ) ) ) ) ) . '</span>' ) : ( '' );
									$output_item .= '<span class="wm-testimonials-element wm-html-element author"' . wma_schema_org( 'author' ) . '>' . do_shortcode( strip_tags( wma_meta_option( 'author', $post_id ), '<a><em><i><img><mark><small><strong>' ) ) . '</span>';
								$output_item .= ( $link ) ? ( '</a>' ) : ( '' );
							$output_item .= '</cite>';
						}

					$output_item .= wma_schema_org( 'itemprop="name" content="' . get_the_title( $post_id ) . '"', true );
					$output_item .= wma_schema_org( 'itemprop="datePublished" content="' . get_the_date( 'c' ) . '"', true );

					//Filter the posts item html output
						$output_item = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_item_html', $output_item, $post_id );

					//Posts single item output
						$class_item .= 'wm-testimonials-item wm-testimonials-item-' . $post_id;
						if ( ! $atts['testimonial'] ) {
							$class_item .= ' wm-column width-1-' . $atts['columns'] . $atts['no_margin'] . $alt;
						}
						if (
								! $atts['testimonial']
								&& ( ! $atts['no_margin'] || ' with-margin' === $atts['no_margin'] )
								&& ! $atts['scroll']
								&& ! $masonry_layout
								&& ( $i % $atts['columns'] === 0 )
							) {
							$class_item .= ' last';
						}
						$terms = get_the_terms( $post_id, 'testimonial_category' );
						if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
							foreach( $terms as $term ) {
								$class_item .= ' testimonial_category-' . $term->slug;
							}
						}
						$class_item  = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_item_class', $class_item, $post_id );
						$output_item = '<article class="' . $class_item . '"' . wma_schema_org( 'review' ) . '>' . $output_item . '</article>';

				$output .= $output_item;

				$alt = ( $alt ) ? ( '' ) : ( ' alt' );

			endwhile;

			//Row
				$output .= ( $row_condition ) ? ( '</div>' ) : ( '' );

			//Posts grid container closings
				if ( ! $atts['testimonial'] ) {
					if ( $atts['content'] ) {
						if ( 'right' == $atts['align'] ) {
						//close posts container div and output description column
							$output .= '</div>' . $atts['pagination'] . '</div><div class="wm-column width-1-' . $atts['desc_column_size'] . ' last wm-testimonials-description">' . $atts['content'] . '</div>';
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