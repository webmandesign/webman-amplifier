<?php
/**
 * Posts shortcode item template
 *
 * Default post item template
 * Consist of:
 * 		image,
 * 		title,
 * 		meta:date+comments,
 * 		excerpt,
 * 		taxonomy:category,
 * 		more link
 *
 * You can redefine this template by redefining this file (keep the file name)
 * in the YOUR_THEME/webman-amplifier/ folder.
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.1
 *
 * @uses  array $helper  Contains shortcode $atts array plus additional helper variables.
 */
?>

<article class="<?php echo $helper['item_class']; ?>"<?php echo wma_schema_org( 'article' ); ?>>

	<?php if ( has_post_thumbnail( $helper['post_id'] ) ) { ?>
		<div class="wm-posts-element wm-html-element image image-container"<?php echo wma_schema_org( 'image' ); ?>>
			<?php
			if ( $helper['link'] ) {
				echo '<a' . $helper['link'] . wma_schema_org( 'bookmark' ) . '>';
			}

			the_post_thumbnail( $helper['image_size'], array( 'title' => esc_attr( get_the_title( get_post_thumbnail_id( $helper['post_id'] ) ) ) ) );

			if ( $helper['link'] ) {
				echo '</a>';
			}
			?>
		</div>
	<?php } ?>

	<div class="wm-posts-element wm-html-element title">
		<<?php echo $helper['atts']['heading_tag']; echo wma_schema_org( 'name' ); ?>>
			<?php
			if ( $helper['link'] ) {
				echo '<a' . $helper['link'] . wma_schema_org( 'bookmark' ) . '>';
			}

			the_title();

			if ( $helper['link'] ) {
				echo '</a>';
			}
			?>
		</<?php echo $helper['atts']['heading_tag']; ?>>
	</div>

	<div class="wm-posts-element wm-html-element meta">
		<time class="meta-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"<?php echo wma_schema_org( 'publish_date' ); ?>><?php echo esc_html( get_the_date() ); ?></time>
		<a class="meta-comments" href="<?php echo get_comments_link(); ?>" title="<?php printf( _x( 'Comments: %s', '%s stands for number of comments.', 'wm_domain' ), get_comments_number() ); ?>"><?php echo get_comments_number(); ?></a>
	</div>

	<?php
		if ( 0 < $helper['excerpt_length'] ) {
			echo '<div class="wm-posts-element wm-html-element excerpt"' . wma_schema_org( 'description' ) . '>' . wp_trim_words( get_the_excerpt(), $helper['excerpt_length'], '&hellip;' ) . '</div>';
		}
	?>

	<?php
		$terms       = get_the_terms( $helper['post_id'], 'category' );
		$terms_array = array();
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach( $terms as $term ) {
				$terms_array[] = '<span class="term term-' . sanitize_html_class( $term->slug ) . '"' . wma_schema_org( 'itemprop="keywords"' ) . '>' . $term->name . '</span>';
			}
			echo '<div class="wm-posts-element wm-html-element taxonomy">' . implode( ', ', $terms_array ) . '</div>' ;
		}
	?>

	<div class="wm-posts-element wm-html-element more-link">
		<a href="<?php echo get_permalink(); ?>"<?php echo wma_schema_org( 'bookmark' ); ?>><?php printf( apply_filters( WM_SHORTCODES_HOOK_PREFIX . 'posts_item_read_more_text', __( 'Read more <span class="screen-reader-text">about "%s"</span>&raquo;', 'wm_domain' ) ), get_the_title() ); ?></a>
	</div>

</article>