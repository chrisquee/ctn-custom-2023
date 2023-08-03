<?php
class cqAccountVerify {
    
    public static function init() {
    	$self = new self();
        add_action( 'wp_ajax_account_verify', array($self, 'ajax_account_verify') );
        add_action( 'wp_ajax_account_confirm', array($self, 'ajax_account_confirm') );
        add_action('cq_before_profile_fields', array($self, 'output_verification_link'), 10, 2);
  	}
    
    public function ajax_account_verify() {
        
        global $company;
        
        check_ajax_referer( 'verify_nonce', 'security' );
        
        if (is_user_logged_in()) {
            
            $user_id = get_current_user_id();
            
            $user_info = get_userdata($user_id);
            
            do_action('send_user_verification', $user_info);
            
            echo json_encode(array('status' => 'success'));
            
        }
        
        die;
        
    }
    
    public function ajax_account_confirm() {
        
        global $company;
        
        check_ajax_referer( 'user_confirm_nonce', 'security' );
        
        if (is_user_logged_in()) {
            
            $user_id = get_current_user_id();
            $code = sanitize_text_field($_REQUEST['verification_code']);
            
            $check = $this->check_user_verification_code($code, $user_id);
            
            if ($check['status'] == 'success') {
                
                $upgrade = $this->upgrade_user_account($user_id);
                
                $result = $check;
                
            } else {
                $result = $check;
            }
            
            echo json_encode($result);
            
        }
        
        die;
        
    }
    
    public function check_user_verification_code($code, $user_id) {
        
        $stored_code = get_user_meta($user_id, 'account_verify_code', true);
        $expiry = get_user_meta($user_id, 'account_verify_expires', true);
        $now = strtotime("now");
        $return_array = array();
        
        if ($now > $expiry) {
            $return_array = array('status' => 'failed',
                                  'message' => 'Verification code expired');
            
            return $return_array;
            
        } else if ($now <= $expiry && $code != $stored_code) {
            $return_array = array('status' => 'failed',
                                  'message' => 'Incorrect verification code');
            return $return_array;
            
        } else if ($now <= $expiry && $code == $stored_code) {
            $return_array = array('status' => 'success',
                                  'message' => 'Account verified',
                                  'redirect' => site_url('/my-account/my-details/'));
            
            $updated = update_user_meta( $user_id, 'account_verified', 1 );
            
            return $return_array;
        }
        
    }
    
    public function upgrade_user_account($user_id) {
                
        $u = new WP_User( $user_id );

        // Remove role
        $u->remove_role( 'subscriber' );

        // Add role
        $u->add_role( 'directory_admin' );
        
        return;
        
    }
    
    public function output_verification_link($details, $user_id) {
        
        if ( !current_user_can( 'directory_admin' ) ) {
            
            echo '<p class="account-unverified">Account status: Unverified - <a href="' . site_url('/my-account/verify-account') . '">click here to verify your account</a></p>';
        
        }
        
        return;
    }
}
cqAccountVerify::init();