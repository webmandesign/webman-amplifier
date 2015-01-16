<?php
/**
 * Table
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.1
 *
 * @uses   $codes_globals['table_appearance']
 *
 * @param  string class
 * @param  string separator
 * @param  string type Legacy attribute
 * @param  string appearance Introduced not to conflict with Beaver Builder
 */



//Shortcode attributes
	$defaults = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_defaults', array(
			'appearance' => '',
			'class'      => '',
			'separator'  => ',',
			'type'       => '',
		), $shortcode );
	$atts = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//class
		$atts['class'] = trim( 'wm-table ' . trim( $atts['class'] ) );
	//separator
		$atts['separator'] = ( $atts['separator'] ) ? ( trim( $atts['separator'] ) ) : ( ',' );
	//type
		//Fix for Beaver Builder
			if ( $atts['appearance'] ) {
				$atts['type'] = $atts['appearance'];
			}
		$atts['type'] = trim( $atts['type'] );
		if ( in_array( $atts['type'], array_keys( $codes_globals['table_appearance'] ) ) ) {
			$atts['class'] .= ' type-' . $atts['type'];
		}
	//content (table CSV data)
		$content = str_replace( array( '<p>', '</p>' ), '', $content ); //remove HTML paragraphs
		$content = str_replace( array( '<br>', '<br />' ), "\r\n", $content ); //replace HTML line breaks
		$content = preg_split('/\r\n|\r|\n/', $content ); //split string into array by line breaks
		$content = array_values( array_filter( $content ) ); //remove empty values and reindex keys
		if ( is_array( $content ) && ! empty( $content ) ) {
			foreach ( $content as $key => $row ) {
				$row_class = 'odd';

				//Remove HTML tags
					$row = strip_tags( $row, apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_allowed_html_tags', '<a><code><em><img><small><strong>' ) );

				//Set columns count and prepare rows
					if ( $key ) {
						if ( 0 === absint( $key ) % 2 ) {
							$row_class = 'even';
						}
						$row = '<tr class="' . $row_class . '"><td>' . str_replace( $atts['separator'], '</td><td>', $row ) . '</td></tr>';
					} else {
						$atts['columns_count'] = substr_count( $row, $atts['separator'] ) + 1;
						$row = '<thead><tr><th>' . str_replace( $atts['separator'], '</th><th>', $row ) . '</th></tr></thead><tbody>';
					}

				$content[$key] = $row;
			}
			$atts['content'] = implode( '', $content ) . '</tbody>';
		} else {
			$atts['content'] = '';
		}
	//content filters
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . '_content', $atts['content'], $shortcode );
		$atts['content'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_content', $atts['content'] );
	//class
		$atts['class'] = apply_filters( WM_SHORTCODES_HOOK_PREFIX . $shortcode . '_classes', esc_attr( $atts['class'] ) );

//Output
	if ( $atts['content'] ) {
		$output = '<table class="' . $atts['class'] . '">' . $atts['content'] . '</table>';
	}

?>