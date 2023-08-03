<?php
class cqCatLandingPage {
    
    private $plugin_name = 'cq-custom';
	
	public static function init() {
		$self = new self();
		add_filter('request', array($self, 'cq_redirect_landing_page'));
        add_action( 'edit_form_after_title', array($self, 'add_content_after_editor') );
  	}


    public function cq_redirect_landing_page(array $query_vars) {
	
        if(is_admin()) {
            return $query_vars;
        }
        // if the query is for a category
        if(isset($query_vars['category_name']) && !isset($query_vars['name'])) {
            // save the slug
            $pagename = $query_vars['category_name'];
            $page_id = get_page_by_path( $pagename );

            if ($page_id != '') {
                // completely replace the query with a page query
                //$query_vars = array('pagename' => $pagename);
                unset($query_vars['category_name']);
                $query_vars['pagename'] = $pagename;
            }
        }

        return $query_vars;
    }

    function add_content_after_editor() {
        global $pagenow, $post;
        $id = $post->ID;
        $slug = $post->post_name;


        if (( $pagenow == 'post.php' ) && (get_post_type() == 'page')) {

            $cat_obj = get_category_by_slug( $slug );

            if ($cat_obj != '') {
                echo '<div class="postbox" style="margin-top: 1rem;"><div class="inside">';
                echo '<p>This will be the landing page for the category - <strong>' . $cat_obj->name . '</strong></p>';
                echo '</div></div>';
            }
        }
    }
}
cqCatLandingPage::init();