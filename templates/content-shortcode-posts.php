<?php
/**
 * Posts shortcode item template
 *
 * Default item template
 * Consist of:
 * 		image,
 * 		title,
 * 		excerpt,
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
