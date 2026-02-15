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

</article>
