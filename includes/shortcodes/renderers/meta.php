<?php
/**
 * Post meta (custom) fields
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since  1.0.9
 *
 * @param  boolean custom  Whether to output the native WordPress Custom Field. Otherwise outputs wma
 * @param  string field
 * @param  absint post_id
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'custom'  => false,
			'field'   => '',
			'post_id' => get_the_id(),
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//custom
		$atts['custom'] = trim( $atts['custom'] );
	//post_id
		$atts['post_id'] = absint( $atts['post_id'] );
	//field
		$atts['field'] = trim( $atts['field'] );
		if ( ! $atts['custom'] ) {
			$atts['field'] = str_replace( WM_METABOX_FIELD_PREFIX, '', $atts['field'] );
		}

//Output
	if ( $atts['field'] ) {
		$output = ( ! $atts['custom'] ) ? ( wma_meta_option( $atts['field'], $atts['post_id'] ) ) : ( get_post_meta( $atts['post_id'], $atts['field'], true ) );
	}

?>