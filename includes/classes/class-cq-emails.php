<?php
class CqEmails {
	
	private $plugin_name = 'cq-custom';
	
	public static function init() {
    	$self = new self();
		add_action( 'send_company_verification', array($self, 'send_company_verification') );
        add_action( 'send_user_verification', array($self, 'send_account_verification') );
        add_filter( 'wp_new_user_notification_email', array($self, 'custom_wp_new_user_notification_email'), 10, 3 );
        add_filter( 'wp_mail_from', array($self, 'cq_sender_email') );
        add_filter( 'wp_mail_from_name', array($self, 'cq_sender_name') );
        add_action('admin_init', array($self, 'user_email_section')); 
        add_action( 'phpmailer_init', array( $self, 'return_path_fix' ) );  
        //add_action( 'wp_ajax_business_verify', array($self, 'ajax_business_verify') );
        //add_action( 'phpmailer_init', array( $self, 'mailer_config' ) );
  	}
    
    public function mailer_config($phpmailer){
        $phpmailer->IsSMTP();
        $phpmailer->Host = 'localhost';
        
        return;
    }
    
    function return_path_fix( $phpmailer ) {
        $email_from_email = get_option('user_email_from_email');
        $smtp_server = get_option('user_smtp_server');
        $smtp_username = get_option('user_smtp_username');
        $smtp_pass = get_option('user_smtp_pass');
        $smtp_port = get_option('user_smtp_port');
        
        if ($smtp_username) {
            $phpmailer->isSMTP();     
            $phpmailer->Host = $smtp_server;  
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = $smtp_port;
            $phpmailer->Username = $smtp_username;
            $phpmailer->Password = $smtp_pass;
            $phpmailer->SMTPSecure = 'ssl';
            $phpmailer->From = $email_from_email;
            $phpmailer->FromName = get_bloginfo('name');
            $phpmailer->Sender = $email_from_email;
            $phpmailer->SMTPDebug = 0;
        }
        return;
    }
    
    function cq_sender_email( $original_email_address ) {
        return 'no-reply@cruisetradenews.com';
    }
 
    function cq_sender_name( $original_email_from ) {
        return get_bloginfo('name');
    }
    
    public function ajax_business_verify() {
        
        global $company;
        
        check_ajax_referer( 'verify_nonce', 'security' );
        
        if (is_user_logged_in()) {
            
            $company_id = sanitize_text_field($_REQUEST['company_id']);
            
            do_action('get_company_data', $company_id);
            
            $this->send_company_verification($company);
            
            echo json_encode(array('status' => 'success'));
            
        }
        
        die;
        
    }
    
    public function send_company_verification($company) {
		
		if ($company) {
			
            $user = array();
			$email_from = get_option('user_email_from_name');
            
            $email_from_email = get_option('user_email_from_email');
                
			$user['company_name'] = $company->meta['name'];
			$user['company_email'] = $company->meta['email'];
            $user['verification_code'] = $this->generate_verification_code($company->company_id);
			
			ob_start();
			cq_get_template( 'email/business-verification.php', $user );
			$output = ob_get_contents();
			ob_end_clean();
			
			$to = $company->meta['email'];
            $subject = 'Directory verification for ' . esc_html($company->meta['name']);
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $headers[] = "MIME-Version: 1.0\n";
			$headers[] = 'From: ' . $email_from . ' <' . $email_from_email . '>';
            $headers[] = 'Return-Path: <' . $email_from_email . '>';

            wp_mail( $to, $subject, $output, $headers );
			
		}
		
	}
    
    public function send_account_verification($user_info) {
		
		if ($user_info) {
			
            $user = array();
			$email_from = get_option('user_email_from_name');
            
            $url = site_url();
            $parse = parse_url($url);
            $host = $parse['host'];
            $email_from_email = get_option('user_email_from_email');
                
			$user['user_name'] = $user_info->display_name;;
			$user['user_email'] = $user_info->user_email;
            $user['verification_code'] = $this->generate_user_verification_code($user_info->ID);
			
			ob_start();
			cq_get_template( 'email/user-verification.php', $user );
			$output = ob_get_contents();
			ob_end_clean();
			
			$to = $user_info->user_email;
            $subject = 'User account verification from ' . get_bloginfo('name');
            $headers = array('From: ' . $email_from . ' <' . $email_from_email . '>', 'Content-Type: text/html; charset=UTF-8');
            $headers[] = 'Return-Path: <' . $email_from_email . '>';

            wp_mail( $to, $subject, $output, $headers );
			
		}
		
	}
    
    function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
		
		$email_options = get_option( $this->plugin_name );
		$params = array();
		//$params['email_header_image'] = $email_options['email_header_image'];
		//$params['auction_admin_address'] = $email_options['auction_admin_address'];

        $user_login = stripslashes( $user->user_login );
        $user_email = stripslashes( $user->user_email );
        
		
        $message  = __( 'Hi there,' ) . "<br><br>";
        $message .= sprintf( __( "Welcome to %s! Here's how to log in:" ), get_option('blogname') ) . "<br><br>";
        $message .= "You can visit " . get_the_permalink(get_page_by_path('my-account')) . " or click the button below.<br><br>";
        $message .= sprintf( __('<b>Username:</b> %s'), $user_login ) . "<br><br>";
        $message .= sprintf( __('<b>Email:</b> %s'), $user_email ) . "<br><br>";
        $message .= __( '<b>Password:</b> The one you entered in the registration form. (For security reasons, we save passwords encrypted)' ) . "<br><br>";
        
        if (user_can( $user->ID, 'training_admin' )) {
            $message .= '<i>If your account was created by us, please use the password reset facility at the bottom of this email to choose a new password.</i>';
        }
        
        //$message .= sprintf( __('<br><br>If you have any problems, please contact us at %s.'), $params['auction_admin_address'] ) . "<br><br>";
        
        /*if (user_can( $user->ID, 'trade_seller' )) {
            
            $message .= '<p align="center"><a href="https://www.youtube.com/playlist?list=PLxM2df-Z5IaH77-0gm9mhquLrPMf76Vh6" target="_blank" style="color: #51596b;"><b>Dealer How To\'s - Click to watch now</b></a></p>';
            
            $message .= '<p align="center"><b>WATCH NOW</b> <a href="https://www.youtube.com/watch?v=yEDU0w24HnM" target="_blank">How to: Uploading a watch.<br><img src="https://www.chasingchrono.com/resources/uploads/2021/10/cc-youtube-071021.jpg" width="500" height="281" style="width: 500px; height:281px;"></a></p>';
        }*/
		
		$params['message'] = $message;
		
		ob_start();
        cq_get_template( 'email/new_user_notification.php', $params );
        $output_admin = ob_get_contents();
        ob_end_clean();

        $wp_new_user_notification_email['subject'] = sprintf( 'Welcome to %s, here are your credentials.', $blogname );
        $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');
        $wp_new_user_notification_email['message'] = $output_admin;

        return $wp_new_user_notification_email;
    }
    
    public function generate_verification_code($company_id) {
        
        global $wpdb;
        
        $code = random_int(100000, 999999);
        
        $stamp = strtotime('2011-11-17 05:05 + 16 minute');
        
        $result = $wpdb->update("{$wpdb->prefix}dir_company",
                                array('verification_code' => $code,
                                      'verification_expiry' => $stamp),
                                array('id' => $company_id),
                                array('%s', 
                                      '%s'),
                                array('%d')
                                );
        
        return $code;

        
    }
    
    public function generate_user_verification_code($user_id) {
        
        $code = random_int(100000, 999999);
        
        $stamp = strtotime('+ 16 minute');
        
        $updated = update_user_meta( $user_id, 'account_verify_code', $code );
        $expires = update_user_meta( $user_id, 'account_verify_expires', $stamp );
        
        return $code;

        
    }
    
    public function user_email_section() {  
        add_settings_section(  
            'user_emails', // Section ID 
            'User Email Settings', // Section Title
            array($this, 'user_email_section_options_callback'), // Callback
            'general' // What Page?  This makes the section show up on the General Settings Page
        );

        add_settings_field( // Option 1
            'user_email_from_name', // Option ID
            'From Name', // Label
            array($this, 'user_email_textbox_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed (General Settings)
            'user_emails', // Name of our section
            array( // The $args
                'user_email_from_name' // Should match Option ID
            )  
        ); 

        add_settings_field( // Option 2
            'user_email_from_email', // Option ID
            'From Email', // Label
            array($this, 'user_email_textbox_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed
            'user_emails', // Name of our section (General Settings)
            array( // The $args
                'user_email_from_email' // Should match Option ID
            )  
        );
        
        add_settings_field( // Option 2
            'user_smtp_username', // Option ID
            'SMTP User Name', // Label
            array($this, 'user_email_textbox_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed
            'user_emails', // Name of our section (General Settings)
            array( // The $args
                'user_smtp_username' // Should match Option ID
            )  
        );
        
        add_settings_field( // Option 2
            'user_smtp_pass', // Option ID
            'SMTP Password', // Label
            array($this, 'user_email_textbox_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed
            'user_emails', // Name of our section (General Settings)
            array( // The $args
                'user_smtp_pass' // Should match Option ID
            )  
        );
        
        add_settings_field( // Option 2
            'user_smtp_server', // Option ID
            'SMTP Server', // Label
            array($this, 'user_email_textbox_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed
            'user_emails', // Name of our section (General Settings)
            array( // The $args
                'user_smtp_server' // Should match Option ID
            )  
        );
        
        add_settings_field( // Option 2
            'user_smtp_port', // Option ID
            'SMTP Port', // Label
            array($this, 'user_email_textbox_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed
            'user_emails', // Name of our section (General Settings)
            array( // The $args
                'user_smtp_port' // Should match Option ID
            )  
        );

        register_setting('general','user_email_from_name', 'esc_attr');
        register_setting('general','user_email_from_email', 'esc_attr');
        register_setting('general','user_smtp_username', 'esc_attr');
        register_setting('general','user_smtp_pass', 'esc_attr');
        register_setting('general','user_smtp_server', 'esc_attr');
        register_setting('general','user_smtp_port', 'esc_attr');
    }

    public function user_email_section_options_callback() { // Section Callback
        echo '<p>Customize the name from name and email address that any user emails come from and set up SMTP.</p>';  
    }

    function user_email_textbox_callback($args) {  // Textbox Callback
        $option = get_option($args[0]);
        echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
    }
    
}
CqEmails::init();