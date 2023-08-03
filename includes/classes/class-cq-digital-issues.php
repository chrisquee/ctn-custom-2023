<?php
class cqDigitalIssuePostType {
	
  private $plugin_name = 'cq-custom';
	
  public static function init() {
    $self = new self();
    add_action( 'init', array( $self, 'register_cq_digital_issue_post_type' ) );
    add_action( 'init', array( $self, 'cq_publications_taxonomy' ) );
    add_action( 'pre_get_posts', array( $self, 'archive_item_number') );
    add_filter( 'rwmb_meta_boxes', array( $self, 'cq_metaboxes') );
  }

  public function register_cq_digital_issue_post_type() {

    $labels = array(
      'name' => _x( 'Digital Issue', 'Post Type General Name', 'CQ_Custom' ),
      'singular_name' => _x( 'Digital Issue', 'Post Type Singular Name', 'CQ_Custom' ),
      'menu_name' => __( 'Digital Issues', 'CQ_Custom' ),
      'name_admin_bar' => __( 'Digital Issues', 'CQ_Custom' ),
      'archives' => __( 'Digital Issue Archives', 'CQ_Custom' ),
      'attributes' => __( 'Digital Issue Attributes', 'CQ_Custom' ),
      'parent_item_colon' => __( 'Parent Item:', 'CQ_Custom' ),
      'all_items' => __( 'All Digital Issues', 'CQ_Custom' ),
      'add_new_item' => __( 'Add New Digital Issue', 'CQ_Custom' ),
      'add_new' => __( 'Add New', 'CQ_Custom' ),
      'new_item' => __( 'Add New Digital Issue', 'CQ_Custom' ),
      'edit_item' => __( 'Edit Digital Issue', 'CQ_Custom' ),
      'update_item' => __( 'Update Digital Issue', 'CQ_Custom' ),
      'view_item' => __( 'View Digital Issue', 'CQ_Custom' ),
      'view_items' => __( 'View Digital Issue', 'CQ_Custom' ),
      'search_items' => __( 'Search Digital Issues', 'CQ_Custom' ),
      'not_found' => __( 'Not found', 'CQ_Custom' ),
      'not_found_in_trash' => __( 'Not found in Trash', 'CQ_Custom' ),
      'featured_image' => __( 'Digital Issue\'s Photo', 'CQ_Custom' ),
      'set_featured_image' => __( 'Set Digital Issue\'s Main Image', 'CQ_Custom' ),
      'remove_featured_image' => __( 'Remove Digital Issue\'s Main Image', 'CQ_Custom' ),
      'use_featured_image' => __( 'Use as Digital Issue\'s Main Image', 'CQ_Custom' ),
      'insert_into_item' => __( 'Insert into Digital Issue', 'CQ_Custom' ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'CQ_Custom' ),
      'items_list' => __( 'Digital Issues list', 'CQ_Custom' ),
      'items_list_navigation' => __( 'Items list navigation', 'CQ_Custom' ),
      'filter_items_list' => __( 'Filter Digital Issues', 'CQ_Custom' ),
    );
    $args = array(
      'label' => __( 'Digital Issue', 'CQ_Custom' ),
      'description' => __( 'Digital Issues', 'CQ_Custom' ),
      'labels' => $labels,
      'taxonomies' => array( 'cq_publications' ),
      'hierarchical' => false,
      'public' => true,
	  'supports' => array( 'title', 'editor', 'thumbnail', 'post-thumbnails' ),
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'show_in_admin_bar' => true,
      'show_in_nav_menus' => true,
      'show_in_rest' => true,
      'can_export' => true,
      'has_archive' => 'digital-issues',
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'capability_type' => 'page',
	  'menu_icon'   => 'dashicons-media-document',
	  'rewrite' => array( 'slug' => 'digital-issue' ),
    );
    register_post_type( 'cq_digital_issue', $args );

  }

  function cq_publications_taxonomy() {

    $labels = array(
      'name' => _x( 'Publications', 'Taxonomy General Name', 'CQ_Custom' ),
      'singular_name' => _x( 'Publication', 'Taxonomy Singular Name', 'CQ_Custom' ),
      'menu_name' => __( 'Publications', 'CQ_Custom' ),
      'all_items' => __( 'All Items', 'CQ_Custom' ),
      'parent_item' => __( 'Parent Item', 'CQ_Custom' ),
      'parent_item_colon' => __( 'Parent Item:', 'CQ_Custom' ),
      'new_item_name' => __( 'New Publication', 'CQ_Custom' ),
      'add_new_item' => __( 'Add New Publication', 'CQ_Custom' ),
      'edit_item' => __( 'Edit Publication', 'CQ_Custom' ),
      'update_item' => __( 'Update Publication', 'CQ_Custom' ),
      'view_item' => __( 'View Publication', 'CQ_Custom' ),
      'separate_items_with_commas' => __( 'Separate items with commas', 'CQ_Custom' ),
      'add_or_remove_items' => __( 'Add or remove items', 'CQ_Custom' ),
      'choose_from_most_used' => __( 'Choose from the most used', 'CQ_Custom' ),
      'popular_items' => __( 'Popular Items', 'CQ_Custom' ),
      'search_items' => __( 'Search Items', 'CQ_Custom' ),
      'not_found' => __( 'Not Found', 'CQ_Custom' ),
      'no_terms' => __( 'No items', 'CQ_Custom' ),
      'items_list' => __( 'Items list', 'CQ_Custom' ),
      'items_list_navigation' => __( 'Items list navigation', 'CQ_Custom' ),
    );
    $args = array(
      'labels' => $labels,
      'hierarchical' => true,
      'public' => true,
      'show_ui' => true,
      'show_admin_column' => true,
      'show_in_nav_menus' => true,
      'show_tagcloud' => false,
      'supports' => array( 'thumbnail' ),
	  'query_var' => true,
	  'rewrite' => array( 'slug' => 'digital-issues', 'with_front' => true, 'hierarchical' => true ),
    );
    register_taxonomy( 'cq_publications', array( 'cq_digital_issue' ), $args );
  }
    
  public function cq_metaboxes($meta_boxes) {
        
        $meta_boxes[] = array(
            'id' => 'external_links',
            'title' => esc_html__( 'External Link', 'CQ_Custom' ),
            'pages'    => array( 'cq_digital_issue' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'          => 'di_external_link',
                    'name'        => 'External Link',
                    'desc'        => 'Add an external link for this issue',
                    'type'        => 'text',
                ),  
            ),
        );
      
      return $meta_boxes;
  }
    
  public function archive_item_number( $query ) {

     if((is_post_type_archive( 'cq_digital_issue' ) || is_tax('cq_publications')) && !isset($_POST['page'])){ // change genre into your taxonomy or leave out for all
       // show 20 posts
       $query->set('posts_per_page', 13);
     }
  }

}
cqDigitalIssuePostType::init();