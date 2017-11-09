<?php

class WM_Amplifier_WPML_Beaver_Builder_Button extends WPML_Beaver_Builder_Module_With_Items {

	protected function get_title( $field ) {
		switch( $field ) {
			case 'label':
				return esc_html__( 'Test Item Label', 'wpml-string-translation' );

			case 'content':
				return esc_html__( 'Test Item Content', 'wpml-string-translation' );

			default:
				return '';
		}
	}

} // /WM_Amplifier_WPML_Beaver_Builder_Button
