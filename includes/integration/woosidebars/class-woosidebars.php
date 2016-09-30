<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * WooSidebars plugin integration
 *
 * Registering WebMan Amplifier's custom taxonomies with WooSidebars
 * plugin sidebar settings.
 *
 * @package     WebMan Amplifier
 * @subpackage  Integration
 * @copyright   WebMan Design, Oliver Juhas
 *
 * @since    1.3.22
 * @version  1.4
 *
 * Contents:
 *
 *  0) Init
 * 10) Integration
 */
class WM_Amplifier_WooSidebars {





	/**
	 * 0) Init
	 */

		private static $unsupported;

		private static $post_types;

		private static $taxonomies;

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.3.22
		 * @version  1.4
		 */
		private function __construct() {

			// Helper variables

				self::$post_types = (array) apply_filters( 'wmhook_amplifier_woosidebars_post_types', array(
						'wm_projects',
						'wm_staff',
					) );

				self::$taxonomies = (array) apply_filters( 'wmhook_amplifier_woosidebars_taxonomies', array(
						'project_category',
						'project_tag',
						'staff_department',
						'staff_position',
						'staff_specialty',
					) );

				self::$unsupported = (array) apply_filters( 'wmhook_amplifier_woosidebars_unsupported', array(
						'post_types' => array(
								'wm_logos',
								'wm_modules',
							),
						'taxonomies' => array(
								'logo_category',
								'module_tag',
							),
					) );


			// Requirements check

				if (
						empty( self::$post_types )
						|| empty( self::$taxonomies )
					) {
					return;
				}


			// Processing

				// Setup

					foreach ( self::$post_types as $post_type ) {
						if ( post_type_exists( $post_type ) ) {
							add_post_type_support( $post_type, 'woosidebars' );
						}
					}

				// Hooks

					// Filters

						add_filter( 'woo_conditions', __CLASS__ . '::register_conditions' );

						add_filter( 'woo_conditions_reference', __CLASS__ . '::register_conditions_reference' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.3.22
		 * @version  1.3.22
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Integration
	 */

		/**
		 * Register the integration conditions with WooSidebars
		 *
		 * @since    1.3.22
		 * @version  1.3.22
		 *
		 * @param  array $conditions  The existing array of conditions.
		 */
		public static function register_conditions( $conditions = array() ) {

			// Helper variables

				global $post;

				$integration = array();


			// Requirements check

				if ( ! in_array( get_post_type( $post ), self::$post_types ) ) {
					return $conditions;
				}


			// Processing

				$taxonomies = get_object_taxonomies( $post );

				foreach ( $taxonomies as $taxonomy ) {

					$terms = get_the_terms( $post->ID, $taxonomy );

					if (
							! is_wp_error( $terms )
							&& is_array( $terms )
							&& 0 < count( $terms )
						) {

						foreach ( $terms as $term ) {
							$integration[] = 'in-term-' . esc_attr( $term->term_id );
						}

					}

				} // /foreach

				$integration[] = $conditions[ count( $conditions ) - 1 ];

				array_splice( $conditions, count( $conditions ), 0, $integration );


			// Output

				return $conditions;

		} // /register_conditions



		/**
		 * Register the integration's conditions reference for the meta box
		 *
		 * @since    1.3.22
		 * @version  1.4
		 *
		 * @param  array $conditions  The existing array of conditions.
		 */
		public static function register_conditions_reference( $conditions = array() ) {

			// Helper variables

				$label_text = esc_html__( 'All posts in "%s"', 'webman-amplifier' );


			// Processing

				// Removing unsupported post types

					if ( isset( self::$unsupported['post_types'] ) ) {
						foreach ( (array) self::$unsupported['post_types'] as $post_type ) {
							unset( $conditions['post_types'][ 'post-type-' . $post_type ] );
						}
					}

				// Removing unsupported taxonomies

					if ( isset( self::$unsupported['taxonomies'] ) ) {
						foreach ( (array) self::$unsupported['taxonomies'] as $taxonomy ) {
							unset( $conditions['taxonomies'][ 'archive-' . $taxonomy ] );
							unset( $conditions[ 'taxonomy-' . $taxonomy ] );
						}
					}

				// Setup each individual taxonomy's terms

					foreach ( self::$taxonomies as $taxonomy ) {

						$taxonomy_key = 'taxonomy-' . $taxonomy;

						if ( ! isset( $conditions[ $taxonomy_key ] ) ) {
							continue;
						}

						foreach ( $conditions[ $taxonomy_key ] as $term => $args ) {

							$conditions[ $taxonomy_key ][ 'in-' . $term ] = array(
									'label' => sprintf(
										$label_text,
										$args['label']
									),
									'description' => sprintf(
										$label_text,
										$args['label']
									),
								);

						} // /foreach

					} // /foreach


			// Output

				return $conditions;

		} // /register_conditions_reference





} // /WM_Amplifier_WooSidebars

add_action( 'init', 'WM_Amplifier_WooSidebars::init' );
