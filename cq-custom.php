<?php
/*
Plugin Name: CQ Custom
Plugin URI: https://www.qinternet.uk/
Description: Custom setup and functionality for Cruise Trade News.
Version: 2.1.39
Author: Chris Quee
Author URI: https://www.qinternet.uk/
License: Custom
Text Domain: cq_custom
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

require_once('includes/loader.php');

require_once('vendor/plugin-update-checker/plugin-update-checker.php');
$ctnUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/chrisquee/ctn-custom-2023/',
	__FILE__,
	'cq-custom'
);
$token = get_option('github_access_token');
$ctnUpdateChecker->setBranch('master');
$ctnUpdateChecker->setAuthentication($token);

define( 'CQ_CUSTOM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CQ_CUSTOM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CQ_CUSTOM_TEMPLATES_URL', plugin_dir_url( __FILE__ )  . 'includes/templates/' );
define( 'CQ_CUSTOM_TEMPLATES_PATH', plugin_dir_path( __FILE__ ) . 'includes/templates/' );

//add_filter( 'jwt_auth_whitelist', 'cq_jwt_whitelist');
function cq_jwt_whitelist($endpoints) {
        
    $allowed_endpoints = array(
            '/jwt-auth/v1/token/validate',
            '/jwt-auth/v1/token',
            '/oauth/authorize',
            '/oauth/token',
            '/oauth/me',
            '/contact-form-7/v1/contact-forms/\d{0,15}/feedback',
            '/contact-form-7/v1/contact-forms/\d{0,15}/refill',
            '/litespeed/v1/token',
        );

    return array_unique( array_merge( $endpoints, $allowed_endpoints ) );

}

//add_filter( 'jwt_auth_default_whitelist', 'cq_modify_default_jwt_whitelist' );
function cq_modify_default_jwt_whitelist( $default_whitelist ) {
        
    unset($default_whitelist['/wp-json/wp/v2/']);
    
    $default_whitelist[] = '/wp-json/contact-form-7/';
    $default_whitelist[] = '/wp-json/yoast/v1/';

    return $default_whitelist;

}

if ( ! function_exists( 'require_auth_for_all_endpoints' ) ) {
	//add_filter( 'rest_pre_dispatch', 'require_auth_for_all_endpoints', 10, 3 );
	function require_auth_for_all_endpoints( $result, $server, $request ) {
		if ( !is_user_logged_in() ) {

			// Only allow these endpoints: JWT Auth.
			$allowed_endpoints = array(
				'/jwt-auth/v1/token/validate',
				'/jwt-auth/v1/token',
				'/oauth/authorize',
				'/oauth/token',
				'/oauth/me',
                '/contact-form-7/v1/contact-forms/',
                '/contact-form-7/v1/contact-forms/\d{0,15}/feedback',
                '/contact-form-7/v1/contact-forms/\d{0,15}/refill',
                '/litespeed/v1/token',
                '/yoast/v1/'
			);
			$allowed_endpoints = apply_filters( 'reqauth/allowed_endpoints', $allowed_endpoints );

			// Endpoint checker.
			$regex_checker = '#^(' . join( '|', $allowed_endpoints ) . ')#';
			$regex_checker = apply_filters( 'reqauth/regex_checker', $regex_checker );

			$is_allowed = preg_match( $regex_checker, $request->get_route() );
			$is_allowed = apply_filters( 'reqauth/is_allowed', $is_allowed );

			if ( ! $is_allowed ) {
				return new WP_Error( 'rest_not_logged_in', __( 'You are not currently logged in.' ), array( 'status' => 401 ) );
			}
		}
	}
}