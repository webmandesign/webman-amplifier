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
 * @version  1.6.0
 *
 * @uses  array $helper  Contains shortcode $atts array plus additional helper variables.
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<article class="<?php echo esc_attr( $helper['item_class'] ); ?>">

	<?php if ( has_post_thumbnail( $helper['post_id'] ) ) : ?>
		<div class="wm-posts-element wm-html-element image image-container">
			<?php

			if ( $helper['link'] ) {
				echo wp_kses( '<a' . $helper['link'] . '>', WMA_KSES::$prefix . 'inline' );
			}

			the_post_thumbnail(
				$helper['image_size'],
				array(
					'title' => esc_attr( get_the_title( get_post_thumbnail_id( $helper['post_id'] ) ) ),
				)
			);

			if ( $helper['link'] ) {
				echo '</a>';
			}

			?>
		</div>
	<?php endif; ?>

	<div class="wm-posts-element wm-html-element title">
		<<?php echo tag_escape( $helper['atts']['heading_tag'] ); ?>>
			<?php

			if ( $helper['link'] ) {
				echo wp_kses( '<a' . $helper['link'] . '>', WMA_KSES::$prefix . 'inline' );
			}

			the_title();

			if ( $helper['link'] ) {
				echo '</a>';
			}

			?>
		</<?php echo tag_escape( $helper['atts']['heading_tag'] ); ?>>
	</div>

	<div class="wm-posts-element wm-html-element meta">
		<time class="meta-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		<a class="meta-comments" href="<?php echo esc_url( get_comments_link() ); ?>" title="<?php

			echo esc_attr(
				sprintf(
					/* translators: %s: number of comments. */
					__( 'Comments: %s', 'webman-amplifier' ),
					get_comments_number()
				)
			);

		?>"><?php echo esc_html( get_comments_number() ); ?></a>
	</div>

	<?php

	if ( 0 < $helper['excerpt_length'] ) {
		echo
			'<div class="wm-posts-element wm-html-element excerpt">'
			. wp_kses(
				wp_trim_words( get_the_excerpt(), $helper['excerpt_length'], '&hellip;' ),
				WMA_KSES::$prefix . 'inline'
			)
			. '</div>';
	}

	?>

	<?php

	$terms       = get_the_terms( $helper['post_id'], 'category' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable
	$terms_array = array(); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable

	if (
		! is_wp_error( $terms )
		&& ! empty( $terms )
	) {

		foreach( $terms as $term ) {
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable
			$terms_array[] =
				'<span class="term term-' . sanitize_html_class( $term->slug ) . '">'
				. $term->name
				. '</span>';
		}

		echo
			'<div class="wm-posts-element wm-html-element taxonomy">'
			. wp_kses( implode( ', ', $terms_array ), WMA_KSES::$prefix . 'inline' )
			. '</div>' ;
	}

	?>

	<div class="wm-posts-element wm-html-element more-link">
		<a href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php

			echo esc_attr( sprintf(
				/* translators: %s: post title. */
				esc_html__( 'Read more about "%s"', 'webman-amplifier' ),
				wp_strip_all_tags( get_the_title() )
			) );

		?>"><?php

			echo esc_html( (string) apply_filters(
				'wmhook_shortcode_posts_item_read_more_text',
				__( 'Read more &raquo;', 'webman-amplifier' )
			) );

		?></a>
	</div>

</article>
