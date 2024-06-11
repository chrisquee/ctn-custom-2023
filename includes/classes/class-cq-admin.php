<?php

class cqAdminEdits {
    
    public static function init() {
    	$self = new self();
		add_action('admin_head', array( $self , 'hide_menu_non_developer'));
        add_action( 'pre_ping', array( $self , 'disable_self_trackback') );
        add_action( 'admin_head', array( $self , 'suppress_vc_notice') );
  	}
    
    public function hide_menu_non_developer() {
        
        global $current_user;
        $user_id = get_current_user_id();
        
        if(is_admin() && ($user_id != '1' && $user_id != '2')){ 
        
            remove_menu_page( 'tools.php' );              
            remove_menu_page( 'options-general.php' );
            remove_menu_page( 'plugins.php' );
            remove_menu_page( 'vc-general' );
            remove_menu_page( 'vc-welcome' );
            remove_menu_page( 'wpseo_dashboard' );
            remove_menu_page( 'wpseo_workouts' );
            remove_menu_page( 'loginizer' );
            remove_menu_page( 'wpcf7' );
            remove_menu_page( 'meta-box' );
            remove_menu_page( 'lockdown-wp-admin' );
            remove_menu_page( 'onesignal-push' );
            remove_menu_page( 'litespeed' );
            
            remove_submenu_page( 'themes.php', 'themes.php' );
            remove_submenu_page( 'themes.php', 'theme-editor.php' );
            remove_submenu_page( 'themes.php', 'theme_options' );
        
        
        }
        
    }
    
    public function disable_self_trackback( &$links ) {
        foreach ( $links as $l => $link ) {
            if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
                unset($links[$l]);
            }
        }
    
    }

    public function suppress_vc_notice(){

        echo '<style>
                #vc_license-activation-notice, #meta-box-notification, .wpb-notice {display:none !important;}
             </style>';

    }
    
}
cqAdminEdits::init();