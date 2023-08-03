<?php

class cqCustomizer {
    
    public static function init() {
    	$self = new self();
		add_action( 'customize_register', array( $self, 'register_customizer_settings') );
  	}
    
    public function register_customizer_settings( $wp_customize ) {
        
        $wp_customize->add_setting(
            'site_strapline',
            array(
                'default' => '',
                'type' => 'option',
                'capability' => 'edit_theme_options'
            )
        );

        $wp_customize->add_control( new WP_Customize_Control(
            $wp_customize,
            'site_strapline',
            array(
                'label'      => __( 'Strapline', 'CQ_Custom' ),
                'description' => __( 'Add a strapline to be displayed in the site header', 'CQ_Custom' ),
                'settings'   => 'site_strapline',
                'priority'   => 20,
                'section'    => 'title_tagline',
                'type'       => 'text',
            )
        ) );
    }   
}
cqCustomizer::init();