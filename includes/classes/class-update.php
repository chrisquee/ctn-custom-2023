<?php

class CqUpdate {
	
	private $plugin_name = 'cq-custom';
	
	public static function init() {
    	$self = new self();
        
        add_action('admin_init', array($self, 'updates_section'));
  	}
    
    public function updates_section() {  
        add_settings_section(  
            'cq_updates', // Section ID 
            'Update Options', // Section Title
            array($this, 'user_email_section_options_callback'), // Callback
            'general' // What Page?  This makes the section show up on the General Settings Page
        );
        
        add_settings_field( // Option 1
            'github_access_token', // Option ID
            'Github access token', // Label
            array($this, 'user_textbox_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed (General Settings)
            'cq_updates', // Name of our section
            array( // The $args
                'github_access_token' // Should match Option ID
            )  
        );
        
        register_setting('general','github_access_token', 'esc_attr');
        
    }
    
    public function user_email_section_options_callback() { // Section Callback
        echo '<p>Add the Github access token to enable plugin and theme updates.</p>';  
    }

    function user_textbox_callback($args) {  // Textbox Callback
        $option = get_option($args[0]);
        echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
    }
    
}
CqUpdate::init();