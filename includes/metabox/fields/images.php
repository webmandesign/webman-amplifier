<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Images upload fields
 *
 * For gallery AJAX action:
 * @see  includes/metabox/class-metabox.php
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 *
 * @since    1.0
 * @version  1.6.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * IMAGE UPLOAD FIELD
 */

	/**
	 * Image upload field
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @return      array Image url and id (such as array( 'url' => 'IMAGE_URL', 'id' => 123 ))
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_field_image' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_image( $field, $page_template = null ) {

			// Field definition array
			$field = wp_parse_args( (array) $field, array(
				//DEFAULTS:
				//* = Required setting
				'type'        => 'image',                         //Field type name *
				'id'          => 'id',                            //Field ID (form field name) *
				'label'       => '',                              //Field label
				'description' => '',                              //Field description
				'class'       => '',                              //Additional CSS class
				'attributes'  => '',                              //Additional HTML attributes applied on input field
				'default'     => '',                              //Default value
				'preview'     => true,                            //Enable image preview
				'size'        => 'medium',                        //Preview image size
				'upload-only' => false,                           //Should the image be set only via media uploader? Image ID will be passed too.
				'button-text' => esc_html__( 'Set image', 'webman-amplifier' ),  //Preview image size
				'conditional' => '',                              //Conditional display setup
			) );

			$field['class'] .= ( $field['preview'] ) ? ( ' preview-enabled' ) : ( ' preview-disabled' );

			if ( $field['upload-only'] ) {
				$field['attributes'] .= ' readonly="readonly"';
			}

			// Value processing

				$value = wma_meta_option( $field['id'] );

				if ( $value && is_array( $value ) ) {

					if ( ! isset( $value['url'] ) || ! $value['url'] ) {
						$value = array(
							'url' => '',
							'id'  => ''
						);
					} else {
						$value['url'] = sanitize_text_field( $value['url'] ); //Don't use URL escaping as this can be set to relative path too
					}
				} else {
					$value = array( 'url' => sanitize_text_field( $field['default'] ) );
				}

				if ( $field['upload-only'] && ! isset( $value['id'] ) ) {
					$value['id'] = '';
				}

			// Setting preview image URL

				$previewURL   = '';
				$noPreviewURL = WMAMP_ASSETS_URL . 'images/meta/no-thumb.png';

				if ( $field['upload-only'] && $value['id'] ) {
					// If image ID is set, retrieve the image of specific size
					$previewURL = wp_get_attachment_image_src( $value['id'], $field['size'] );
					$previewURL = $previewURL[0];
				}

				if ( 0 === strpos( $value['url'], '.' ) ) {
					// If relative path set
					$previewURL = $noPreviewURL;
				} elseif ( ! $previewURL && $value['url'] ) {
					// If still no preview image URL, get the set URL value
					$previewURL = $value['url'];
				} elseif( ! $previewURL ) {
					// Default
					$previewURL = $noPreviewURL;
				}

			// Field ID setup
			$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

			// Output

				$output =
					PHP_EOL . "\t"
					. '<tr
						class="option image-wrap option-' . esc_attr( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '"
						data-option="' . esc_attr( $field['id'] ) . '">'
					. '<th>';

				// Label
				$output .=
					PHP_EOL . "\t\t"
					. '<label for="' . esc_attr( $field['id'] ) . '" data-id="' . esc_attr( $field['id'] ) . '">'
					. trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) )
					. '</label>';

				$output .= PHP_EOL . "\t" . '</th><td>';

				// Input field
				$output .=
					PHP_EOL . "\t\t"
					. '<input
						type="text"
						name="' . esc_attr( $field['id'] ) . '[url]"
						id="' . esc_attr( $field['id'] ) . '"
						value="' . esc_attr( $value['url'] ) . '"
						class="fieldtype-image"
						placeholder="' . esc_attr__( 'Image URL', 'webman-amplifier' ) . '"
						data-nothumb="' . esc_url( $noPreviewURL ) . '"
						data-preview="' . esc_url( $previewURL ) . '"'
						. ' ' . $field['attributes']
						. '>';

				if ( $field['upload-only'] ) {
					$output .=
						'<input
							type="hidden"
							name="' . esc_attr( $field['id'] ) . '[id]"
							value="' . esc_attr( $value['id'] ) . '"
							/>';
				}

				// Image upload button
				$output .=
					'<a
						href="#"
						class="button button-set-image"
						data-id="' . esc_attr( $field['id'] ) . '"
						>'
					. $field['button-text']
					. '</a>';

				// Description
				if ( trim( $field['description'] ) ) {
					$output .= PHP_EOL . "\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
				}

				// Image preview
				if ( $field['preview'] ) {
					$output .= PHP_EOL . "\t\t" . '<div class="image-preview image-' . esc_attr( $field['id'] ) . '">';
						$output .= '<a class="button-set-image" data-id="' . esc_attr( $field['id'] ) . '">';
						$output .= '<img src="' . esc_url( $previewURL ) . '" alt="" />';
						$output .= '</a>';
					$output .= '</div>';
				}

				// Reset default value button
				if ( trim( $field['default'] ) || $field['upload-only'] ) {
					$output .=
						PHP_EOL . "\t\t"
						. '<a
							data-option="' . esc_attr( $field['id'] ) . '[url]"
							class="button-default-value"
							title="' . esc_attr__( 'Remove image', 'webman-amplifier' ) . '"
							>'
						. '<span>'
						. $field['default']
						. '</span>'
						. '</a>';
				}

				// Conditional display
				ob_start();
				do_action( 'wmhook_metabox_conditional', $field, $field['id'] );
				$output .= ob_get_clean() . PHP_EOL . "\t" . '</td></tr>';

				echo wp_kses( $output, WMA_KSES::$prefix . 'form' );

		}
	} // /wma_field_image

	add_action( 'wmhook_metabox_render_image', 'wma_field_image', 10, 2 );



	/**
	 * Image upload field validation
	 *
	 * @since       1.0
	 * @version     1.6.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 */
	if ( ! function_exists( 'wma_field_image_validation' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_image_validation( $new, $field, $post_id ) {

			if ( ! isset( $new['url'] ) || ! $new['url'] ) {
				$new = array(
					'url' => '',
					'id'  => ''
				);
			} else {
				$new['url'] = sanitize_text_field( $new['url'] ); //Don't use URL escaping as this can be set to relative path too
			}

			if ( isset( $new['id'] ) && $new['id'] ) {
				$new['id'] = absint( $new['id'] );
			}

			return $new;

		}
	} // /wma_field_image_validation

	add_action( 'wmhook_metabox_saving_image', 'wma_field_image_validation', 10, 3 );



/**
 * GALLERY UPLOAD FIELD (MULTIPLE IMAGES)
 */

	/**
	 * Gallery upload field
	 *
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @return      string Image IDs separated with commas (such as "123,124,125")
	 *
	 * @since    1.0
	 * @version  1.6.0
	 */
	if ( ! function_exists( 'wma_field_gallery' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_gallery( $field, $page_template = null ) {

			// Field definition array
			$field = wp_parse_args( (array) $field, array(
				//DEFAULTS:
				//* = Required setting
				'type'        => 'gallery',                         //Field type name *
				'id'          => 'id',                              //Field ID (form field name) *
				'label'       => '',                                //Field label
				'description' => '',                                //Field description
				'class'       => '',                                //Additional CSS class
				'default'     => '',                                //Default value
				'size'        => 'thumbnail',                       //Preview image size
				'button-text' => esc_html__( 'Set images', 'webman-amplifier' ),  //Preview image size
				'conditional' => '',                                //Conditional display setup
			) );

			// Value processing
			$value = wma_meta_option( $field['id'] );
			$value = preg_replace( '/[^0-9\,]/', '', $value );

			// Field ID setup
			$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

			// Output

				$output =
					PHP_EOL . "\t"
					. '<tr
						class="option gallery-wrap option-' . esc_attr( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '"
						data-option="' . esc_attr( $field['id'] ) . '">'
					. '<th>';

				// Label
				$output .=
					PHP_EOL . "\t\t"
					. '<label for="' . esc_attr( $field['id'] ) . '" class="button-set-gallery" data-id="' . esc_attr( $field['id'] ) . '">'
					. trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) )
					. '</label>';

				$output .= PHP_EOL . "\t" . '</th><td>';

				// Input field
				$output .=
					PHP_EOL . "\t\t"
					. '<input
						type="hidden"
						name="' . esc_attr( $field['id'] ) . '"
						id="' . esc_attr( $field['id'] ) . '"
						value="' . esc_attr( $value ) . '"
						/>';

				// Image upload button
				$output .=
					'<a
						href="#"
						class="button button-set-gallery"
						data-id="' . esc_attr( $field['id'] ) . '">'
						. $field['button-text']
						. '</a>';

				// Description
				if ( trim( $field['description'] ) ) {
					$output .= PHP_EOL . "\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
				}

				// Image preview

					$value = array_filter( explode( ',', $value ) );

					$output .= PHP_EOL . "\t\t" . '<div class="gallery-preview gallery-' . esc_attr( $field['id'] ) . '">';

					if ( is_array( $value ) && ! empty( $value ) ) {
						foreach ( $value as $image_id ) {
							$output .= '<a class="button-set-gallery" data-id="' . esc_attr( $field['id'] ) . '" title="' . esc_attr__( 'Edit images', 'webman-amplifier' ) . '">';
							$output .= wp_get_attachment_image( absint( $image_id ), $field['size'] );
							$output .= '</a>';
						}
					}

					$output .= '</div>';

					$output .=
						PHP_EOL . "\t\t"
						. '<img
							class="gallery-loading gallery-loading-' . esc_attr( $field['id'] ) . '"
							src="' . esc_url( WMAMP_ASSETS_URL . 'images/meta/loading.gif' ) . '"
							width="16"
							height="16"
							alt="' . esc_attr__( 'Loading images', 'webman-amplifier' ) . '"
							title="' . esc_attr__( 'Loading images', 'webman-amplifier' ) . '"
							/>';

				// Reset default value button
				if ( trim( $field['default'] ) && empty( $field['editor'] ) ) {
					$output .=
						PHP_EOL . "\t\t"
						. '<a
							data-option="' . esc_attr( $field['id'] ) . '"
							class="button-default-value default-gallery"
							title="' . esc_attr__( 'Remove images', 'webman-amplifier' ) . '"
							>'
						. '<span>'
						. $field['default']
						. '</span>'
						. '</a>';
				}

				// Conditional display
				ob_start();
				do_action( 'wmhook_metabox_conditional', $field, $field['id'] );
				$output .= ob_get_clean() . PHP_EOL . "\t" . '</td></tr>';

				echo wp_kses( $output, WMA_KSES::$prefix . 'form' );

		}
	} // /wma_field_gallery

	add_action( 'wmhook_metabox_render_gallery', 'wma_field_gallery', 10, 2 );



	/**
	 * Gallery upload field validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_gallery_validation' ) ) {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- prefixed with "wma"
		function wma_field_gallery_validation( $new, $field, $post_id ) {
			return preg_replace( '/[^0-9\,]/', '', $new );
		}
	} // /wma_field_gallery_validation

	add_action( 'wmhook_metabox_saving_gallery', 'wma_field_gallery_validation', 10, 3 );
