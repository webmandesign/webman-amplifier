<?php
/**
 * KSES class.
 *
 * @package    WebMan Amplifier
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.6.0
 * @version  1.6.1
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound -- prefixed with 'WMA'
class WMA_KSES {

	/**
	 * Custom tags context prefix.
	 *
	 * @since   1.6.0
	 * @access  public
	 * @var     string
	 */
	public static $prefix = 'wma/';

	/**
	 * HTML tags allowed for specific context.
	 *
	 * You can then use `wp_kses( $html, 'context' );`.
	 *
	 * No `break`s in the `switch` below as WordPress does not use them either.
	 * @link  https://developer.wordpress.org/reference/functions/wp_kses_allowed_html/
	 *
	 * @since    1.6.0
	 * @version  1.6.1
	 *
	 * @param  array  $data
	 * @param  string $context
	 *
	 * @return  array
	 */
	public static function tags( array $tags, string $context ): array {

		// Variables

			$output = array();


		// Processing

			switch ( $context ) {

				case self::$prefix . 'inline':
					$output = self::get_tags_inline();
					break;

				case self::$prefix . 'form':
					$output = array_merge(
						self::get_tags_inline(),
						self::get_tags_form(),
						self::get_tags_block(),
						self::get_tags_table()
					);
					break;

				case self::$prefix . 'post+form':
					$output = array_merge(
						wp_kses_allowed_html( 'post' ),
						self::get_tags_source(),
						self::get_tags_iframe(),
						self::get_tags_form()
					);
					break;

				case self::$prefix . 'post':
					$output = array_merge(
						wp_kses_allowed_html( 'post' ),
						self::get_tags_source(),
						self::get_tags_iframe()
					);
					break;
			}

			if ( ! empty( $output ) ) {
				$tags = array_map( '_wp_add_global_attributes', $output );
			}


		// Output

			return $tags;

	} // /tags

	/**
	 * Form tags.
	 *
	 * @since  1.6.0
	 *
	 * @return  array
	 */
	public static function get_tags_form(): array {

		// Variables

			$atts = self::get_atts( 'form' );


		// Output

			return array(

				'form' => array(
					'action'         => true,
					'accept'         => true,
					'accept-charset' => true,
					'enctype'        => true,
					'method'         => true,
					'name'           => true,
					'target'         => true,
				),

				'button'   => $atts,
				'datalist' => array(),
				'input'    => $atts,
				'label'    => $atts,
				'optgroup' => $atts,
				'option'   => $atts,
				'select'   => $atts,
				'textarea' => $atts,
			);

	} // /get_tags_form

	/**
	 * Inline tags.
	 *
	 * @since  1.6.0
	 *
	 * @return  array
	 */
	public static function get_tags_inline(): array {

		// Output

			return array_merge(
				array(

					'a'      => self::get_atts( 'a' ),
					'abbr'   => array(),
					'b'      => array(),
					'br'     => array(),
					'code'   => array(),
					'del'    => array( 'datetime' => true, ),
					'dfn'    => array(),
					'em'     => array(),
					'i'      => array(),
					'mark'   => array(),
					'q'      => array( 'cite' => true, ),
					'small'  => array(),
					'span'   => array(),
					'strike' => array(),
					'strong' => array(),
					'u'      => array(),
				),
				self::get_tags_image()
			);

	} // /get_tags_inline

	/**
	 * Basic block tags.
	 *
	 * @since  1.6.0
	 *
	 * @return  array
	 */
	public static function get_tags_block(): array {

		// Output

			return array(

				'div' => array(),
				'h1'  => array(),
				'h2'  => array(),
				'h3'  => array(),
				'h4'  => array(),
				'h5'  => array(),
				'h6'  => array(),
				'li'  => array(),
				'ol'  => array(),
				'p'   => array(),
				'ul'  => array(),
			);

	} // /get_tags_block

	/**
	 * Table tags.
	 *
	 * @since  1.6.0
	 *
	 * @return  array
	 */
	public static function get_tags_table(): array {

		// Output

			return array(

				'caption'  => array(),
				'colgroup' => array(),
				'col'      => array(),
				'table'    => array(),
				'thead'    => array(),
				'tbody'    => array(),
				'tfoot'    => array(),
				'tr'       => array(),
				'th'       => array( 'colspan' => true, ),
				'td'       => array( 'colspan' => true, ),
			);

	} // /get_tags_table

	/**
	 * Image tags.
	 *
	 * @since  1.6.0
	 *
	 * @return  array
	 */
	public static function get_tags_image(): array {

		// Output

			return array(

				'img' => array(
					'alt'    => true,
					'height' => true,
					'src'    => true,
					'width'  => true,
				),

				'figure'     => array(),
				'figcaption' => array(),
			);

	} // /get_tags_image

	/**
	 * Source tag.
	 *
	 * @since  1.6.0
	 *
	 * @return  array
	 */
	public static function get_tags_source(): array {

		// Output

			return array(

				// For media shortcode output, such as `[audio]`.
				'source' => array(
					'height' => true,
					'media'  => true,
					'sizes'  => true,
					'src'    => true,
					'srcset' => true,
					'type'   => true,
					'width'  => true,
				),
			);

	} // /get_tags_source

	/**
	 * iFrame tag.
	 *
	 * @since  1.6.1
	 *
	 * @return  array
	 */
	public static function get_tags_iframe(): array {

		// Output

			return array(

				// For embed media (`[embed]` shortcode).
				'iframe' => array(
					'allow'           => true,
					'allowfullscreen' => true,
					'height'          => true,
					'loading'         => true,
					'name'            => true,
					'referrerpolicy'  => true,
					'sandbox'         => true,
					'src'             => true,
					'srcdoc'          => true,
					'width'           => true,
				),
			);

	} // /get_tags_iframe

	/**
	 * Tag attributes.
	 *
	 * @since  1.6.0
	 *
	 * @param  string $context
	 *
	 * @return  array
	 */
	public static function get_atts( string $context ): array {

		// Processing

			switch ( $context ) {

				case 'a':
					return array(
						'href'   => true,
						'rel'    => true,
						'target' => true,
					);

				case 'form':
					return array(
						'autocomplete' => true,
						'autocorrect'  => true,
						'autofocus'    => true,
						'checked'      => true,
						'cols'         => true,
						'disabled'     => true,
						'for'          => true,
						'label'        => true,
						'list'         => true,
						'max'          => true,
						'maxlength'    => true,
						'min'          => true,
						'minlength'    => true,
						'multiple'     => true,
						'name'         => true,
						'pattern'      => true,
						'placeholder'  => true,
						'readonly'     => true,
						'required'     => true,
						'rows'         => true,
						'selected'     => true,
						'size'         => true,
						'spellcheck'   => true,
						'step'         => true,
						'type'         => true,
						'value'        => true,
					);
			}

	} // /get_atts

}

add_filter( 'wp_kses_allowed_html', 'WMA_KSES::tags', 10, 2 );
