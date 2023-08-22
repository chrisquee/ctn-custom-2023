<?php

class cqJobUser {
    
    public static function init() {
    	$self = new self();
        add_action( 'get_current_job_listings', array($self, 'get_current_job_listings') );
        add_action( 'setup_job_edit_form', array($self, 'setup_job_edit_form') );
        add_action( 'setup_job_new_form', array($self, 'setup_job_new_form') );
        add_action( 'admin_post_submit_new_job', array( $self, 'update_add_job') );
        add_action( 'admin_post_submit_job_updates', array( $self, 'update_add_job') );
        add_action( 'wp_footer', array($self, 'render_delete_modal') );
        add_action( 'wp_ajax_remove_job', array($self, 'remove_job') );
  	}
    
    public function get_current_job_listings() {
        
        global $job, $post, $wp_query;
		
		$user_id = get_current_user_id();
		$qstring = isset($wp_query->query_vars['current-jobs']) ? $wp_query->query_vars['current-jobs'] : 1;
		$qpage = str_replace('page/', '', $qstring);
		
		$the_query = new WP_Query( array('posts_per_page'=>20,
                                 'post_type'=>'jobs',
                                 'paged' => $qpage,
								 'meta_query' => array(
                                        array(
                                            'key' => 'employer_id',
                                            'value' => $user_id
                                        )
									  )
								    ) 
                            	); 
                            ?>

    <?php 
		if ( $the_query->post_count > 0 ) { 
                
                $html = '<table class="table business-listings">
                            <thead>
                                <th>ID</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>';
                
         while ($the_query->have_posts()) : $the_query->the_post(); 
                    
                    do_action('get_job_data', get_the_id());
                    
                    $html .= '<tr id="row-' . get_the_id() . '">
                                <td>' . get_the_id() . '</td>
                                <td>' . get_the_title() . '</td>
                                <td>' . esc_html($job->job_company) . '</td>
                                <td>' . esc_html($job->job_location) . '</td>
                                <td><a href="' . add_query_arg(array('job_id' => get_the_id()), site_url('/my-account/job-edit/')) . '" class="button button-brand button-outline button-small icon-button"><span class="material-symbols-outlined">edit</span></a>
                                <button class="button button-brand button-fill button-small icon-button set-draft" title="Delete item" data-bs-toggle="modal" data-bs-target="#deleteModal" data-itemName="' . get_the_title() . '" data-id="' . get_the_id() . '" data-nonce="' . wp_create_nonce( 'job-remove-nonce' ) .'"><span class="material-symbols-outlined">delete</span></button></td>
                             </tr>';
                    
                
			endwhile; 
                            
                $html .= '</tbody>
                        </table>';
            } else {
                $html = '<div class="result_empty col_6"><h3> No Results</h3></div>';
            }
             
        echo $html;
        
        return;
        
    }
    
    public function get_user_jobs($user_id) {
        
        $args = array(
          'posts_per_page'   => -1,
          'post_type'        => 'jobs',
          'meta_key'         => 'employer_id',
          'meta_value'       => $user_id
        );
        
        $job_query = new WP_Query( $args );
        
    }
    
    public function setup_job_edit_form() {
    
        global $job, $wp_query;

        $job_id = isset($_GET['job_id']) && $_GET['job_id'] != '' ? intval(sanitize_text_field($_GET['job_id'])) : '';
        $message = '';
        $action = 'submit_job_updates';
        $user_id = get_current_user_id();

        if (is_numeric($job_id)) {
            $job = new cqjobsObject($job_id);
        }

        ?>
        <div id="updated-container-link" class="container">
	        <div class="updated-container">
                <h3>Editing - <?php echo $job->job_title; ?></h3>
            </div>
        </div>

        <div class="icon32 icon32-posts-post" id="icon-edit"></div>
        <?php echo $message; ?>

        <?php include_once(dirname(__FILE__) . '/../templates/dashboard/job-submit-form.php'); ?>
    <?php
    }
    
    public function setup_job_new_form() {
    
        global $company, $wp_query;

        $message = '';
        $action = 'submit_new_job';

        $job = new cqjobsObject();

        $user_id = get_current_user_id();

        ?>

        <div class="icon32 icon32-posts-post" id="icon-edit"></div>
        <?php echo $message; ?>

        <?php include_once(dirname(__FILE__) . '/../templates/dashboard/job-submit-form.php'); ?>

    <?php
    }
    
    public function update_add_job() {
        
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $redirect = isset($_POST['redirect']) && $_POST['redirect'] != '' ? sanitize_text_field($_POST['redirect']) : '';
        $job_id = isset($_POST['job_id']) && $_POST['job_id'] != '' ? sanitize_text_field($_POST['job_id']) : '';
        $job_title = isset($_POST['job_title']) && $_POST['job_title'] != '' ? sanitize_text_field($_POST['job_title']) : '';
        $job_location = isset($_POST['job_location']) && $_POST['job_location'] != '' ? sanitize_text_field($_POST['job_location']) : '';
        $job_company_name = isset($_POST['job_company_name']) && $_POST['job_company_name'] != '' ? sanitize_text_field($_POST['job_company_name']) : '';
        $job_scope = isset($_POST['job_scope']) && $_POST['job_scope'] != '' ? sanitize_text_field($_POST['job_scope']) : '';
        $job_type = isset($_POST['job_type']) && $_POST['job_type'] != '' ? sanitize_text_field($_POST['job_type']) : '';
        $job_url = isset($_POST['job_url']) && $_POST['job_url'] != '' ? sanitize_text_field($_POST['job_url']) : '';
        $job_email = isset($_POST['job_email']) && $_POST['job_email'] != '' ? sanitize_email($_POST['job_email']) : '';
        $job_introduction = isset($_POST['job_introduction']) && $_POST['job_introduction'] != '' ? nl2br(sanitize_textarea_field($_POST['job_introduction'])) : '';
        $job_description = isset($_POST['job_description']) && $_POST['job_description'] != '' ? nl2br(sanitize_textarea_field($_POST['job_description'])) : '';
        $application_instructions = isset($_POST['application_instructions']) && $_POST['application_instructions'] != '' ? nl2br(sanitize_textarea_field($_POST['application_instructions'])) : '';
        $job_logo = isset($_POST['logo_image_id']) && $_POST['logo_image_id'] != '' ? sanitize_text_field($_POST['logo_image_id']) : '';
        $employer_id = isset($_POST['employer_id']) && $_POST['employer_id'] != '' ? sanitize_text_field($_POST['employer_id']) : '';
        
        $meta_array = array('cq_job_location' => $job_location,
                            'cq_job_company_name' => $job_company_name,
                            'cq_job_brief_description' => $job_introduction,
                            'cq_job_apply_instruction' => $application_instructions,
                            'cq_job_link' => $job_url,
                            'cq_job_email' => $job_email,
                            'cq_job_scope' => $job_scope,
                            'cq_job_type' => $job_type,
                            'cq_job_business_logo' => $job_logo,
                            'employer_id' => $employer_id);
        
        $post_array = array('post_content' => $job_description,
                            'post_title' => $job_title,
                            'post_status' => 'publish',
                            'post_type' => 'jobs',
                            'meta_input' => $meta_array);
        
        if ($job_id != '') {
            $post_array['ID'] = $job_id;
        }
        
        $job_id = wp_insert_post($post_array);
        
        if(!is_wp_error($job_id)){
            $redirect = add_query_arg(array('status' => 'success', 'job_id' => $job_id), site_url('/my-account/job-edit/'));
        } else {
            $redirect = add_query_arg('status', 'failed', $redirect);
        }
        
        wp_redirect($redirect);
        
    }
    
    public function render_delete_modal() {
        
        global $wp_query;
        
        if (isset($wp_query->query_vars['current-jobs']) && $wp_query->query_vars['pagename'] == 'my-account') {
            echo '<!-- The Modal -->
                  <div class="modal fade" id="deleteModal">
                    <div class="modal-dialog">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <span class="lnr lnr-cross-circle modal-icon"></span>
                          <h4 class="modal-title">Delete Item</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                          <p>Are you sure you want to delete the following item?</p>
                          <p><strong><span id="item_name"></span></strong></p>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="button button-brand button-outline" data-bs-dismiss="modal">Close</button>
                          <button type="button" class="button button-brand button-fill set-delete" data-id="" data-nonce="' . wp_create_nonce( 'job-remove-nonce' ) . '">Delete</button>
                        </div>

                      </div>
                    </div>
                  </div>';
        }
        
    }
    
    public function remove_job() {
        
        check_ajax_referer( 'cq-nonce', 'security' );
        
        if (isset($_POST['job_id']) && $_POST['job_id'] != '') {
            
            $job_id = intval($_POST['job_id']);
            $job_data = array();
            
            $job_data['ID'] = $job_id;
            $job_data['post_status'] = 'draft'; // use any post status
            $id = wp_update_post($job_data);
            
            if (is_numeric($id)) {
                $return_array = array('status' => 'success', 'job_id' => $id, 'message' => 'Job set to draft');
            } else {
                $return_array = array('status' => 'failed', 'message' => 'Could not edit item');
            }       
        }
        
        echo json_encode($return_array);
        
        die;
        
    }
}
cqJobUser::init();