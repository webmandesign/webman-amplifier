<?php
/**
 * Countdown timer
 *
 * This file is being included into "../class-shortcodes.php" file's shortcode_render() method.
 *
 * @since    1.0
 * @version  1.2.9.1
 *
 * @uses  $codes_globals['sizes']['values']
 *
 * @param  string class
 * @param  string size
 * @param  string time
 */



//Shortcode attributes
	$defaults = apply_filters( 'wmhook_shortcode_' . '_defaults', array(
			'class' => '',
			'size'  => '',
			'time'  => ''
		), $shortcode );
	$atts = apply_filters( 'wmhook_shortcode_' . '_attributes', $atts, $shortcode );
	$atts = shortcode_atts( $defaults, $atts, $prefix_shortcode . $shortcode );

//Validation
	//size
		$atts['size'] = trim( $atts['size'] );
		if ( $atts['size'] && in_array( $atts['size'], array_keys( $codes_globals['sizes']['values'] ) ) ) {
			$atts['class'] .= ' size-' . $codes_globals['sizes']['values'][ $atts['size'] ];
		}
	//url
		$atts['time'] = strtotime( trim( $atts['time'] ) );
		if ( ! $atts['time'] || strtotime( 'now' ) > $atts['time'] ) {
			$atts['time'] = '';
		}
	//class
		$atts['class'] = trim( 'wm-countdown-timer ' . trim( $atts['class'] ) );
		$atts['class'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_classes', $atts['class'], $atts );
	//labels
		$atts['labels'] = array(
				'weeks'   => __( 'Weeks', 'webman-amplifier' ),
				'days'    => __( 'Days', 'webman-amplifier' ),
				'hours'   => __( 'Hours', 'webman-amplifier' ),
				'minutes' => __( 'Minutes', 'webman-amplifier' ),
				'seconds' => __( 'Seconds', 'webman-amplifier' ),
			);
		$atts['labels'] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_labels', $atts['labels'] );

//Helper variables
	$wm_countdown_timer_id = rand( 100, 999 );

//Output
	if ( $atts['time'] ) {

		$output = '<div class="' . esc_attr( $atts['class'] ) . '">
					<div id="wm-countdown-timer-' . $wm_countdown_timer_id . '">
						<div class="dash weeks_dash">
							<div class="dash_title">' . $atts['labels']['weeks'] . '</div>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash days_dash">
							<div class="dash_title">' . $atts['labels']['days'] . '</div>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash hours_dash">
							<div class="dash_title">' . $atts['labels']['hours'] . '</div>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash minutes_dash">
							<div class="dash_title">' . $atts['labels']['minutes'] . '</div>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash seconds_dash">
							<div class="dash_title">' . $atts['labels']['seconds'] . '</div>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>
					</div>
				</div>

			<script><!--
			jQuery( function() {
				if ( jQuery().countDown ) {
					jQuery( "#wm-countdown-timer-' . $wm_countdown_timer_id . '" ).countDown( {
						targetDate: {
							"day"   : ' . date( 'j', $atts['time'] ) . ',
							"month" : ' . date( 'n', $atts['time'] ) . ',
							"year"  : ' . date( 'Y', $atts['time'] ) . ',
							"hour"  : ' . date( 'G', $atts['time'] ) . ',
							"min"   : ' . intval( date( 'i', $atts['time'] ) ) . ',
							"sec"   : 0
						}
					} );
				}
			} );
			//--></script>';

		//Enqueue scripts
			$enqueue_scripts = array(
					'jquery-lwtCountdown'
				);

			wma_shortcode_enqueue_scripts( $shortcode, $enqueue_scripts, $atts );

	} // /if $atts['time']

?>