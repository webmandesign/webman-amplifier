<?php
/**
 * Posts shortcode item template
 *
 * Default wm_projects item template
 * Consist of:
 * 		image,
 * 		title,
 * 		taxonomy:project_category,
 * 		excerpt
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

	$terms       = get_the_terms( $helper['post_id'], 'project_category' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable
	$terms_array = array();// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable

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

</article>
