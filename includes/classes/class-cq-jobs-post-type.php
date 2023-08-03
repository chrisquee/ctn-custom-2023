<?php

class cqJobs {
    
    public static function init() {
        $self = new self();
        add_action( 'init', array( $self, 'create_job_postype' ));
        add_action( 'init', array( $self, 'create_jobcategory_taxonomy'), 0 );
        add_action( 'get_job_data', array( $self, 'cq_job_data') );
        //add_filter ('manage_edit-events_columns', array( $self, 'events_edit_columns'));
        //add_action ('manage_posts_custom_column', array( $self, 'events_custom_columns'));
        add_filter('post_updated_messages',  array( $self, 'jobs_updated_messages'));
        add_filter( 'rwmb_meta_boxes', array( $self, 'cq_metaboxes') );
    }
    
    public function create_job_postype() {
 
        $labels = array(
            'name' => _x('Jobs', 'post type general name'),
            'singular_name' => _x('Job', 'post type singular name'),
            'add_new' => _x('Add New', 'jobs'),
            'add_new_item' => __('Add New Job'),
            'edit_item' => __('Edit Job'),
            'new_item' => __('New Job'),
            'view_item' => __('View Job'),
            'search_items' => __('Search Jobs'),
            'not_found' =>  __('No jobs found'),
            'not_found_in_trash' => __('No jobs found in Trash'),
            'parent_item_colon' => '',
        );

        $args = array(
            'label' => __('Jobs'),
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'can_export' => true,
            'show_ui' => true,
            '_builtin' => false,
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-businessperson',
            'hierarchical' => false,
            'rewrite' => array( "slug" => "jobs" ),
            'supports'=> array('title', 'editor') ,
            'show_in_nav_menus' => true,
            'has_archive' => true,
            'taxonomies' => array( 'job-category', 'post_tag')
        );

        register_post_type( 'jobs', $args);

    }
    
    public function create_jobcategory_taxonomy() {
 
        $labels = array(
            'name' => _x( 'Job Categories', 'taxonomy general name' ),
            'singular_name' => _x( 'Job Category', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Job Categories' ),
            'popular_items' => __( 'Popular Job Categories' ),
            'all_items' => __( 'All Job Categories' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'Edit Job Category' ),
            'update_item' => __( 'Update Job Category' ),
            'add_new_item' => __( 'Add New Job Category' ),
            'new_item_name' => __( 'New Job Category Name' ),
            'separate_items_with_commas' => __( 'Separate job categories with commas' ),
            'add_or_remove_items' => __( 'Add or remove job categories' ),
            'choose_from_most_used' => __( 'Choose from the most used job categories' ),
        );

        register_taxonomy('job-category','jobs', array(
            'label' => __('Job Category'),
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'job-listings' ),
        ));
    }
    
    public function events_edit_columns($columns) {
 
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Event",
            "col_ev_cat" => "Category",
            "col_ev_date_from" => "Date From",
            "col_ev_date_to" => "Date To",
            "col_ev_thumb" => "Thumbnail",
            "col_ev_add" => "Address",
            );
        return $columns;
    }
 
    public function events_custom_columns($column) {
        
        global $post;
        
        $custom = get_post_custom();
        
        switch ($column) {
            case "col_ev_cat":
                // - show taxonomy terms -
                $eventcats = get_the_terms($post->ID, "event-category");
                $eventcats_html = array();
                if ($eventcats) {
                foreach ($eventcats as $eventcat)
                array_push($eventcats_html, $eventcat->name);
                echo implode(", ", $eventcats_html );
                } else {
                _e('None', 'CQ Custom');;
                }
            break;
            case "col_ev_date_from":
                // - show dates -
                $startd = rwmb_get_value('event_start_date');
                $startdate = date("F j, Y", $startd);

                echo $startdate;
            break;
                case "col_ev_date_to":
                $endd = rwmb_get_value('event_end_date');
                $enddate = date("F j, Y", $endd);
                echo $enddate;
            case "col_ev_thumb":
                // - show thumb -
                $post_image_id = get_post_thumbnail_id(get_the_ID());
                if ($post_image_id) {
                    $thumbnail = wp_get_attachment_image_src( $post_image_id, 'post-thumbnail', false);
                    if ($thumbnail) (string)$thumbnail = $thumbnail[0];
                    echo '<img src="';
                    echo bloginfo('template_url');
                    echo '/timthumb/timthumb.php?src=';
                    echo $thumbnail;
                    echo '&h=60&w=60&zc=1" alt="" />';
                }
            break;
            case "col_ev_add";
                $event_add = rwmb_get_value('event_address');
                echo nl2br($event_add);
            break;

        }
    }
    
    public function cq_metaboxes($meta_boxes) {
        
        $meta_boxes[] = array(
            'id' => 'job-settings',
            'title' => esc_html__( 'Job Settings', 'CQ_Custom' ),
            'pages'    => array( 'jobs' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'        => 'Job Location',
                    'id'          => 'cq_job_location',
                    'desc'        => 'Please enter the location of the job',
                    'type'        => 'text'),
                array(
                    'name'        => 'Company Name',
                    'id'          => 'cq_job_company_name',
                    'desc'        => 'Please enter the company name',
                    'type'        => 'text'),
                array(
                    'name'        => 'Brief Description',
                    'id'          => 'cq_job_brief_description',
                    'desc'        => 'Please enter a brief description',
                    'type'        => 'textarea',
                    'rows'		  => 6,
                    ),
                array(
                    'name'        => 'Application Instructions',
                    'id'          => 'cq_job_apply_instruction',
                    'desc'        => 'Please enter a brief description',
                    'type'        => 'textarea',
                    'rows'		  => 6,
                    ),
                array(
                    'name'        => 'Job Link',
                    'id'          => 'cq_job_link',
                    'desc'        => 'Please enter url link of the job',
                    'type'        => 'text'),
                array(
                    'name'        => 'Job Email',
                    'id'          => 'cq_job_email',
                    'desc'        => 'Please enter email to send applications',
                    'type'        => 'text'),
                array(
                    'name'        => 'Job Scope',
                    'id'          => 'cq_job_scope',
                    'desc'        => 'Is this Full time, Part time or a contract?',
                    'type'        => 'text'),
                array(
                    'name'        => 'Job Type',
                    'id'          => 'cq_job_type',
                    'type'        => 'select',
                    'options'     => $this->get_job_functions(),
                    ),
                array(
                    'id'      => 'cq_job_business_logo',
                    'name'    => __( 'Company logo for this job', 'CQ_Custom' ),
                    'type'    => 'image_advanced',

                ),
                array(
                    'name'        => 'Employer User',
                    'id'          => 'employer_id',
                    'type'        => 'select',
                    'options'     => $this->get_users_array(),
                    ),
            )

        );
        
        return $meta_boxes;
        
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
    
    public function get_users_array() {
        
        $users = get_users( array( 'role__in' => array( 'subscriber', 'directory_admin', 'administrator' ) ) );
        
        $user_array = array('' => 'Select');
        
        foreach ( $users as $user ) {
            $user_array[$user->ID] = $user->display_name;
        }
        
        return $user_array;
    }
    
    function cq_job_data($job_id = null) {
    	global $job;
    	$job = new cqjobsObject($job_id);	
	}
    
    public function jobs_updated_messages( $messages ) {
 
        global $post, $post_ID;

        $messages['jobs'] = array(
          0 => '', // Unused. Messages start at index 1.
          1 => sprintf( __('Job updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
          2 => __('Custom field updated.'),
          3 => __('Custom field deleted.'),
          4 => __('Event updated.'),
          /* translators: %s: date and time of the revision */
          5 => isset($_GET['revision']) ? sprintf( __('Job restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
          6 => sprintf( __('Job published. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
          7 => __('Job saved.'),
          8 => sprintf( __('Job submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
          9 => sprintf( __('Job scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
          10 => sprintf( __('Job draft updated. <a target="_blank" href="%s">Preview Job</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

        return $messages;
    }
    
}
cqJobs::init();