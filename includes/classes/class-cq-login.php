<?php

class cqCustomLogin {

  private $plugin_name = 'cq-auctions';

  public static function init() {
    $self = new self();
    add_action( 'init', array( $self, 'ajax_login_init' ) );
	add_action( 'init', array( $self, 'hide_admin_bar' ) );
	add_action( 'admin_init', array( $self, 'block_wp_admin') );
	add_action( 'wp_footer', array($self, 'cq_login_form_popup') );
	add_action( 'wp_ajax_nopriv_ajaxlogin', array($self, 'ajax_login') );
	add_action( 'template_redirect', array($self, 'redirect_not_logged_in') );
	add_action( 'the_post', array( $self, 'login_page_content' ) );
	add_action( 'the_post', array( $self, 'lost_password_page_content' ) );
	add_action( 'the_post', array( $self, 'reset_password_page_content' ) );
	add_action( 'login_form_lostpassword', array( $self, 'redirect_to_lostpassword' ) );
	add_action( 'login_form_lostpassword', array( $self, 'do_password_lost' ) );
	add_action( 'login_form_rp', array( $self, 'redirect_to_custom_password_reset' ) );
	add_action( 'login_form_resetpass', array( $self, 'redirect_to_custom_password_reset' ) );
	add_action( 'login_form_rp', array( $self, 'do_password_reset' ) );
	add_action( 'login_form_resetpass', array( $self, 'do_password_reset' ) );
	add_filter( 'retrieve_password_message', array( $self, 'custom_password_reset_email'), 99, 4);
	add_filter( 'retrieve_password_title', array( $self, 'custom_password_reset_title'));
	add_filter( 'wp_mail_content_type', array( $self, 'wp_set_html_mail_content_type') );
    add_filter( 'wp_mail_from_name', array( $self, 'wp_set_mail_from_name') );
	//add_filter( 'lostpassword_url',  array( $self, 'rename_lostpassword_url'), 999, 2 );
  }

  public function ajax_login_init() {
      
    	wp_localize_script( 'auction-js', 'ajax_login_object', array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'redirecturl' => home_url(),
      		'loadingmessage' => __( 'Sending user info, please wait...' )
    	) );

  }

  public function cq_login_form_popup( $attributes ) {
	
	if (!is_user_logged_in() && !is_page( array( 'log-in'))) {
    	echo '<form id="login" class="login_form" action="login" method="post">
    					<h1>Sign In</h1>
    					<p class="status"></p>
    					<label for="username">Username</label>
    					<input id="username" type="text" name="username">
    					<label for="password">Password</label>
    					<input id="password" type="password" name="password">
    					<a class="lost" href="' . wp_lostpassword_url() . '">Lost your password?</a>
<input class="submit_button button button-category button-fill" type="submit" value="Login" name="submit">
<a class="get-account" href="' . get_permalink( get_page_by_path( 'register' ) ) . '">Not got an account? Create one here</a>
<span class="close" href=""><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/></svg></span>' .
     						wp_nonce_field( 'ajax-login-nonce', 'security' ) . '
</form>';
	
	}
	  
  }
	
  public function login_page_content($content) {
		
		global $wp_query;
		
		if ( isset($wp_query->query_vars['pagename']) && $wp_query->query_vars['pagename'] == 'log-in' && !is_user_logged_in()) {
               add_filter('the_content', array( $this, 'cq_login_page_content'));
		}
	}
	
  public function lost_password_page_content($content) {
		
		global $wp_query;
		
		if ( isset($wp_query->query_vars['pagename']) && $wp_query->query_vars['pagename'] == 'password-lost' && !is_user_logged_in()) {
               add_filter('the_content', array( $this, 'cq_lost_password_page_content'));
		}
	}
	
  public function reset_password_page_content($content) {
		
		global $wp_query;
		
		if ( isset($wp_query->query_vars['pagename']) && $wp_query->query_vars['pagename'] == 'password-reset' && !is_user_logged_in()) {
               add_filter('the_content', array( $this, 'cq_reset_password_page_content'));
		}
	}
	
  public function cq_login_page_content( $content ) {
	
	if (!is_user_logged_in()) {
		
		// Check if the user just requested a new password 
		$attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';
		$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';
		 $messages = '';
		
		if ( $attributes['lost_password_sent'] ) {
    		 $messages .= '<span class="message alert alert-success">Check your email for a link to reset your password.</span>';
		}
		
		if ( $attributes['password_updated'] ) {
        	 $messages .= '<span class="message alert alert-success">Your password has been changed. You can sign in now.</span>';
        }

    	$content = '<div class="container">
                        <div class="row login-form">
                            <div class="col-md-6 offset-md-3 form-wrap">
                            <div class="col-md-12">
                                <h2>Sign In</h2>
                            </div>
                            <div class="col-md-12">'
                                . $messages . 
                            '</div>
                            <div class="col-md-12">
                                <form id="cq_auction_login_form" class="login_form" action="login" method="post">
                                    <p class="status"></p>
                                    <div class="user-field-wrapper">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" name="username">
                                    </div>
                                    <div class="user-field-wrapper">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" name="password">
                                    </div>
                                    <a class="lost" href="' . wp_lostpassword_url(get_permalink()) . '">Lost your password?</a>
                                    <div class="user-field-wrapper">
                                    <input class="submit_button button button-category button-fill" type="submit" value="Login" name="submit">
                                    </div>' . wp_nonce_field( 'ajax-login-nonce', 'security' ) . '
                                </form>
                                </div>
                                <div class="col-md-12">
                                <p><a href="' . get_permalink( get_page_by_path( 'register' ) ) . '" class="login-link">If you don\'t have an account, register here.</a></p>
                                </div>
                            </div>
                        </div>
                </div>';
		
		return $content;
	
	}
	  
  }
	
    public function cq_lost_password_page_content( $content ) {
	
		if (!is_user_logged_in()) {
		
			// Retrieve possible errors from request parameters
			$attributes['errors'] = array();
			$messages = '';
			if ( isset( $_REQUEST['errors'] ) ) {
    			$error_codes = explode( ',', $_REQUEST['errors'] );
 
    			foreach ( $error_codes as $error_code ) {
        			$messages .= '<span class="message error alert alert-danger">' . $this->get_error_message( $error_code ) . '</span>';
    			}
			}
		
    	$content = '<div class="container">
                      <div class="row lost-password-form">
						<div class="col-md-6 offset-md-3 form-wrap">
						<div class="col-md-12">
							<h2>Reset your password</h2>
						</div>
						<div class="col-md-12">
							'. $messages . '
						</div>
						<div class="col-md-12">
							<form id="lostpasswordform" class="lost_pw_form" action="' . wp_lostpassword_url() . '" method="post">
								<p>Enter your email address and we\'ll send you a link you can use to pick a new password</p>
            					<label for="user_login">Email
            					<input type="text" name="user_login" id="user_login"></label>
								<input type="hidden" name="redirect_to" value="">
            					<input type="submit" name="submit" class="submit_button lostpassword-button button button-category button-fill" value="Reset Password"/>' .
     						wp_nonce_field( 'lp-nonce', 'security' ) . '
    						</form>
						</div>
						</div>
					<div>
                 </div>';
		
		return $content;
	
	}
	  
  }
	
  public function cq_reset_password_page_content( $content ) {
    // Parse shortcode attributes
    $attributes = array( 'show_title' => false );
 
    if ( is_user_logged_in() ) {
        return __( 'You are already signed in.', 'personalize-login' );
    } else {
        if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
            $attributes['login'] = $_REQUEST['login'];
            $attributes['key'] = $_REQUEST['key'];
 
            // Error messages
            $errors = array();
            if ( isset( $_REQUEST['error'] ) ) {
                $error_codes = explode( ',', $_REQUEST['error'] );
 
                foreach ( $error_codes as $code ) {
                    $errors []= $this->get_error_message( $code );
                }
            }
            $attributes['errors'] = $errors;
			
			$rp_content = '<div class="container">
                        <div class="row lost-password-form">
						<div class="col-md-6 offset-md-3 form-wrap">
						<div class="col-md-12">
						<form name="resetpassform" id="resetpassform" class="lost_pw_form" action="' . site_url( 'wp-login.php?action=resetpass' ) . '" method="post" autocomplete="off">
        <input type="hidden" id="user_login" name="rp_login" value="' . esc_attr( $attributes['login'] ) . '" autocomplete="off" />
        <input type="hidden" name="rp_key" value="' . esc_attr( $attributes['key'] ) . '" />';
         
        if ( count( $attributes['errors'] ) > 0 ) : 
             foreach ( $attributes['errors'] as $error ) : 
               
                    $rp_content .= '<span class="message error alert alert-danger">' .  $error . '</span>';
			
             endforeach; 
         endif;
            $rp_content .= '<label for="pass1">New password
            <input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" /></label>
        
            <label for="pass2">Repeat new password
            <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" /></label>
        
         
            <p class="description">' . wp_get_password_hint() .'</p>
         
        
            <input type="submit" name="submit" id="resetpass-button"
                   class="submit_button button button-category button-fill" value="Reset Password" />
        
    		</form>
			</div>
			</div>
			</div>
            </div>';
 
            return $rp_content;
        } else {
            return __( 'Invalid password reset link.', 'personalize-login' );
        }
    }
}
	
  public function ajax_login() {

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info[ 'user_login' ] = $_POST[ 'username' ];
    $info[ 'user_password' ] = $_POST[ 'password' ];
    $info[ 'remember' ] = true;
	$info['redirect'] = $_POST['_wp_http_referer'];

    $user_signon = wp_signon( $info, false );
      
    if ( !is_wp_error( $user_signon ) ) {
      wp_set_current_user( $user_signon->ID );
      wp_set_auth_cookie( $user_signon->ID );
	 
	  $response = array( 'loggedin' => true, 'message' => __( 'Login successful, redirecting...' ));
						
	  if (isset($_POST['_wp_http_referer']) && !strpos($info['redirect'], 'log-in') && !strpos($info['redirect'], 'register') && !strpos($info['redirect'], 'password-lost')) {
		  $response['redirect'] = $info['redirect'];
	  }
	  
      echo json_encode( $response );
    } else {
	  echo json_encode( array( 'loggedin' => false, 'message' => __( $this->get_error_message($user_signon->get_error_code(), $user_signon->get_error_message()) ) ) );
	}

    die();
  }
	
  public function redirect_to_lostpassword() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        if ( is_user_logged_in() ) {
            wp_redirect( home_url( 'my-account' ) );
            exit;
        }
 
        wp_redirect( home_url( 'password-lost' ) );
        exit;
    }
  }
	
  public function redirect_to_custom_password_reset() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        // Verify key / login combo
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( 'log-in?login=expiredkey' ) );
            } else {
                wp_redirect( home_url( 'log-in?login=invalidkey' ) );
            }
            exit;
        }
 
        $redirect_url = home_url( 'password-reset' );
        $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
        $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
 
        wp_redirect( $redirect_url );
        exit;
    }
}
	
  /**
 * Initiates password reset.
 */
  public function do_password_lost() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $errors = retrieve_password();
        
        if ( is_wp_error( $errors ) ) {
            // Errors found
            $redirect_url = home_url( 'password-lost' );
            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
        } else {
            // Email sent
            $redirect_url = home_url( 'log-in' );
            $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
        }
 
        wp_redirect( $redirect_url );
        exit;
    }
  }
	
  public function do_password_reset() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $rp_key = $_REQUEST['rp_key'];
        $rp_login = $_REQUEST['rp_login'];
 
        $user = check_password_reset_key( $rp_key, $rp_login );
 
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( 'log-in?login=expiredkey' ) );
            } else {
                wp_redirect( home_url( 'log-in?login=invalidkey' ) );
            }
            exit;
        }
 
        if ( isset( $_POST['pass1'] ) ) {
            if ( $_POST['pass1'] != $_POST['pass2'] ) {
                // Passwords don't match
                $redirect_url = home_url( 'password-reset' );
 
                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
 
                wp_redirect( $redirect_url );
                exit;
            }
 
            if ( empty( $_POST['pass1'] ) ) {
                // Password is empty
                $redirect_url = home_url( 'password-reset' );
 
                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
 
                wp_redirect( $redirect_url );
                exit;
            }
 
            // Parameter checks OK, reset password
            reset_password( $user, $_POST['pass1'] );
            wp_redirect( home_url( 'log-in?password=changed' ) );
        } else {
            echo "Invalid request.";
        }
 
        exit;
    }
}
	
  public function redirect_not_logged_in() {

	// Get global post
	global $post;

	// Prevent access to page with ID of 2 and all children of this page
	$page = get_page_by_path( 'my-account' );
	$page_id = $page->ID;
	if ( is_page() && ( $post->post_parent == $page_id || is_page( $page_id ) ) ) {

		// Set redirect to true by default
		$redirect = true;

		// If logged in do not redirect
		// You can/should place additional checks here based on user roles or user meta
		if ( is_user_logged_in() ) {
			$redirect = false;
		}

		// Redirect people without access to login page
		if ( $redirect ) {
			wp_redirect( esc_url( get_permalink( get_page_by_path( 'log-in' ) ) ), 307 );
		}
	}

  }
	
  public function hide_admin_bar() {
	  if (!current_user_can('manage_categories')) {
  		add_filter('show_admin_bar','__return_false');
	  }
  }
	
  function remove_read(){  
    $role = get_role( 'subscriber' );
    $role->remove_cap( 'read' );    
  }
	
  function block_wp_admin() {
	if ( is_admin() && !current_user_can( 'manage_categories' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) && !strpos($_SERVER['REQUEST_URI'], 'admin-post.php') ) {
		wp_redirect( site_url() );
		exit;
	}
}
	
  private function get_error_message( $error_code, $error_message = '' ) {
    switch ( $error_code ) {
        case 'empty_username':
            return __( 'You do have an email address, right?', 'personalize-login' );
 
        case 'empty_password':
            return __( 'You need to enter a password to login.', 'personalize-login' );
 
        case 'invalid_username':
            return __(
                "We don't have any users with that email address. Maybe you used a different one when signing up?",
                'personalize-login'
            );
        case 'ip_blocked':
            if ($error_message != '') {
                return __($error_message, 'CQ_custom');
            } else {
              return __(
                  "Too many failed log in attempts. Please try later."
              );
            }
        case 'incorrect_password':
            $err = __(
                "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
                'personalize-login'
            );
            return sprintf( $err, wp_lostpassword_url() );
 		// Lost password
 
	   case 'empty_username':
    	return __( 'You need to enter your email address to continue.', 'personalize-login' );
 
	   case 'invalid_email':
	   case 'invalidcombo':
    	return __( 'There are no users registered with this email address.', 'personalize-login' );
       default:
            return __( 'An error occured, please try later.', 'personalize-login' );
            break;
    }
     
    return __( 'An unknown error occurred. Please try again later.', 'personalize-login' );
  }
	
  function rename_lostpassword_url($lostpassword_url, $redirect) {
      return get_permalink( get_page_by_path( 'password-lost' ) );
  }

  function custom_password_reset_email($message, $key, $user_login, $user_data )    {
    
	$user = array('email' => $user_data->user_email,
				  'link' => network_site_url("wp-login.php?action=rp&key=" . $key . "&login=" . rawurlencode($user_login), 'login') );
	  
	ob_start();
	cq_get_template( 'email/reset-password.php', $user );
	$message = ob_get_contents();
	ob_end_clean();

    return $message;

  }
	
  function custom_password_reset_title( $title ) {
    $title = __( 'Password reset for ' . get_bloginfo( 'name' ) );
    return $title;
  }
	
  function wp_set_html_mail_content_type() {
    return 'text/html';
  }
    
  function wp_set_mail_from_name( $old ) {
        return get_bloginfo( 'name' ); // Edit it with your/company name
   }
		
}
cqCustomLogin::init();