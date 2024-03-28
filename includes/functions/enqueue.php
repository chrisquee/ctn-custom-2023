<?php

function cq_add_stylesheet() {
	
	global $wp, $post;
	
    wp_enqueue_style( 'cq-custom-css', plugins_url( '/assets/css/main.min.css', dirname(__FILE__, 2) ), array(), time() );
	wp_enqueue_script( 'cq-custom-js', plugins_url( '/assets/js/main.min.js', dirname(__FILE__, 2) ), array(), time(), true );
	
	$js_params = array(
      		'ajaxurl' => admin_url( 'admin-ajax.php' ),
      		'redirecturl' => get_permalink( get_page_by_path( 'my-account' ) ),
      		'loadingmessage' => __( 'Logging in, please wait...' ),
			'sendingmessage' => __( 'Sending your message, please wait...' ),
		    'currentpage' => home_url( $wp->request ),
            'ctn_nonce' => wp_create_nonce( 'cq-nonce' )
    	);
    
    if ($post) {
        $js_params['post_id'] = $post->ID;
    }
    
    $js_params = apply_filters('cq-localized-params', $js_params);
    
    if (is_user_logged_in()) {
	 	$js_params['user_id'] =  get_current_user_id();
	}
	
	wp_localize_script( 'cq-custom-js', 'ajax_login_object', $js_params );
	
	/*if ( is_page( 'my-account' ) ) {
		if (current_user_can('directory_admin')) {
            wp_enqueue_script("cq_directory_js", plugins_url("cq-aviation-directory/assets/admin/cq-admin-js.js"), array( 'jquery' ), '0.1');
            wp_enqueue_script( 'jquery-ui-autocomplete' );
		}
	}*/
}
add_action('wp_enqueue_scripts', 'cq_add_stylesheet');
