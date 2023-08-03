<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Resend_Welcome_Email' ) ) {

	class Resend_Welcome_Email {

		public function __construct() {

			/* Check user permission */
			if ( ! current_user_can( 'edit_users' ) ) {
				return;
			}

			/* Define constants */
			self::define_constants();

			add_filter( 'user_row_actions',  array( __CLASS__, 'filter_user_row_actions' ), 10, 2 );
			add_filter( 'personal_options', array( __CLASS__, 'personal_options' ), 10, 2 );


			/* Adds admin listeners for processing actions */
			self::add_admin_listeners();
		}

		/**
		 *  Defines constants.
		 */
		public static function define_constants() {
			define( 'RESEND_WELCOME_EMAIL_CURRENT_VERSION', '1.1.9' );
			define( 'RESEND_WELCOME_EMAIL_FILE', __FILE__ );
			define( 'RESEND_WELCOME_EMAIL_URLPATH', plugins_url( ' ', __FILE__ ) );
			define( 'RESEND_WELCOME_EMAIL_PATH', WP_PLUGIN_DIR . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
		}

		/**
		 * Discovers which tests to run and runs them.
		 *
		 * @param array    $actions
		 * @param \WP_User $user
		 *
		 * @return array
		 */
		public static function filter_user_row_actions( array $actions, WP_User $user ) {
			if ( ! ( $link = self::send_welcome_email_url( $user ) ) ) {
				return $actions;
			}

			$actions['send_welcome_email'] = '<a href="' . $link . '">' . esc_html__( 'Resend Welcome Email', 'CQ_Custom' ) . '</a>';

			return $actions;
		}

		/**
		 * Add link in user profile.
		 *
		 * @param \WP_User $user
		 */
		public static function personal_options( WP_User $user ) {
			if ( ! ( $link = self::send_welcome_email_url( $user ) ) ) {
				return;
			}

			?>
			<tr>
				<th scope="row"><?php esc_html_e( 'Welcome Email', 'CQ_Custom' ); ?></th>
				<td>
					<a href="<?php echo $link; ?>"><?php esc_html_e( 'Send New', 'CQ_Custom' ); ?></a>
				</td>
			</tr>
			<?php
		}

		/**
		 * Listens for email send commands and fires them.
		 */
		public static function add_admin_listeners() {
			if ( ! isset( $_GET['action'] ) ||
			     ( 'resend_welcome_email' !== $_GET['action'] )
			) {
				return;
			}

			/* Resend welcome email */
			self::resend_welcome_email();

			/* Register success notice */
			add_action( 'admin_notices', array( __CLASS__, 'define_notice' ) );
			add_action( 'network_admin_notices', array( __CLASS__, 'define_notice' ) );
		}

		/**
		 * Register admin notice that email has been sent.
		 */
		public static function define_notice() {
			?>
			<div class="updated">
				<p><?php esc_html_e( 'Welcome email sent!', 'CQ_Custom' ); ?></p>
			</div>
			<?php
		}

		/**
		 * Helper function. Returns the switch to or switch back URL for a given user.
		 *
		 * @param  WP_User $user The user to be switched to.
		 *
		 * @return string|bool The required URL, or false if there's no old user or the user doesn't have the required capability.
		 */
		public static function send_welcome_email_url( WP_User $user ) {
			return esc_url( wp_nonce_url( add_query_arg( array(
					'action'  => 'resend_welcome_email',
					'user_id' => $user->ID,
				), '' ),
					"send_welcome_email_{$user->ID}" )
			);
		}

		/**
		 * Resends the welcome email.
		 *
		 * @return bool|WP_User WP_User object on success, false on failure.
		 */
		public static function resend_welcome_email() {
			if ( ! isset( $_GET['user_id'] ) ) {
				return false;
			}

			$user_id = $_GET['user_id'];

			if ( ! $user = get_userdata( $user_id ) ) {
				return false;
			}

			wp_new_user_notification( $user_id, null, 'both' );
		}

		/**
		 * Load the text domain for translation.
		 *
		 * since: 1.0.3
		 */


	}

	/**
	 *  Load Resend_Welcome_Email class in init.
	 */
	function Load_Resend_Welcome_Email() {
		new Resend_Welcome_Email();
	}

	add_action( 'admin_init', 'Load_Resend_Welcome_Email', 10 );

}
