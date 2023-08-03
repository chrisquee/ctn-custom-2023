<?php

class cqBusinessUser {
    
    public static function init() {
    	$self = new self();
        add_action( 'wp_ajax_business_verify', array($self, 'ajax_business_verify') );
        add_action( 'wp_ajax_business_confirm', array($self, 'ajax_business_confirm') );
        add_action( 'get_current_business_listings', array($self, 'get_current_business_listings') );
  	}
    
    public function ajax_business_verify() {
        
        global $company;
        
        check_ajax_referer( 'verify_nonce', 'security' );
        
        if (is_user_logged_in()) {
            
            $company_id = sanitize_text_field($_REQUEST['company_id']);
            
            do_action('get_company_data', $company_id);
            
            //$this->send_company_verification($company);
            do_action('send_company_verification', $company);
            
            echo json_encode(array('status' => 'success'));
            
        }
        
        die;
        
    }
    
    public function ajax_business_confirm() {
        
        global $company;
        
        check_ajax_referer( 'business_confirm_nonce', 'security' );
        
        if (is_user_logged_in()) {
            
            $user_id = get_current_user_id();
            $code = sanitize_text_field($_REQUEST['verification_code']);
            $company_id = sanitize_text_field($_REQUEST['company_id']);
            
            if ($this->check_verification_code($code, $company_id)) {
                
                $result = $this->link_user_to_business($user_id, $company_id);
                
            } else {
                $result = array('status' => 'failed',
                                'message' => 'Incorrect verification code');
            }
            
            echo json_encode($result);
            
        }
        
        die;
        
    }
    
    public function check_verification_code($code, $company_id) {
        
        global $wpdb;
        
        $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) AS matches FROM {$wpdb->prefix}dir_company WHERE verification_code = %d AND id = %d", $code, $company_id));
        
        if ($result == 1) {
            return true;
        } else {
            return false;
        }
        
    }
    
    public function link_user_to_business($user_id, $company_id) {
        
        global $wpdb;
        
        $return_array = array();
        
        $result = $wpdb->get_var($wpdb->prepare("SELECT user_id_link FROM {$wpdb->prefix}dir_company WHERE id = %d", $company_id));
        
        if (is_numeric($result)) {
            
            $return_array['status'] = 'failed';
            $return_array['message'] = 'Account already linked'; 
            
        } else {
            
            $result = $wpdb->update("{$wpdb->prefix}dir_company",
                                array('user_id_link' => $user_id),
                                array('id' => $company_id),
                                array('%d'),
                                array('%d')
                                );
        
            if ($result) {
                
                $return_array['status'] = 'success';
                $return_array['message'] = 'Account now linked';
                
                $u = new WP_User( $user_id );

                // Remove role
                $u->remove_role( 'subscriber' );

                // Add role
                $u->add_role( 'directory_admin' );
                
            }
        }
        
        return $return_array;
        
    }
    
    public function get_current_business_listings() {
        
        global $wpdb, $company;
        
        $html = '';
        
         if (is_user_logged_in()) {
            
            $user_id = get_current_user_id();
             
            $results = $this->get_user_businesses($user_id);
             
            if (!empty($results)) {
                
                $html = '<table class="table business-listings">
                            <thead>
                                <th>ID</th>
                                <th>Business Name</th>
                                <th>Country</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>';
                
                foreach($results as $result) {
                    
                    do_action('get_company_data', $result['id']);
                    
                    $html .= '<tr>
                                <td>' . $company->company_id . '</td>
                                <td>' . $company->meta['name'] . '</td>
                                <td>' . $company->meta['country_name'] . '</td>
                                <td><a href="' . add_query_arg(array('company_id' => $company->company_id), site_url('/my-account/business-edit/')) . '" class="button button-small button-blue">edit</a></td>
                             </tr>';
                    
                }
                            
                $html .= '</tbody>
                        </table>';
            } else {
                $html = '<div class="result_empty col_6"><h3> No Results</h3></div>';
            }
             
            echo $html;
             
         }
        
        return;
        
    }
    
    public function get_user_businesses($user_id) {
        
        global $wpdb;
        
        $results = $wpdb->get_results($wpdb->prepare("SELECT id FROM {$wpdb->prefix}dir_company WHERE user_id_link = %d", $user_id), ARRAY_A);
        
        return $results;
    }
}
cqBusinessUser::init();