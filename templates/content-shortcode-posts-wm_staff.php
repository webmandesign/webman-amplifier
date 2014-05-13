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
 * @uses        array $helper  Contains shortcode $atts array plus additional helper variables.
 */
?>

<article class="<?php echo $helper['item_class']; ?>"<?php echo wma_schema_org( 'person' ); ?>>

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

	<?php
		$terms       = get_the_terms( $helper['post_id'], 'staff_position' );
		$terms_array = array();
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			foreach( $terms as $term ) {
				$terms_array[] = '<span class="term term-' . sanitize_html_class( $term->slug ) . '"' . wma_schema_org( 'itemprop="jobtitle"' ) . '>' . $term->name . '</span>';
			}
			echo '<div class="wm-posts-element wm-html-element taxonomy">' . implode( ', ', $terms_array ) . '</div>' ;
		}
	?>

	<div class="wm-posts-element wm-html-element content"<?php echo wma_schema_org( 'description' ); ?>>
		<?php echo do_shortcode( wpautop( get_the_content() ) ); ?>
	</div>

	<?php
		$staff_contacts = wma_meta_option( 'contacts', $helper['post_id'] );
		if ( $staff_contacts && is_array( $staff_contacts ) ) {
			echo '<ul class="wm-posts-element wm-html-element contacts">';
			foreach ( $staff_contacts as $contact ) {
				if (
						! isset( $contact['icon'] )
						|| ! isset( $contact['title'] )
						|| ! isset( $contact['content'] )
					) {
					continue;
				}
				echo '<li class="contacts-item ' . $contact['icon'] . '" title="' . $contact['title'] . '"' . wma_schema_org( 'itemprop="contactPoint"' ) . '>' . $contact['content'] . '</li>';
			}
			echo '</ul>';
		}
	?>

</article>