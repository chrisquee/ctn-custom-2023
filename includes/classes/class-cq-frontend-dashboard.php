<?php

class cqDashboard {
	
  private $plugin_name = 'cq-custom';
  public $cq_endpoints = array();

  public static function init() {
    $self = new self();
    add_action( 'init', array( $self, 'cq_declare_endpoints' ) );
    add_action( 'wp_loaded', array( $self, 'cq_dashboard_endpoints' ) );
    add_action( 'init', array( $self, 'cq_notices' ) );
	//add_action( 'template_redirect', array( $self, 'cq_redirect_dashboard' ) );
	add_filter( 'template_include', array( $self, 'cq_redirect_dashboard' ) );
    add_filter('pre_get_document_title', array( $self, 'dashboard_title'), 50);
      
 }
	
  public function __construct() {
	  $this->cq_declare_endpoints();
	  add_action( 'init', array( $this, 'cq_dashboard_endpoints' ) );
	  //add_action( 'template_redirect', array( $this, 'cq_redirect_dashboard' ) );
  }
	
  public function cq_declare_endpoints() {
	  $this->cq_endpoints = array(
		  array(
              'permissions' => 'subscriber',
			  'url' => 'my-details',
			  'name' => 'My Details',
			  'icon' => 'fa-angle-right'
		  ),
         /* array(
			  'url' => 'my-subcriptions',
			  'name' => 'My Subscriptions',
			  'icon' => 'fa-angle-right'
		  ),
		  array(
			  'url' => 'my-messages',
			  'name' => 'Messages',
			  'icon' => 'fa-angle-right'
		  ),*/
          array(
			  'url' => 'current-jobs',
			  'name' => 'Jobs',
			  'icon' => 'fa-angle-down',
              'permissions' => 'subscriber',
              'children' => array(
			  		array(
			  			'url' => 'add-new-job',
			  			'name' => 'Add a job',
			  			'icon' => 'fa-angle-right'),
				  	array(
			  			'url' => 'current-jobs',
			  			'name' => 'Current jobs',
			  			'icon' => 'fa-angle-right'),
                  )
		  	)
	  );
	  
	  //if (current_user_can('trade_seller')) {
		  
		  /*$this->cq_endpoints[] = array(
			  'url' => 'current-listings',
			  'name' => 'Directory Listings',
			  'icon' => 'fa-angle-down',
			  'permissions' => 'directory_admin',
			  'children' => array(
                    array(
			  			'url' => 'current-listings',
			  			'name' => 'Current listings',
			  			'icon' => 'fa-angle-right'),
			  		array(
			  			'url' => 'add-new-listing',
			  			'name' => 'Add a business',
			  			'icon' => 'fa-angle-right'),
                  )
		  	);*/
      
            $this->cq_endpoints[] = array(
			     'url' => 'verify-account',
			     'name' => 'Verify your account',
			     'icon' => 'fa-angle-right',
                 'add_menu' => false,
            );
            
            /*$this->cq_endpoints[] = array(
			     'url' => 'claim-business',
			     'name' => 'Claim a business',
			     'icon' => 'fa-angle-right',
                 'add_menu' => false,
            );*/
      
            /*$this->cq_endpoints[] = array(
			     'url' => 'business-edit',
			     'name' => 'Update Business Listing',
			     'icon' => 'fa-angle-right',
                 'add_menu' => false,
            );*/
      
            $this->cq_endpoints[] = array(
			     'url' => 'job-edit',
			     'name' => 'Update job Listing',
			     'icon' => 'fa-angle-right',
                 'add_menu' => false,
            );
      
            /*$this->cq_endpoints[] = array(
			     'url' => 'business-new',
			     'name' => 'Add Business Listing',
			     'icon' => 'fa-angle-right',
                 'add_menu' => false,
            );*/
	  
	  		/*$this->cq_endpoints[] = array(
			  'url' => 'order-detail',
			  'name' => 'Order Details',
			  'icon' => 'fa-angle-right',
			  'permissions' => 'trade_seller',
			  'add_menu' => false,
		  	);  
      
            $this->cq_endpoints[] = array(
			  'url' => 'order-info',
			  'name' => 'Order Information',
			  'icon' => 'fa-angle-right',
			  'add_menu' => false,
		  	);  */
		  
	  //}
      
      $this->cq_endpoints = apply_filters('dashboard_endpoints', $this->cq_endpoints);
      
      //print_r($this->cq_endpoints);
	  
	  return;
  }
	
	
  public function cq_dashboard_endpoints() {
	  
	  if (empty($this->cq_endpoints)) {
		   $this->cq_declare_endpoints();
	  }
	  //print_r($this->cq_endpoints);
	  foreach($this->cq_endpoints as $key => $value) {
		  
    	add_rewrite_endpoint( $value['url'], EP_PAGES );
		
		if (isset($value['children']) && is_array($value['children'])) {
			foreach($value['children'] as $item => $url) {
				add_rewrite_endpoint( $url['url'], EP_PAGES );
			}
		}
		  
  	  }
	  
  }
	
  public function cq_redirect_dashboard($template) {
      global $wp_query;

      if ( $wp_query->query_vars['pagename'] != 'my-account' || !is_user_logged_in()) {
             return $template;
      }

      $endpoint = '';

      $dashboard_template = current_user_can('directory_admin') ? 'dashboard-directory-admin.php' : 'dashboard-directory-admin.php';
      
      $dashboard_template = apply_filters('dashboard_template', $dashboard_template);

      foreach ( $wp_query->query_vars as $key => $value ) {
         
         if ( $this->in_array_r( $key, $this->cq_endpoints ) ) {
             $endpoint = $key;
             $template = cq_get_template( $dashboard_template, array('dashboard_content' => $key, 'endpoints' => $this->cq_endpoints), $endpoint );
             break;
         }
       }

       if ($endpoint == '') {
            $template = cq_get_template( $dashboard_template, array('dashboard_content' => 'my-details', 'endpoints' => $this->cq_endpoints), $endpoint );
       }
      
       return apply_filters('cq_redirect_template', $template, $dashboard_template, $endpoint, $this->cq_endpoints);
	  
  }
			
  public function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
  }
    
  public function dashboard_title($title) {
      
      global $wp_query;
      
      if ( $wp_query->query_vars['pagename'] != 'my-account' || !is_user_logged_in()) {
        return $title;
      }
      
      foreach ( $wp_query->query_vars as $key => $value ) {
         
         if ( $this->in_array_r( $key, $this->cq_endpoints ) ) {
             foreach($this->cq_endpoints as $endpoint) {
                 
                 if ($endpoint['url'] == $key) {
                     
                     $title = str_ireplace('My Account', $endpoint['name'], $title);
                     break;
                 }
                 
                 if (isset($endpoint['children']) && is_array($endpoint['children'])) {
                     foreach ($endpoint['children'] as $child) {
                         if ($child['url'] == $key) {
                     
                             $title = str_ireplace('My Account', $child['name'], $title);
                             break 2;
                         }
                     }
                 }
                 
             }
         }
        
       }
      
      return $title;
      
  }
    
  public function cq_notices() {
      
      global $notices;
      
      $notices = new CqUserNotices();
      
  }
	
}
//$cq_dashboard_vars = new cqDashboard();
cqDashboard::init();