<?php

class cqAuctionRegister {
	
	public static function init() {
		
		global $wp_query;
		
    	$self = new self();
    	add_action( 'the_post', array( $self, 'register_page_content' ) );
		add_action( 'template_redirect', array( $self, 'redirect_logged_in' ) );
		add_action( 'login_form_register', array( $self, 'do_register_user' ) );

  	}
	
	public function redirect_logged_in() {
		
		global $wp_query;
		
		if ( $wp_query->query_vars['pagename'] == 'register' && is_user_logged_in()) {
			wp_redirect(get_permalink( get_page_by_path( 'my-account' ) ));
			die;
		}
	}
	
	public function register_page_content($content) {
		
		global $wp_query;
		
		if ( isset($wp_query->query_vars['pagename']) && $wp_query->query_vars['pagename'] == 'register' && !is_user_logged_in()) {
            add_filter('the_content', array( $this, 'cq_register_form'));
            
            $recaptcha_key = get_option('google_recaptcha_key');
            if ($recaptcha_key != false && $recaptcha_key != '') {
                wp_enqueue_script('google-recaptcha-js', 'https://www.google.com/recaptcha/api.js?render=' . $recaptcha_key);
            }
		}
	}
	
	
	public function cq_register_form($content) {
		
		// Retrieve possible errors from request parameters
		$attributes['errors'] = array();
        $messages = '';
        if ( isset( $_REQUEST['register-errors'] ) ) {
            $error_codes = explode( ',', $_REQUEST['register-errors'] );
 
            foreach ( $error_codes as $error_code ) {
                $messages .= '<span class="message error alert alert-danger">' . $this->get_error_message( $error_code ) . '</span>';
            }
        }
        
        $recaptcha_js = '';
        $recaptcha_field = '';
        $recaptcha_key = get_option('google_recaptcha_key');
        
        if ($recaptcha_key != false && $recaptcha_key != '') {
            
            $recaptcha_field = '<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">';
            $recaptcha_js = "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('submitbtn').onclick = function onClick(e) { 
                                        e.preventDefault(); 
                                        grecaptcha.ready(function() { 
                                            grecaptcha.execute('" . $recaptcha_key . "', {action: 'submit' }).then(function(token) { 
                                                document.getElementById('g-recaptcha-response').value = token; 
                                                document.getElementById('cq_auction_signup_form').submit(); 
                                            }); 
                                        }); 
                                    } 
                                    });
                                </script>";
        }
		
		$content = '<div class="row register-form">
						<div class="col-md-8 offset-md-2 form-wrap">
                            <div class="col-md-12">
                                <h2>Register</h2>
                            </div>
                            <div class="col-md-12">
                                '. $messages . '
                            </div>
                            <form id="cq_auction_signup_form" class="register_form" action="' . wp_registration_url() . '" method="post">  
                                <div class="user-field-wrapper">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username">
                                </div>
                                <div class="user-field-wrapper">
                                    <label for="email">Email address</label>   
                                    <input type="text" name="email" id="email">
                                </div>
                                <div class="user-field-wrapper">
                                   <label for="password">Password</label>  
                                   <input type="password" name="password" id="password">
                                </div>
                                <div class="user-field-wrapper">
                                    <label for="password_confirmation">Confirm Password</label>  
                                    <input type="password" name="password_confirmation" id="password_confirmation">  
                                </div>
                                <div class="user-field-wrapper terms">
                                    <input name="terms" id="terms" type="checkbox" value="Yes">  
                                    <label for="terms">I agree to the Terms of Service</label>
                                </div>
                                <div class="">
                                    <input type="submit" id="submitbtn" name="submit" class="submit_button button button-category button-fill" value="Sign Up" />
                                    ' . $recaptcha_field . $recaptcha_js. '
                                </div>

                            </form>
                        </div>
                            
					    <div class="col-md-8 offset-md-2 form-wrap">
				            <h2>Already a member?</h2>
				            <a href="' . get_permalink( get_page_by_path( 'log-in' ) ) . '" class="login-link button button-outline button-category">Click here to sign in to your account.</a>
				        </div>
                            
				    </div>
				</div>';

		return $content;
		
	}
	
	public function do_register_user() {
    if ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] ) {
      $redirect_url = home_url( 'register' );

      if ( !get_option( 'users_can_register' ) ) {
        // Registration closed, display error
        $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
      } else {
        $email = $_POST[ 'email' ];
        $username = sanitize_text_field( $_POST[ 'username' ] );
        $password = sanitize_text_field( $_POST[ 'password' ] );
		$password_confirm = sanitize_text_field( $_POST[ 'password_confirmation' ] );
		$accept_terms = $_POST[ 'terms' ];

        $result = $this->register_user( $email, $username, $password, $password_confirm, $accept_terms );

        if ( is_wp_error( $result ) ) {
          // Parse errors into a string and append as parameter to redirect
          $errors = join( ',', $result->get_error_codes() );
          $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
        } else {
          // Success, redirect to login page.
          $redirect_url = home_url( 'log-in' );
          $redirect_url = add_query_arg( 'registered', $email, $redirect_url );
        }
      }

      wp_redirect( $redirect_url );
      exit;
	}
    }
	
	private function register_user( $email, $username, $password, $password_confirm, $accept_terms ) {
    $errors = new WP_Error();
 
    // Email address is used as both username and email. It is also the only
    // parameter we need to validate
    if ( ! is_email( $email ) ) {
        $errors->add( 'email', $this->get_error_message( 'email' ) );
        //return $errors;
    }
 
    if ( email_exists( $email ) ) {
        $errors->add( 'email_exists', $this->get_error_message( 'email_exists') );
        //return $errors;
    }
	
	if ( username_exists( $username ) ) {
        $errors->add( 'username_exists', $this->get_error_message( 'username_exists') );
        //return $errors;
    }
		
	if ( !$this->validate_username( true, $username ) ) {
		$errors->add( 'invalid_username', $this->get_error_message( 'invalid_username') );
        //return $errors;
	}
	
	if ( $accept_terms != 'Yes' ) {
		$errors->add( 'no_accept_terms', $this->get_error_message( 'no_accept_terms') );
        //return $errors;
	}
	
	if ( $password == '' || $password_confirm == '' ) {
        $errors->add( 'pass_empty', $this->get_error_message( 'pass_empty') );
        //return $errors;
    }
		
	if ( $password != $password_confirm ) {
        $errors->add( 'pass_no_match', $this->get_error_message( 'pass_no_match') );
        //return $errors;
    }
        
    if (!$this->verify_google_recaptcha()) {
        $errors->add( 'invalid_recaptcha', $this->get_error_message( 'invalid_recaptcha') );
    }
 
    // Generate the password so that the subscriber will have to check email...
    //$password = wp_generate_password( 12, false );
 	
	if ( !empty($errors->errors) ) {
		
		//ob_start();
//		print_r($errors);
//		$output = ob_get_contents();
//		ob_end_clean();
//		
//		wp_mail('chris@creativetools.co.uk', 'Error object', $output);
		
		return $errors;
		
	} else {
	
		$user_data = array(
			'user_login' => $username,
			'user_email' => $email,
			'user_pass' => $password,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'nickname' => $first_name,
            'role' => 'subscriber'
		);
	 
		$user_id = wp_insert_user( $user_data );
		wp_new_user_notification( $user_id, $password );
	 
		return $user_id;
	}
}
		  
	private function get_error_message( $error_code ) {
    switch ( $error_code ) {
        // Registration errors
 
		case 'email':
    		return __( 'The email address you entered is not valid.', 'cq-custom' );
 
		case 'email_exists':
    		return __( 'An account exists with this email address.', 'cq-custom' );
		
		case 'username_exists':
    		return __( 'An account exists with this username.', 'cq-custom' );
			
		case 'pass_empty':
			return __( 'You must add a password.', 'cq-custom' );	
		
		case 'pass_no_match':
			return __( 'The passwords don\'t match.', 'cq-custom' );
 
		case 'closed':
    		return __( 'Registering new users is currently not allowed.', 'cq-custom' );
			
		case 'invalid_username':
			return __( 'ERROR: Invalid username. Please ensure your username has a minimum of 5 characters', 'cq-custom' );
		
	    case 'no_accept_terms':
			return __( 'Please accept the terms of service', 'cq-custom' );
            
        case 'invalid_recaptcha':
            return __( 'Suspected spam!', 'cq-custom' );    
       default:
            break;
    }
     
    return __( 'An unknown error occurred. Please try again later.', 'cq-custom' );
  }
	
  public function validate_username($valid, $username) {
        $restricted = array('admin','administrator','adwords', 'author', 'google','profile', 'directory', 'domain', 'download', 'downloads', 'edit', 'editor', 'email', 'ecommerce', 'forum', 'forums', 'favorite', 'feedback', 'follow', 'files', 'gadget', 'gadgets', 'games', 'guest', 'group', 'groups', 'homepage', 'hosting', 'hostname', 'httpd', 'https', 'information', 'image', 'images', 'index', 'invite', 'intranet', 'indice', 'iphone', 'javascript', 'knowledgebase', 'lists', 'websites', 'webmaster', 'workshop', 'yourname', 'yourusername', 'yoursite', 'yourdomain', 'test', 'myname', 'myusername', 'mysite', 'mysql', 'seoray');
        $pages = get_pages();
        foreach ($pages as $page) {
            $restricted[] = $page->post_name;
        }
        if(!$valid || is_user_logged_in() && current_user_can('create_users') ) {
			return $valid;
		}
	  
        $username = strtolower($username);
        if ($valid && strpos( $username, ' ' ) !== false) {
			$valid = false;
		} 
        if ($valid && in_array( $username, $restricted )) {
			$valid = false;
		}
        if ($valid && strlen($username) < 5) {
			$valid = false;
		}
        if ($valid && substr_count($username, '.') >= 5) {
            $valid = false;
        }
        return $valid;
    }
    
    function is_valid_captcha_response($captcha) {
        
        $rc_secret_key = get_option('google_recaptcha_key');
        
        $captcha_postdata = http_build_query( 
            array( 
                'secret' => $rc_secret_key, 
                'response' => $captcha, 
                'remoteip' => $_SERVER['REMOTE_ADDR'] 
            ) 
        ); 
        
        $captcha_opts = array( 
            'http' => array( 
                'method' => 'POST', 
                'header' => 'Content-type: application/x-www-form-urlencoded', 
                'content' => $captcha_postdata 
            ) 
        ); 
    
        $captcha_context = stream_context_create($captcha_opts); 
        $captcha_response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $captcha_context), true); 
        
        wp_mail( 'chris@creativetools.co.uk', 'Recaptcha Response', print_r($captcha_response, true) );
    
        if($captcha_response['success'] && $captcha_response['score'] > 0.7){ 
            return true; 
        } else { 
            return false; 
        } 
    } 
 
    public static function verify_google_recaptcha() {
        
        $recaptcha_key = get_option('google_recaptcha_key');
        
        if ($recaptcha_key != '' && $recaptcha_key != false) {
        
            $recaptcha = $_POST['g-recaptcha-response']; 
        
            if (empty($recaptcha)) { 
                return false; 
            } elseif (!$this->is_valid_captcha_response($recaptcha)) { 
                return false;  
            }
        }
        
        return true;
    }

}
cqAuctionRegister::init();