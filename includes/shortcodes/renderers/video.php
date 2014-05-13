<?php
/**
 * Video
 *
 * Compatible with WordPress 3.6+
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0
 *
 * @param  string class
 * @param  string poster @link http://codex.wordpress.org/Video_Shortcode
 * @param  string src
 * @param  string ... For attributes please see @link http://codex.wordpress.org/Video_Shortcode.
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'autoplay' => false,
			'class'    => '',
			'loop'     => false,
			'poster'   => '',
			'src'      => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	//get the custom attributes in $atts['attributes']
	//parameters: $defaults, $atts, $remove, $aside, $shortcode
	$atts = wma_shortcode_custom_atts( $defaults, $atts, array( 'autoplay', 'loop', 'poster', 'src' ), array(), $prefix_shortcode . $shortcode );

//Validation
	//content
		$atts['content'] = '';
	//src
		$atts['src'] = trim( $atts['src'] );
		if ( $atts['src'] ) {
			if (
					stripos( $atts['src'], 'mp4' )
					|| stripos( $atts['src'], 'm4v' )
					|| stripos( $atts['src'], 'webm' )
					|| stripos( $atts['src'], 'ogv' )
					|| stripos( $atts['src'], 'wmv' )
					|| stripos( $atts['src'], 'flv' )
				) {

				$atts['content'] = do_shortcode( '[video src="' . $atts['src'] . '" poster="' . $atts['poster'] . '" autoplay="' . $atts['autoplay'] . '" loop="' . $atts['loop'] . '" ' . $atts['attributes'] . ' /]' );

			} else {

				$atts['content'] = wp_oembed_get( esc_url( $atts['src'] ) );

				//Helper viariables
					$url_addons = '';

				/**
				 * Preparing output for YouTube and Vimeo
				 *
				 * Autoplay and looping attributes will be applied also
				 * on these 2 video services.
				 */
					if ( false !== strpos( $atts['src'], 'youtube' ) ) {
						$url_addons = '?rel=0';
					} elseif ( false !== strpos( $atts['src'], 'vimeo' ) ) {
						$url_addons = '?title=0&amp;byline=0&amp;portrait=0';
					}

					if ( $url_addons ) {
					//If YouTube or Vimeo...

						if ( $atts['autoplay'] ) {
							$url_addons .= '&amp;autoplay=1'; //The same for YouTube and Vimeo
							//Remove controls and info when autoplay
								$url_addons .= '&amp;controls=0&amp;showinfo=0'; //For YouTube
								$url_addons .= '&amp;badge=0&amp;autopause=0'; //For Vimeo
						}
						if ( $atts['loop'] ) {
							$url_addons .= '&amp;loop=1'; //The same for YouTube and Vimeo
						}

						//Allow filtering URL addons
							$url_addons = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_url_addons', $url_addons, $atts );

						//Search for the src="URL"
							preg_match( '/src=\"([^\"]*)\"/', $atts['content'], $matches );

						//Add URL attributes
							if ( isset( $matches[1] ) ) {
								if ( strpos( $matches[1], '?' ) ) {
									$url_addons = str_replace( '?', '$amp;', $url_addons );
								}
								$atts['content'] = str_replace( $matches[1], $matches[1] . $url_addons, $atts['content'] );
							}

					}

			}
		}
	//content filters
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $atts['content'], $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//class
		$atts['class'] = trim( 'wm-video ' . trim( $atts['class'] ) );
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( $atts['class'] ) );
	//poster
		$atts['poster'] = trim( $atts['poster'] );
		if ( is_numeric( $atts['poster'] ) ) {
			$atts['poster'] = wp_get_attachment_url( $atts['poster'] );
		}
		$atts['poster'] = esc_url( $atts['poster'] );

//Output
	$output = '<div class="' . $atts['class'] . '"><div class="media-container">' . $atts['content'] . '</div></div>';

?>