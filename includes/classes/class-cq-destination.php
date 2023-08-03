<?php

class cqDestinationsObject {
    
    public $destination_id = '';
    public $destination_meta = array();
    public $destination_title = '';
    public $destination_url = '';
    public $destination_about = '';
    public $destination_intro = '';
    public $destination_page_link = '';
    public $destination_cruise_lines = array();
    public $destination_cruise_types = array();
    
    public function __construct($destination_id = null){
        
        if (is_numeric($destination_id)) {
			$this->cq_setup_destination_data($destination_id);
		} else {
			$this->cq_setup_destination_data();
		}
  
    }
    
    public function cq_setup_destination_data($destination_id = null) {
        
        global $post;
        
        if (is_int($destination_id)) {
			$post = get_post( $destination_id );
            setup_postdata( $post );
		}
        
        if (get_post_type( $post->ID ) != 'destinations') {
            return;
        }
	  
	   if (is_numeric($post->ID) && get_post_type( $post->ID ) == 'destinations') { 
	  	  
		  $user_id = '';
	  	  if (is_user_logged_in()) {
			$user_id = get_current_user_id();
		  }
          
          $destination_meta = get_post_meta( get_the_ID() );
          $this->destination_meta = $destination_meta;
          $this->destination_id = $post->ID;
          $this->destination_title = get_the_title();
          $this->destination_intro = isset($destination_meta['destination_intro'][0]) && $destination_meta['destination_intro'][0] != '' ? $destination_meta['destination_intro'][0] : '';
          
          $this->destination_about = isset($destination_meta['destination_about'][0]) && $destination_meta['destination_about'][0] != '' ? $destination_meta['destination_about'][0] : '';
          $this->destination_page_link = get_permalink($post->ID);
          $this->destination_cruise_lines = get_post_meta( $post->ID, 'cruise-lines' );
           

       }
        
    }
    
}
