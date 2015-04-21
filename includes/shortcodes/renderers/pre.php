<?php
/**
 * Pre (HTML tag)
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1.6
 */



//Validation
	//content
		add_filter( 'run_wptexturize', '__return_false' );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . '_content', $content, $shortcode, $atts );
		$atts['content'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_content', $atts['content'], $atts );
		add_filter( 'run_wptexturize', '__return_true' );

//Output
	$output = '<pre>' . $atts['content'] . '</pre>';

?>