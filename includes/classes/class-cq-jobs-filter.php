<?php
class cqJobsFilter {
	
	public static function init() {
		
    	$self = new self();
    	add_action( 'cq_before_list', array( $self, 'filter_in_action' ) );
		add_action( 'pre_get_posts' ,  array( $self, 'cq_filter_function' ) );
        add_shortcode('cq_jobs_filter', array($self, 'render_filter'));
  	}
	
	public function render_filter($attributes = array()) {
		
		global $wp;
        
        $extra_class = '';
        
        if (!empty($attributes)) {
            $cq_jobs_filter_atts = shortcode_atts(array(
      		'el_class' => '',
			), $attributes);
            
            $extra_class = esc_attr($cq_jobs_filter_atts['el_class']);
        }
        
        $post_type = get_post_type();
		
		$current_url = home_url( add_query_arg( array(), $wp->request ) );
        
		filter_input_array(INPUT_POST, $this->filter_request());
        
        $default_array = $this->set_defaults($_POST);
		
		$filter_html = '<div class="container-fluid jobs-filter no-padding ' . $extra_class . '">
							<div class="row-fluid clearfix filter-wrapper">
		<form action="' . esc_url(site_url('/jobs/')) . '" method="POST" id="filter" class="archive-row">';
	
	    $filter_html .= '<div class="col_2">
                        <div class="input-group">
                            <input type="text" id="job_keywords" name="job_keywords" placeholder="Type a keyword" value="' . $default_array['job_keywords'] . '">
                        </div>
                    </div>
                    <div class="col_2">
						<div class="input-group">
							<input type="text" name="job_location" placeholder="Location" value="' . $default_array['job_location'] . '" />
						</div>
					</div>
					<div class="col_2">
						<div class="input-group">
        					<select name="job_type">
								' . $this->set_select_defaults($this->get_job_functions(), $default_array['job_type']) . '
							</select>
						</div>
					</div>
					<div class="col_2"><button class="button button-category button-outline">Apply filter</button></div>
					<input type="hidden" name="action" value="filter_jobs">                 
				</form>
                </div>
                </div>';
			
		return $filter_html;
	}
    
    private function filter_request() {
        
        $filters = array (
            "job_type" => FILTER_VALIDATE_INT,
            "job_keywords" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "job_location" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        );
        
        return $filters;
        
    }
    
    private function set_defaults($post_array) {
        
        $default_array = array();
        
        $default_array['job_keywords'] = isset($post_array['job_keywords']) ? $post_array['job_keywords'] : '';
        $default_array['job_location'] = isset($post_array['job_location']) ? $post_array['job_location'] : '';
        $default_array['job_type'] = isset($post_array['job_type']) ? $post_array['job_type'] : '';
        
        return $default_array;
        
    }
    
    public function get_job_functions() {
        
        global $wpdb;
        
        $select_array = array();
        
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dir_bpa_job_functions", ARRAY_A);
        
        foreach ($results as $result) {
            
           $select_array[$result['id']] = $result['type'];
            
        }
        
        return $select_array;
        
    }
    
    private function set_select_defaults($options, $default = '') {
        
        $output = '<option value="">Select</option>';
        
        foreach ($options as $value => $text) {
            
            $selected = '';
            
            if ($value == $default) {
                $selected = 'selected';
            }
            
            $output .= '<option value="' . $value . '" ' . $selected . '>'. $text . '</option>';
								
            
        }
        
        return $output;
        
    }
    
    public function filter_in_action() {
        
        $filter_html = $this->render_filter();
        
        echo $filter_html;
        
    }
	
	function cq_filter_function($wp_query){
		
         if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'filter_jobs' && $wp_query->is_main_query()) {

                $wp_query->set( 'orderby' , 'date');
                $wp_query->set( 'post_type', 'jobs');
                $args['meta_query'] = array();
        

            if ( isset( $_POST[ 'job_keywords' ] ) && $_POST[ 'job_keywords' ] != '') {
                $wp_query->set( 's', $_POST['job_keywords']);
            }

            // create $args['meta_query'] array if one of the following fields is filled
            if ( (isset( $_POST[ 'job_location' ] ) && $_POST[ 'job_location' ] != '') || (isset( $_POST[ 'job_type' ] ) && $_POST[ 'job_type' ] != '')) {
              $args[ 'meta_query' ] = array( 'relation' => 'AND' ); // AND means that all conditions of meta_query should be true
            }

            // if job_location is set
            if ( isset( $_POST[ 'job_location' ] ) && $_POST[ 'job_location' ] != '') {
              $args[ 'meta_query' ][] = array(
                'key' => 'cq_job_location',
                'value' => $_POST[ 'job_location' ],
                'compare' => 'LIKE'
              );
            }
            // if only max price is set
            if ( isset( $_POST[ 'job_type' ] ) && $_POST[ 'job_type' ] != '' ) {
              $args[ 'meta_query' ][] = array(
                'key' => 'cq_job_type',
                'value' => $_POST[ 'job_type' ],
                'type' => 'NUMERIC',
                'compare' => '='
              );
            }

            $wp_query->set( 'meta_query', $args[ 'meta_query' ] );

         }
   
        return $wp_query;
    }
}
cqJobsFilter::init();