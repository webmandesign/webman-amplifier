<?php
/**
 * Posts shortcode item template
 *
 * Default wm_staff item template
 * Consist of:
 * 		image,
 * 		title,
 * 		taxonomy:staff_position,
 * 		content,
 * 		contacts
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

	$terms       = get_the_terms( $helper['post_id'], 'staff_position' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable
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

	<div class="wm-posts-element wm-html-element content">
		<?php echo do_shortcode( wpautop( get_the_content() ) ); ?>
	</div>

	<?php

	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable
	$staff_contacts = wma_meta_option( 'contacts', $helper['post_id'] );

	if (
		$staff_contacts
		&& is_array( $staff_contacts )
	) {

		echo '<ul class="wm-posts-element wm-html-element contacts">';

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- local variable
		foreach ( $staff_contacts as $contact ) {

			if (
				! isset( $contact['icon'] )
				|| ! isset( $contact['title'] )
				|| ! isset( $contact['content'] )
			) {
				continue;
			}

			echo
				'<li class="contacts-item ' . esc_attr( $contact['icon'] ) . '" title="' . esc_attr( $contact['title'] ) . '">'
				. wp_kses( $contact['content'], WMA_KSES::$prefix . 'inline' )
				. '</li>';
		}

		echo '</ul>';
	}

	?>

</article>
