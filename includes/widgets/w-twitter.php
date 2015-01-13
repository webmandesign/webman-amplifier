<?php
/**
 * Widget: Twitter
 *
 * This widget requires OAuth library files to retrieve tweets.
 *
 * @package     WebMan Amplifier
 * @subpackage  Widgets
 *
 * @since    1.0.9.9
 * @version  1.1
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Helpers
 * - 30) Widget class
 */



//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		add_action( 'widgets_init', 'wm_twitter_registration' );





/**
 * 20) Helpers
 */

	/**
	 * Widget registration
	 */
	function wm_twitter_registration() {
		register_widget( 'WM_Twitter' );
	} // /wm_twitter_registration





/**
 * 30) Widget class
 */

	class WM_Twitter extends WP_Widget {

		/**
		 * @var  string Transient cache variable name (saving user data)
		 */
		private $user_transient;

		/**
		 * @var  string Option name storing tweets cache
		 */
		private $tweets_option;

		/**
		 * @var  string Option name to store Twitter API variables
		 */
		private $twitter_api;



		/**
		 * Constructor
		 */
		function __construct() {

			//Helper variables
				$atts = array();

				$atts['name'] = ( defined( 'WM_THEME_NAME' ) ) ? ( WM_THEME_NAME . ' ' ) : ( '' );

				$atts['id']          = 'wm-twitter';
				$atts['name']       .= _x( 'Twitter', 'Widget name.', 'wm_domain' );
				$atts['widget_ops']  = array(
						'classname'   => 'wm-twitter',
						'description' => _x( 'Your recent tweets', 'Widget description.', 'wm_domain' )
					);
				$atts['control_ops'] = array();

				$atts = apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_atts', $atts );

				//Set globals
					$transient_prefix = ( defined( 'WM_THEME_SHORTNAME' ) ) ? ( WM_THEME_SHORTNAME . '_' ) : ( 'wmamp_' );

					$this->user_transient = $transient_prefix . 'twitter_v2_user_';
					$this->tweets_option  = $transient_prefix . 'twitter_v2_tweets_';
					$this->twitter_api    = $transient_prefix . 'twitter_v2_api';

			//Register widget attributes
				parent::__construct( $atts['id'], $atts['name'], $atts['widget_ops'], $atts['control_ops'] );

		} // /__construct



		/**
		 * Options form
		 */
		function form( $instance ) {

			//Helper variables
				$instance = wp_parse_args( $instance, apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_defaults', array(
						'count'    => 3,
						'replies'  => false,
						'title'    => '',
						'userinfo' => false,
						'username' => '',
					) ) );

				//Twitter API 1.1
					$twitter_api         = get_option( $this->twitter_api );
					$consumer_key        = ( isset( $twitter_api['consumer_key'] ) ) ? ( $twitter_api['consumer_key'] ) : ( '' );
					$consumer_secret     = ( isset( $twitter_api['consumer_secret'] ) ) ? ( $twitter_api['consumer_secret'] ) : ( '' );
					$access_token        = ( isset( $twitter_api['access_token'] ) ) ? ( $twitter_api['access_token'] ) : ( '' );
					$access_token_secret = ( isset( $twitter_api['access_token_secret'] ) ) ? ( $twitter_api['access_token_secret'] ) : ( '' );

			//Output
				?>
				<p class="wm-desc"><?php _ex( 'Displays recent tweets from specific Twitter account. Also displays Twitter account details. Tweets are being cached to optimize the page loading speeds.', 'Widget description.', 'wm_domain' ) ?></p>

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Twitter username:', 'wm_domain' ) ?></label><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $instance['username'] ); ?>" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of tweets to display:', 'wm_domain' ) ?></label><br />
					<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo absint( $instance['count'] ); ?>" size="5" maxlength="2" min="1" max="10" />
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'userinfo' ); ?>" name="<?php echo $this->get_field_name( 'userinfo' ); ?>" type="checkbox" <?php checked( $instance['userinfo'], 'on' ); ?>/>
					<label for="<?php echo $this->get_field_id( 'userinfo' ); ?>"><?php _e( 'Display Twitter user info', 'wm_domain' ); ?></label>
				</p>

				<p>
					<input id="<?php echo $this->get_field_id( 'replies' ); ?>" name="<?php echo $this->get_field_name( 'replies' ); ?>" type="checkbox" <?php checked( $instance['replies'], 'on' ); ?>/>
					<label for="<?php echo $this->get_field_id( 'replies' ); ?>"><?php _e( 'Display reply tweets', 'wm_domain' ); ?></label>
				</p>

				<!-- Twitter API -->

					<p class="wm-desc-separator">
						<strong><?php _e( 'Twitter API settings', 'wm_domain' ) ?></strong><br />
						<?php _e( 'To set the fields below you need to <a href="https://dev.twitter.com/apps" target="_blank">create a Twitter Application</a>. See theme user manual for more info.', 'wm_domain' ) ?>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'consumer_key' ); ?>"><?php _e( 'Consumer key:', 'wm_domain' ) ?></label><br />
						<input class="widefat" id="<?php echo $this->get_field_id( 'consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'consumer_key' ); ?>" type="text" value="<?php echo esc_attr( $consumer_key ); ?>" />
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'consumer_secret' ); ?>"><?php _e( 'Consumer secret:', 'wm_domain' ) ?></label><br />
						<input class="widefat" id="<?php echo $this->get_field_id( 'consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'consumer_secret' ); ?>" type="text" value="<?php echo esc_attr( $consumer_secret ); ?>" />
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php _e( 'Access token:', 'wm_domain' ) ?></label><br />
						<input class="widefat" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>" />
					</p>

					<p>
						<label for="<?php echo $this->get_field_id( 'access_token_secret' ); ?>"><?php _e( 'Access token secret:', 'wm_domain' ) ?></label><br />
						<input class="widefat" id="<?php echo $this->get_field_id( 'access_token_secret' ); ?>" name="<?php echo $this->get_field_name( 'access_token_secret' ); ?>" type="text" value="<?php echo esc_attr( $access_token_secret ); ?>" />
					</p>
				<?php

				do_action( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_form', $instance );

		} // /form



		/**
		 * Save the options
		 */
		function update( $new_instance, $old_instance ) {

			//Helper variables
				$instance = $old_instance;

				$old_instance = array(
						'username' => isset( $instance['username'] ) ? ( $instance['username'] ) : ( '' ),
						'count'    => isset( $instance['count'] ) ? ( $instance['count'] ) : ( '' ),
					);

			//Preparing output
				$instance['count']    = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 3 );
				$instance['replies']  = $new_instance['replies'];
				$instance['title']    = $new_instance['title'];
				$instance['username'] = sanitize_title( trim( strip_tags( $new_instance['username'] ) ) );
				$instance['userinfo'] = $new_instance['userinfo'];

				//Twitter API 1.1
					$twitter_api                        = array();
					$twitter_api['consumer_key']        = trim( $new_instance['consumer_key'] );
					$twitter_api['consumer_secret']     = trim( $new_instance['consumer_secret'] );
					$twitter_api['access_token']        = trim( $new_instance['access_token'] );
					$twitter_api['access_token_secret'] = trim( $new_instance['access_token_secret'] );

					//Remove empty values
						$twitter_api = array_filter( $twitter_api );

					//Save Twitter API variables globally
						update_option( $this->twitter_api, $twitter_api );

				//Flush Tweets cache if username or count changed
					if (
							$instance['username'] != $old_instance['username']
							|| $instance['count'] != $old_instance['count']
						) {
						$transient_prefix = ( defined( 'WM_THEME_SHORTNAME' ) ) ? ( WM_THEME_SHORTNAME . '_' ) : ( 'wmamp_' );
						delete_transient( $transient_prefix . 'tweets_id_' . esc_attr( $instance['username'] ) );
					}

			//Output
				return apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_instance', $instance, $new_instance, $old_instance );

		} // /update



		/**
		 * Widget HTML
		 */
		function widget( $args, $instance ) {

			//Helper variables
				$output = '';

				$instance = wp_parse_args( $instance, apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_defaults', array(
						'count'    => 3,
						'replies'  => false,
						'title'    => '',
						'userinfo' => false,
						'username' => '',
					) ) );

				$instance['count'] = ( 0 < absint( $instance['count'] ) ) ? ( absint( $instance['count'] ) ) : ( 3 );
				if ( 10 < $instance['count'] ) {
					$instance['count'] = 10;
				}

				$user = $tweets = array();

				//Twitter API 1.1
					$twitter_api         = get_option( $this->twitter_api );
					$consumer_key        = ( isset( $twitter_api['consumer_key'] ) ) ? ( $twitter_api['consumer_key'] ) : ( '' );
					$consumer_secret     = ( isset( $twitter_api['consumer_secret'] ) ) ? ( $twitter_api['consumer_secret'] ) : ( '' );
					$access_token        = ( isset( $twitter_api['access_token'] ) ) ? ( $twitter_api['access_token'] ) : ( '' );
					$access_token_secret = ( isset( $twitter_api['access_token_secret'] ) ) ? ( $twitter_api['access_token_secret'] ) : ( '' );


			//Praparing output
				//Get tweets
					if (
							$consumer_key
							&& $consumer_secret
							&& $access_token
							&& $access_token_secret
						) {

						//Names of options storing cached data
							$user_option   = $this->user_transient . esc_attr( $instance['username'] );
							$tweets_option = $this->tweets_option . esc_attr( $instance['username'] );

						//Get cache (per user name) if available
							$user = get_transient( $user_option );

						if ( $user ) {
						//Get cached tweets

							$tweets = get_option( $tweets_option );

						} else {
						//Get new tweets and set new cache

							//Load the helper class
								if ( ! class_exists( 'TwitterOAuth' ) ) {
									require_once( WMAMP_INCLUDES_DIR . '/twitter-api/twitteroauth.php' );
								}

							//Set the connection
							$tweetter_connection = new TwitterOAuth(
									$consumer_key,
									$consumer_secret,
									$access_token,
									$access_token_secret
								);

							//Get the tweets
								$tweets = $tweetter_connection->get(
										'statuses/user_timeline',
										array(
												'screen_name'     => $instance['username'],
												'count'           => 12,
												'exclude_replies' => ! $instance['replies'],
											)
									);

							if ( 200 != $tweetter_connection->http_code ) {
							//Response is not "OK" -> just get cached tweets

								$tweets = get_option( $tweets_option, $tweets );

							} elseif ( ! empty( $tweets ) ) {
							//We got tweets, process them

								$i = 0;
								$tweets_processed = array();

								foreach ( $tweets as $tweet ) {
									$i++;
									if ( 1 === $i && isset( $tweet->user ) ) {
										$user = array(
												'name'        => (string) $tweet->user->name,
												'screen_name' => (string) $tweet->user->screen_name,
												'description' => (string) $tweet->user->description,
												'image'       => (string) $tweet->user->profile_image_url,
												'utc_offset'  => ( isset( $tweet->user->utc_offset ) ) ? ( (int) $tweet->user->utc_offset ) : ( 0 ),
												'followers'   => absint( $tweet->user->followers_count )
											);
									}
									$tweets_processed[] = array(
											'text'    => trim( $this->filter_tweet( $tweet->text ) ),
											'created' => strtotime( $tweet->created_at )
										);
									if ( $instance['count'] === $i ) {
										break;
									}
								}

								$tweets = $tweets_processed;

							}

							//Set cache
								if ( $user ) {
									set_transient( $user_option, $user, apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_cache_interval', 900 ) );
								}
								update_option( $tweets_option, $tweets );

						}

					}

				//Actual output
					$output .= $args['before_widget'];

					if ( trim( $instance['title'] ) ) {
						$output .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
					}

					$output .= '<div class="wm-twitter-container">';

					if ( $tweets ) {

						//User info
							if ( $instance['userinfo'] && ! empty( $user ) ) {

								$output_user  = '<div class="user-info">';
								$output_user .= '<a href="http://twitter.com/' . $instance['username'] . '"><img src="' . $user['image'] . '" alt="' . $user['screen_name'] . '" title="' . $user['screen_name'] . '" /></a>';
								$output_user .= '<h3><a href="http://twitter.com/' . $instance['username'] . '">' . $instance['username'] . '</a></h3>';
								$output_user .= ( $user['description'] ) ? ( $user['description'] ) : ( '' );
								$output_user .= '</div>';

								$output .= apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_output_user', $output_user, $args, $instance );

							}

						//Tweets list
							if ( is_array( $tweets ) && ! empty( $tweets ) ) {

								$output_tweets = '';

								foreach ( $tweets as $tweet ) {
									if ( isset( $tweet['text'] ) ) {
										$output_tweets .= '<li>' . $tweet['text'];
										$output_tweets .= ( $user ) ? ( '<div class="tweet-time">' . date_i18n( get_option( 'date_format' ) . ', ' . get_option( 'time_format' ), $tweet['created'] + $user['utc_offset'] ) . '</div>' ) : ( '' );
										$output_tweets .= '</li>';
									}
								}

								$output .= '<ul>' . apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_output_tweets', $output_tweets, $args, $instance ) . '</ul>';

							}

					} else {

						$output .= __( 'No tweets.', 'wm_domain' );

					}

					$output .= '</div>';

					$output .= $args['after_widget'];

			//Output
				echo apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_output', $output, $args, $instance );

		} // /widget



		/**
		 * Filter tweets text
		 *
		 * @param  string $text
		 */
		private function filter_tweet( $text ) {

			if ( apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_enable_filter_tweet', true ) ) {

				//Preparing output
					/**
					 * Fix for some special characters that might be in the actual tweet,
					 * but breaks the WordPress database record (breaks serialization of array).
					 */
					$text = esc_textarea( $text );
					$text = html_entity_decode( str_replace( '&#039;', "'", $text ) );

					//Create links from Twitter predefined strings
						$text = preg_replace(
							'/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',
							"<a href=\"$1\" class=\"twitter-link\">$1</a>",
							$text );
						$text = preg_replace(
							'/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',
							"<a href=\"http://$1\" class=\"twitter-link\">$1</a>",
							$text );
						$text = preg_replace(
							"/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i",
							"<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>",
							$text );
						$text = preg_replace(
							"/#(\w+)/",
							"<a class=\"twitter-link\" href=\"http://search.twitter.com/search?q=\\1\">#\\1</a>",
							$text );
						$text = preg_replace(
							"/@(\w+)/",
							"<a class=\"twitter-link\" href=\"http://twitter.com/\\1\">@\\1</a>",
							$text );

			}

			//Output
				return apply_filters( WM_WIDGETS_HOOK_PREFIX . 'wm_twitter' . '_filter_tweet', $text );

		} // /filter_tweet

	} // /WM_Twitter

?>