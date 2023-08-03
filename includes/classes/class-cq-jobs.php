<?php

class cqjobsObject {
    
    public $job_id = '';
    public $job_title = '';
    public $job_url = '';
    public $job_email = '';
    public $job_full_description = '';
    public $job_description = '';
    public $job_location = '';
    public $job_company = '';
    public $application_instructions = '';
    public $job_type_id = '';
    public $job_scope = '';
    public $job_type_name = '';
    public $job_logo = '';
    public $job_page_link = '';
    
    public function __construct($job_id = null){
        
        if (is_numeric($job_id)) {
			$this->cq_setup_job_data($job_id);
		} else {
			$this->cq_setup_job_data();
		}
  
    }
    
    public function cq_setup_job_data($job_id = null) {
        
        global $post;
        
        if (is_int($job_id)) {
			$post = get_post( $job_id );
            setup_postdata( $post );
		}
        
        if (get_post_type( $post->ID ) != 'jobs') {
            return;
        }
	  
	   if (is_numeric($post->ID) && get_post_type( $post->ID ) == 'jobs') { 
	  	  
		  $user_id = '';
	  	  if (is_user_logged_in()) {
			$user_id = get_current_user_id();
		  }
          
          $job_meta = get_post_meta( get_the_ID() );
          $this->job_id = $post->ID;
          $this->job_company = isset($job_meta['cq_job_company_name'][0]) && $job_meta['cq_job_company_name'][0] != '' ? $job_meta['cq_job_company_name'][0] : '';
          $this->job_title = get_the_title();
          $this->job_description = isset($job_meta['cq_job_brief_description'][0]) && $job_meta['cq_job_brief_description'][0] != '' ? $job_meta['cq_job_brief_description'][0] : '';
          $this->job_email = isset($job_meta['cq_job_email'][0]) && $job_meta['cq_job_email'][0] != '' ? $job_meta['cq_job_email'][0] : '';
          $this->job_full_description = get_the_content();
          $this->job_url = isset($job_meta['cq_job_link'][0]) && $job_meta['cq_job_link'][0] != '' ? $job_meta['cq_job_link'][0] : '';
          $this->job_scope = isset($job_meta['cq_job_scope'][0]) && $job_meta['cq_job_scope'][0] != '' ? $job_meta['cq_job_scope'][0] : '';
          $this->application_instructions = isset($job_meta['cq_job_apply_instruction'][0]) && $job_meta['cq_job_apply_instruction'][0] != '' ? $job_meta['cq_job_apply_instruction'][0] : '';
          $this->job_location = isset($job_meta['cq_job_location'][0]) && $job_meta['cq_job_location'][0] != '' ? $job_meta['cq_job_location'][0] : '';
          $this->job_type_id = isset($job_meta['cq_job_type'][0]) && $job_meta['cq_job_type'][0] != '' ? $job_meta['cq_job_type'][0] : '';
          $this->job_logo = isset($job_meta['cq_job_business_logo'][0]) && $job_meta['cq_job_business_logo'][0] != '' ? $job_meta['cq_job_business_logo'][0] : '';
          $this->job_type_name = $this->get_job_type_name($this->job_type_id);
          $this->job_page_link = get_permalink($post->ID);
           

       }
        
    }
    
    public function get_job_type_name($type_id) {
        
        global $wpdb;
        
        $result = $wpdb->get_var($wpdb->prepare("SELECT type FROM {$wpdb->prefix}dir_bpa_job_functions WHERE id = %d", $type_id));
        
        if ($result != '') {
            return $result;
        } else {
            return '';
        }
        
    }
    
    public function get_job_type_options($default = '') {
        
        global $wpdb;
        
        $html = '<option value="">Select</option>';
        $selected = '';
        
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dir_bpa_job_functions", ARRAY_A);
        
        foreach ($results as $result) {
            
           $selected = $default == $result['id'] ? 'selected' : '';
           $html .= '<option value="' . $result['id'] . '" ' . $selected . '>' . esc_html($result['type']) . '</option>';
            
        }
        
        return $html;
        
    }
    
}
