<?php
/**
 * Posts shortcode item template
 *
 * Default wm_logos item template
 * Consist of:
 * 		image
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

</article>