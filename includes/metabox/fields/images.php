<?php
/**
 * WebMan Metabox Generator
 * Form Fields Renderers and Validators
 *
 * Images upload fields
 *
 * @package     WebMan Amplifier
 * @subpackage  Metabox
 */



/**
 * IMAGE UPLOAD FIELD
 */

	/**
	 * Image upload field
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 * @return      array Image url and id (such as array( 'url' => 'IMAGE_URL', 'id' => 123 ))
	 */
	if ( ! function_exists( 'wma_field_image' ) ) {
		function wma_field_image( $field, $page_template = null ) {
			//Field definition array
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
						'button-text' => __( 'Set image', 'wm_domain' ),  //Preview image size
						'conditional' => '',                              //Conditional display setup
					) );

				$field['class'] .= ( $field['preview'] ) ? ( ' preview-enabled' ) : ( ' preview-disabled' );
				if ( $field['upload-only'] ) {
					$field['attributes'] .= ' readonly="readonly"';
				}

			//Value processing
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

			//Setting preview image URL
				$previewURL   = '';
				$noPreviewURL = esc_url( WMAMP_ASSETS_URL . 'images/meta/no-thumb.png' );
				if ( $field['upload-only'] && $value['id'] ) {
				//If image ID is set, retrieve the image of specific size
					$previewURL = wp_get_attachment_image_src( $value['id'], $field['size'] );
					$previewURL = $previewURL[0];
				}
				if ( 0 === strpos( $value['url'], '.' ) ) {
				//If relative path set
					$previewURL = $noPreviewURL;
				} elseif ( ! $previewURL && $value['url'] ) {
				//If still no preview image URL, get the set URL value
					$previewURL = esc_url( $value['url'] );
				} elseif( ! $previewURL ) {
				//Default
					$previewURL = $noPreviewURL;
				}

			//Field ID setup
				$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

			//Output
				$output  = "\r\n\t" . '<tr class="option image-wrap option-' . trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th>';
					//Label
						$output .= "\r\n\t\t" . '<label for="' . $field['id'] . '" data-id="' . $field['id'] . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';
				$output .= "\r\n\t" . '</th><td>';
					//Input field
						$output .= "\r\n\t\t";
						$output .= '<input type="text" name="' . $field['id'] . '[url]" id="' . $field['id'] . '" value="' . $value['url'] . '" class="fieldtype-image" placeholder="' . __( 'Image URL', 'wm_domain' ) . '" data-nothumb="' . $noPreviewURL . '" data-preview="' . $previewURL . '" ' . trim( $field['attributes'] . ' /' ) . '>';
						if ( $field['upload-only'] ) {
							$output .= '<input type="hidden" name="' . $field['id'] . '[id]" value="' . $value['id'] . '" />';
						}
					//Image upload button
						$output .= '<a href="#" class="button button-set-image" data-id="' . $field['id'] . '">' . $field['button-text'] . '</a>';
					//Description
						if ( trim( $field['description'] ) ) {
							$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
						}
					//Image preview
						if ( $field['preview'] ) {
							$output .= "\r\n\t\t" . '<div class="image-preview image-' . $field['id'] . '">';
								$output .= '<a class="button-set-image" data-id="' . $field['id'] . '">';
								$output .= '<img src="' . $previewURL . '" alt="" />';
								$output .= '</a>';
							$output .= '</div>';
						}
					//Reset default value button
						if ( trim( $field['default'] ) || $field['upload-only'] ) {
							$output .= "\r\n\t\t" . '<a data-option="' . $field['id'] . '[url]" class="button-default-value" title="' . __( 'Remove image', 'wm_domain' ) . '"><span>' . $field['default'] . '</span></a>';
						}

					echo $output;

				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</td></tr>';
		}
	} // /wma_field_image

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'image', 'wma_field_image', 10, 2 );



	/**
	 * Image upload field validation
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_image_validation' ) ) {
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

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'image', 'wma_field_image_validation', 10, 3 );



/**
 * GALLERY UPLOAD FIELD (MULTIPLE IMAGES)
 */

	/**
	 * Gallery upload field
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 * @return      string Image IDs separated with commas (such as "123,124,125")
	 */
	if ( ! function_exists( 'wma_field_gallery' ) ) {
		function wma_field_gallery( $field, $page_template = null ) {
			//Field definition array
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
						'button-text' => __( 'Set images', 'wm_domain' ),  //Preview image size
						'conditional' => '',                                //Conditional display setup
					) );

			//Value processing
				$value = wma_meta_option( $field['id'] );
				$value = preg_replace( '/[^0-9\,]/', '', $value );

			//Field ID setup
				$field['id'] = WM_METABOX_FIELD_PREFIX . $field['id'];

			//Output
				$output  = "\r\n\t" . '<tr class="option gallery-wrap option-' . trim( sanitize_html_class( $field['id'] ) . ' ' . $field['class'] ) . '" data-option="' . $field['id'] . '"><th>';
					//Label
						$output .= "\r\n\t\t" . '<label for="' . $field['id'] . '" class="button-set-gallery" data-id="' . $field['id'] . '">' . trim( strip_tags( $field['label'], WM_METABOX_LABEL_HTML ) ) . '</label>';
				$output .= "\r\n\t" . '</th><td>';
					//Input field
						$output .= "\r\n\t\t";
						$output .= '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $value . '" />';
					//Image upload button
						$output .= '<a href="#" class="button button-set-gallery" data-id="' . $field['id'] . '">' . $field['button-text'] . '</a>';
					//Description
						if ( trim( $field['description'] ) ) {
							$output .= "\r\n\t\t" . '<p class="description">' . trim( $field['description'] ) . '</p>';
						}
					//Image preview
						$value = array_filter( explode( ',', $value ) );
						$output .= "\r\n\t\t" . '<div class="gallery-preview gallery-' . $field['id'] . '">';
						if ( is_array( $value ) && ! empty( $value ) ) {
							foreach ( $value as $image_id ) {
								$output .= '<a class="button-set-gallery" data-id="' . $field['id'] . '" title="' . __( 'Edit images', 'wm_domain' ) . '">';
								$output .= wp_get_attachment_image( absint( $image_id ), $field['size'] );
								$output .= '</a>';
							}
						}
						$output .= '</div>';
						$output .= "\r\n\t\t" . '<img class="gallery-loading gallery-loading-' . $field['id'] . '" src="' . WMAMP_ASSETS_URL . 'images/meta/loading.gif" width="16" height="16" alt="' . __( 'Loading images', 'wm_domain' ) . '" title="' . __( 'Loading images', 'wm_domain' ) . '" />';
					//Reset default value button
						$output .= "\r\n\t\t" . '<a data-option="' . $field['id'] . '" class="button-default-value default-gallery" title="' . __( 'Remove images', 'wm_domain' ) . '"><span>' . $field['default'] . '</span></a>';

					echo $output;

				//Conditional display
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional', $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['type'] ), $field, $field['id'] );
					do_action( WM_METABOX_HOOK_PREFIX . 'conditional_' . sanitize_html_class( $field['id'] ), $field );

				echo "\r\n\t" . '</td></tr>';
		}
	} // /wma_field_gallery

	add_action( WM_METABOX_HOOK_PREFIX . 'render_' . 'gallery', 'wma_field_gallery', 10, 2 );



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
		function wma_field_gallery_validation( $new, $field, $post_id ) {
			$new = preg_replace( '/[^0-9\,]/', '', $new );

			return $new;
		}
	} // /wma_field_gallery_validation

	add_action( WM_METABOX_HOOK_PREFIX . 'saving_' . 'gallery', 'wma_field_gallery_validation', 10, 3 );



	/**
	 * Gallery AJAX images preview update
	 *
	 * @since       1.0
	 * @package	    WebMan Amplifier
	 * @subpackage  Metabox
	 * @author      WebMan
	 * @version     1.0
	 */
	if ( ! function_exists( 'wma_field_gallery_AJAX' ) ) {
		function wma_field_gallery_AJAX() {
			//Security - check nonce field
				if (
						! is_user_logged_in()
						|| ! current_user_can( 'edit_posts' )
						|| ! isset( $_POST['wmGalleryNonce'] )
						|| ! wp_verify_nonce( $_POST['wmGalleryNonce'], 'wm-gallery-preview-refresh' )
					) {
					_e( 'You do not have permissions to do this!', 'wm_domain' );
					die();
				}

			//Processing AJAX request (getting gallery images)
				$output  = '';
				$fieldID = ( isset( $_POST['fieldID'] ) ) ? ( $_POST['fieldID'] ) : ( '' );
				$images  = ( isset( $_POST['images'] ) && is_array( $_POST['images'] ) ) ? ( $_POST['images'] ) : ( array() );
				$images  = array_filter( $images );

				if ( ! empty( $images ) ) {
					foreach ( $images as $image_id ) {
						$output .= '<a class="button-set-gallery" data-id="' . $fieldID . '" title="' . __( 'Edit images', 'wm_domain' ) . '">';
						$output .= wp_get_attachment_image( absint( $image_id ), 'thumbnail' );
						$output .= '</a>';
					}
				}

			//Output
				echo $output;
				die();
		}
	} // /wma_field_gallery_AJAX

	add_action( 'wp_ajax_wm-gallery-preview-refresh', 'wma_field_gallery_AJAX' );

?>