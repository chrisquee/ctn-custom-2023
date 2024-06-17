<?php 

class cqOptions {
    
    public static function init() {
        
        $self = new self();
        
        add_action( 'admin_init', array($self, 'user_options_section'));
        add_action( 'wp_head', array($self, 'add_header_scripts'));
        add_action( 'wp_footer', array($self, 'add_footer_scripts'));

    }
    
    public function user_options_section() {
        
        add_settings_section(  
            'api_integrations', // Section ID 
            'API Integrations', // Section Title
            array($this, 'api_integrations_section_options_callback'), // Callback
            'general' // What Page?  This makes the section show up on the General Settings Page
        );
        
        add_settings_field( // Option 1
            'google_recaptcha_key', // Option ID
            'ReCaptcha API Key', // Label
            array($this, 'user_text_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed (General Settings)
            'api_integrations', // Name of our section
            array( // The $args
                'google_recaptcha_key' // Should match Option ID
            )  
        );
        
        /*add_settings_section(  
            'custom_js', // Section ID 
            'Custom Javascript', // Section Title
            array($this, 'user_options_section_options_callback'), // Callback
            'general' // What Page?  This makes the section show up on the General Settings Page
        );

        add_settings_field( // Option 1
            'custom_header_js', // Option ID
            'Custom Header JS', // Label
            array($this, 'user_textarea_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed (General Settings)
            'custom_js', // Name of our section
            array( // The $args
                'custom_header_js' // Should match Option ID
            )  
        );
        
        add_settings_field( // Option 1
            'custom_footer_js', // Option ID
            'Custom Footer JS', // Label
            array($this, 'user_textarea_callback'), // !important - This is where the args go!
            'general', // Page it will be displayed (General Settings)
            'custom_js', // Name of our section
            array( // The $args
                'custom_footer_js' // Should match Option ID
            )  
        );*/
        
        register_setting('general','google_recaptcha_key', 'esc_attr');
        /*register_setting('general','custom_header_js', 'esc_attr');
        register_setting('general','custom_footer_js', 'esc_attr');*/
        
    }
    
    public function user_options_section_options_callback() { // Section Callback
        echo '<p>Add javascript snippets to the header or footer.</p>';  
    }
    
    public function user_textarea_callback($args) {
        $option = get_option($args[0]);
        echo '<textarea id="'. $args[0] .'" name="'. $args[0] .'" rows="10" style="width: 100%; max-width: 100%;">' . $option . '</textarea>';
    }
    
    public function user_text_callback($args) {
        $option = get_option($args[0]);
        echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '"/>';
    }
    
    public function add_header_scripts() {
        $js = get_option('custom_header_js');
        
        if ($js != false) {
            echo html_entity_decode($js, ENT_QUOTES | ENT_XML1, 'UTF-8');
        }
        
        return;
    }
    
    public function add_footer_scripts() {
        $js = get_option('custom_footer_js');
        
        if ($js != false) {
            echo html_entity_decode($js, ENT_QUOTES | ENT_XML1, 'UTF-8');
        }
        
        return;
    }
    
    public function api_integrations_section_options_callback() { // Section Callback
        echo '<p>Add keys for any API integrations.</p>';  
    }
    
}
cqOptions::init();