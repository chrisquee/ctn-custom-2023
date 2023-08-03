<?php

class cqWpAPI {
    
    public static function init() {
        $self = new self();
        add_filter( 'jwt_auth_whitelist', array( $self, 'cq_jwt_whitelist'));
        add_filter( 'jwt_auth_default_whitelist', array( $self, 'cq_modify_default_jwt_whitelist') );
    }
                   
    public function cq_jwt_whitelist($endpoints) {
        
        $allowed_endpoints = array(
				'/jwt-auth/v1/token/validate',
				'/jwt-auth/v1/token',
				'/oauth/authorize',
				'/oauth/token',
				'/oauth/me',
                '/contact-form-7/v1/contact-forms/\d{0,15}/feedback',
                '/contact-form-7/v1/contact-forms/\d{0,15}/refill',
                '/litespeed/v1/token'
			);
        
        return array_unique( array_merge( $endpoints, $allowed_endpoints ) );
        
    }
    
    public function cq_modify_default_jwt_whitelist( $default_whitelist ) {
        
        unset($default_whitelist['/wp-json/wp/v2/*'] );
        
        return $default_whitelist;
        
    }
    
}
cqWpAPI::init();