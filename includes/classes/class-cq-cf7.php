<?php
class cqCf7 {
    
    public static function init() {
    	$self = new self();
        add_action( 'wp_ajax_account_verify', array($self, 'ajax_account_verify') );
        add_action( 'wp_ajax_account_confirm', array($self, 'ajax_account_confirm') );
        add_action('cq_before_profile_fields', array($self, 'output_verification_link'), 10, 2);
  	}
    
    public function dont_save_fields($form_data){ 
        
        unset($form_data['cf7mls_step-6']); 
        unset($form_data['cf7mls_step-5']);
        unset($form_data['cf7mls_step-4']); 
        unset($form_data['cf7mls_step-3']);
        unset($form_data['cf7mls_step-2']); 
        unset($form_data['cf7mls_step-1']);
        
        return $form_data; 
    }
    
}