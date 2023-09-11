<?php 

class cqDestinations {
    
    public static function init() {
        $self = new self();
        add_action( 'init', array( $self, 'create_destination_postype' ));
        add_action( 'init', array( $self, 'create_cruise_line_postype' ));
        add_action( 'init', array( $self, 'create_cruise_ship_postype' ));
        add_action( 'init', array( $self, 'create_cruise_type_taxonomy'), 0 );
        add_action( 'pre_get_posts', array( $self, 'archive_item_number') );
        add_filter( 'rwmb_meta_boxes', array( $self, 'cq_metaboxes') );
        add_action( 'get_destination_data', array( $self, 'cq_destination_data') );
        add_action( 'get_ship_data', array( $self, 'cq_ship_data') );
        add_action('admin_head', array( $self, 'udg_admin_css') );
        add_action('cq_loadmore_cpt', array( $self, 'get_loadmore_template'));
        add_filter( 'ajax_loadmore_args', array( $self, 'cq_ajax_loadmore_args') );
        add_filter( 'ajax_loadmore_wrapper_classes', array( $self, 'cq_ajax_loadmore_wrapper_classes'), 10, 2 );
    }
    
    public function create_destination_postype() {
 
        $labels = array(
            'name' => _x('Destinations', 'post type general name'),
            'singular_name' => _x('Destination', 'post type singular name'),
            'add_new' => _x('Add New', 'events'),
            'add_new_item' => __('Add New Destination'),
            'edit_item' => __('Edit Destination'),
            'new_item' => __('New Destination'),
            'view_item' => __('View Destination'),
            'search_items' => __('Search Destinations'),
            'not_found' =>  __('No destinations found'),
            'not_found_in_trash' => __('No destinations found in Trash'),
            'parent_item_colon' => '',
        );

        $args = array(
            'label' => __('Destinations'),
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'can_export' => true,
            'show_ui' => true,
            '_builtin' => false,
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-admin-site-alt',
            'hierarchical' => false,
            'rewrite' => array( "slug" => "destinations" ),
            'supports'=> array('title', 'thumbnail') ,
            'show_in_nav_menus' => true,
            'taxonomies' => array( 'cruise-type', 'cruise-line')
        );

        register_post_type( 'destinations', $args);

    }
    
    public function create_cruise_line_postype() {
 
        $labels = array(
            'name' => _x('Cruise Lines', 'post type general name'),
            'singular_name' => _x('Cruise Line', 'post type singular name'),
            'add_new' => _x('Add New', 'events'),
            'add_new_item' => __('Add New Cruise Line'),
            'edit_item' => __('Edit Cruise Line'),
            'new_item' => __('New Cruise Line'),
            'view_item' => __('View Cruise Line'),
            'search_items' => __('Search Cruise Lines'),
            'not_found' =>  __('No Cruise Lines found'),
            'not_found_in_trash' => __('No Cruise Lines found in Trash'),
            'parent_item_colon' => '',
        );

        $args = array(
            'label' => __('Cruise Lines'),
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'can_export' => true,
            'show_ui' => true,
            '_builtin' => false,
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-sos',
            'has_archive' => true,
            'show_in_menu'  =>	'edit.php?post_type=destinations',
            'hierarchical' => false,
            'rewrite' => array( "slug" => "cruise-lines" ),
            'supports'=> array('title', 'thumbnail', 'page-attributes'),
            'show_in_nav_menus' => true,
            'taxonomies' => array( 'cruise-type')
        );

        register_post_type( 'cruise-line', $args);

    }
    
    public function create_cruise_type_taxonomy() {
 
        $labels = array(
            'name' => _x( 'Regions', 'taxonomy general name' ),
            'singular_name' => _x( 'Region', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Regions' ),
            'popular_items' => __( 'Popular Regions' ),
            'all_items' => __( 'All Regions' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'Edit Region' ),
            'update_item' => __( 'Update Region' ),
            'add_new_item' => __( 'Add New Region' ),
            'new_item_name' => __( 'New Region Name' ),
            'separate_items_with_commas' => __( 'Separate Regions with commas' ),
            'add_or_remove_items' => __( 'Add or remove Regions' ),
            'choose_from_most_used' => __( 'Choose from the most used Regions' ),
        );

        register_taxonomy('cruise-type',array('destinations', 'cruise-line'), array(
            'label' => __('Cruise Type'),
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'region' ),
        ));
    }
    
    public function create_cruise_ship_postype() {
 
        $labels = array(
            'name' => _x('Cruise ships', 'post type general name'),
            'singular_name' => _x('Cruise Ship', 'post type singular name'),
            'add_new' => _x('Add New', 'events'),
            'add_new_item' => __('Add New Cruise Ship'),
            'edit_item' => __('Edit Cruise Ship'),
            'new_item' => __('New Cruise Ship'),
            'view_item' => __('View Cruise Ship'),
            'search_items' => __('Search Cruise Ships'),
            'not_found' =>  __('No Cruise Ships found'),
            'not_found_in_trash' => __('No Cruise Ships found in Trash'),
            'parent_item_colon' => '',
        );

        $args = array(
            'label' => __('Cruise Ships'),
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'can_export' => true,
            'show_ui' => true,
            '_builtin' => false,
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-sos',
            'show_in_menu'  =>	'edit.php?post_type=destinations',
            'hierarchical' => false,
            'rewrite' => array( "slug" => "cruise-ship" ),
            'supports'=> array('title', 'thumbnail', 'editor') ,
            'show_in_nav_menus' => true
        );

        register_post_type( 'cruise-ship', $args);

    }
    
    /*public function create_cruise_line_taxonomy() {
 
        $labels = array(
            'name' => _x( 'Cruise Lines', 'taxonomy general name' ),
            'singular_name' => _x( 'Cruise Line', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Cruise Lines' ),
            'popular_items' => __( 'Popular Cruise Lines' ),
            'all_items' => __( 'All Cruise Lines' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'Edit Cruise Line' ),
            'update_item' => __( 'Update Cruise Line' ),
            'add_new_item' => __( 'Add New Cruise Line' ),
            'new_item_name' => __( 'New Cruise Line Name' ),
            'separate_items_with_commas' => __( 'Separate Cruise Lines with commas' ),
            'add_or_remove_items' => __( 'Add or remove Cruise Lines' ),
            'choose_from_most_used' => __( 'Choose from the most used Cruise Lines' ),
        );

        register_taxonomy('cruise-line', 'destinations', array(
            'label' => __('Cruise Line'),
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'cruise-line' ),
        ));
    }*/
    
    function cq_destination_data($destination_id = null) {
    	global $destination;
    	$destination = new cqDestinationsObject($destination_id);	
	}
    
    function cq_ship_data($ship_id = null) {
    	global $ship;
    	$ship = new cqshipObject($ship_id);	
	}
    
    public function cq_metaboxes($meta_boxes) {
        
        $meta_boxes[] = array(
            'id' => 'destination-settings',
            'title' => esc_html__( 'Destination Settings', 'CQ_Custom' ),
            'pages'    => array( 'destinations' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'        => 'Destination Intro',
                    'id'          => 'destination_intro',
                    'desc'        => 'Please enter a short introduction',
                    'type'        => 'textarea',
                ),
                array(
                    'name'        => 'Destination About',
                    'id'          => 'destination_about',
                    'type'    => 'wysiwyg',
                    'options' => array(
                                        'textarea_rows' => 4,
                                        'teeny'         => true,
                                      ),
                ),
                array(
                    'name'        => 'Why We Love <Destination>',
                    'id'          => 'destination_sell',
                    'desc'        => 'Please enter a short description',
                    'type'    => 'wysiwyg',
                    'options' => array(
                                        'textarea_rows' => 4,
                                        'teeny'         => true,
                                      ),
                ),
            ),
        );
                
                
        $meta_boxes[] = array(
            'id' => 'destination-images',
            'title' => esc_html__( 'Image Gallery', 'CQ_Custom' ),
            'pages'    => array( 'destinations', 'cruise-line', 'post' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'             => 'Image Gallery',
                    'id'               => 'destination-gallery',
                    'type'             => 'image_advanced',
                    'max_file_uploads' => 6,
                    'max_status'       => true,
                    'image_size'       => 'thumbnail',
                ),
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'destination-need',
            'title' => esc_html__( 'Need To Know', 'CQ_Custom' ),
            'pages'    => array( 'destinations' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'   => 'need_to_know',
                    'name' => 'Need to Know',
                    'type' => 'key_value',
                    'placeholder' => array( 'key' => 'Title', 'value' => 'Text' )
                ),
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'destination-interest',
            'title' => esc_html__( 'Points of Interest', 'CQ_Custom' ),
            'pages'    => array( 'destinations' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'   => 'Points of interest', // Optional
                    'id'     => 'points_of_interest',
                    'type'   => 'group',
                    'clone'  => true,
                    // List of sub-fields
                    'fields' => array(
                        array(
                            'name' => 'Heading',
                            'id'   => 'heading',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'description',
                            'id'   => 'description',
                            'type' => 'textarea',
                        ),
                        array(
                            'name' => 'Image',
                            'id'   => 'image',
                            'type' => 'single_image',
                        ),
                        // Other sub-fields here
                    ),
                ),
                
            )
        );
        
        $meta_boxes[] = array(
            'id' => 'destination-feature',
            'title' => esc_html__( 'Featured Item', 'CQ_Custom' ),
            'pages'    => array( 'destinations' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Heading',
                      'id'   => 'feature_heading',
                      'type' => 'text',
                  ),
                  array(
                      'name' => 'description',
                      'id'   => 'feature_description',
                      'type' => 'textarea',
                  ),
                  array(
                      'name' => 'Image',
                      'id'   => 'feature_image',
                      'type' => 'single_image',
                  ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'destination-selling',
            'title' => esc_html__( 'Selling Tips', 'CQ_Custom' ),
            'pages'    => array( 'destinations' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'   => 'selling-tips',
                    'name' => 'Selling Tips',
                    'type' => 'key_value',
                    'placeholder' => array( 'key' => 'Title', 'value' => 'Text' )
                ),
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-type-selling',
            'title' => esc_html__( 'Selling Tips', 'CQ_Custom' ),
            'taxonomies' => 'cruise-type',
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'   => 'selling-tips',
                    'name' => 'Selling Tips',
                    'type' => 'key_value',
                    'placeholder' => array( 'key' => 'Title', 'value' => 'Text' )
                ),
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-type-interest',
            'title' => esc_html__( 'Pre and post cruise ideas', 'CQ_Custom' ),
            'taxonomies' => 'cruise-type',
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'   => 'Pre and post cruise idea', // Optional
                    'id'     => 'cruise_type_interest',
                    'type'   => 'group',
                    'clone'  => true,
                    // List of sub-fields
                    'fields' => array(
                        array(
                            'name' => 'Heading',
                            'id'   => 'heading',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'description',
                            'id'   => 'description',
                            'type' => 'textarea',
                        ),
                        array(
                            'name' => 'Image',
                            'id'   => 'image',
                            'type' => 'single_image',
                        ),
                        // Other sub-fields here
                    ),
                ),
                
            )
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-type-feature',
            'title' => esc_html__( 'Featured Item', 'CQ_Custom' ),
            'taxonomies' => 'cruise-type',
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Heading',
                      'id'   => 'cruise_type_feature_heading',
                      'type' => 'text',
                  ),
                  array(
                      'name' => 'description',
                      'id'   => 'cruise_type_feature_description',
                      'type' => 'textarea',
                  ),
                  array(
                      'name' => 'Image',
                      'id'   => 'cruise_type_feature_image',
                      'type' => 'single_image',
                  ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'destination-cruise-lines',
            'title' => esc_html__( 'Cruise Lines', 'CQ_Custom' ),
            'pages'    => array( 'destinations' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                    array(
                        'name'        => 'Select Cruise Lines',
                        'id'          => 'cruise-lines',
                        'type'        => 'post',

                        // Post type.
                        'post_type'   => 'cruise-line',

                        // Field type.
                        'field_type'  => 'checkbox_list',

                        // Query arguments. See https://codex.wordpress.org/Class_Reference/WP_Query
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                            'orderby' => 'title',
                            'order'   => 'ASC',
                        ),
                    ),
                )
            );
        
        $meta_boxes[] = array(
            'id' => 'cruise-line-about',
            'title' => esc_html__( 'About this cruise Line', 'CQ_Custom' ),
            'pages'    => array( 'cruise-line' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'About this cruise line',
                      'id'   => 'cruise_line_about',
                      'type' => 'wysiwyg',
                      'options' => array('teeny' => true)
                  ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-line-cover-image',
            'title' => esc_html__( 'Main Image', 'CQ_Custom' ),
            'pages'    => array( 'cruise-line' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Cover Image',
                      'id'   => 'cruise_line_cover_image',
                      'type' => 'image_advanced',
                      'max_file_uploads' => 1,
                      'clone' => false,
                      'max_status' => false
                  ),
                  array(
                            'name' => 'Cover Image URL',
                            'id'   => 'cruise_line_cover_image_url',
                            'type' => 'text',
                        ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-line-why-choose',
            'title' => esc_html__( 'Why Choose this cruise Line', 'CQ_Custom' ),
            'pages'    => array( 'cruise-line' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Why choose this cruise line',
                      'id'   => 'cruise_line_choose',
                      'type' => 'wysiwyg',
                      'options' => array('teeny' => true)
                  ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-line-members_club',
            'title' => esc_html__( 'Members Club', 'CQ_Custom' ),
            'pages'    => array( 'cruise-line' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Members Club Text',
                      'id'   => 'members_club',
                      'type' => 'wysiwyg',
                      'options' => array('teeny' => true)
                  ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-line-video',
            'title' => esc_html__( 'Cruise Line Video', 'CQ_Custom' ),
            'pages'    => array( 'cruise-line' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Cruise Line Video',
                      'id'   => 'cruise_line_video',
                      'type' => 'oembed',
                  ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-line-content',
            'title' => esc_html__( 'Content', 'CQ_Custom' ),
            'pages'    => array( 'cruise-line' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'   => 'Sections', // Optional
                    'id'     => 'cruise_line-sections',
                    'type'   => 'group',
                    'clone'  => true,
                    'sort_clone' => true,
                    // List of sub-fields
                    'fields' => array(
                        array(
                            'name' => 'Section Heading',
                            'id'   => 'section-heading',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'Section Description',
                            'id'   => 'section-description',
                            'type' => 'wysiwyg',
                            'options' => array('teeny' => true, 'media_buttons' => false)
                        ),
                        array(
                            'name' => 'Section Image',
                            'id'   => 'section-image',
                            'type' => 'single_image',
                        ),
                        // Other sub-fields here
                    ),
                ),
                
            )
        );
        
        /*$meta_boxes[] = array(
            'id' => 'cruise-line-ships',
            'title' => esc_html__( 'Cruise Line Ships', 'CQ_Custom' ),
            'pages'    => array( 'cruise-line' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Cruise Line Ships',
                      'id'   => 'cruise_line_ships',
                      'type' => 'post',
                      'post_type'   => 'cruise-ship',
                      'field_type'  => 'select_advanced',
                      'placeholder' => 'Select ship(s)',
                      'multiple' => true,
                      'query_args'  => array(
                          'post_status'    => 'publish',
                          'posts_per_page' => - 1,
                      ),
                  ),
                  // Other sub-fields here
            ),
        );*/
        
        $meta_boxes[] = array(
            'id' => 'cruise-ships-line',
            'title' => esc_html__( 'Cruise Line', 'CQ_Custom' ),
            'pages'    => array( 'cruise-ship' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                  array(
                      'name' => 'Cruise Line Ships',
                      'id'   => 'cruise_line',
                      'type' => 'post',
                      'post_type'   => 'cruise-line',
                      'field_type'  => 'select_advanced',
                      'placeholder' => 'Select Cruise Line',
                      'multiple' => false,
                      'query_args'  => array(
                          'post_status'    => 'publish',
                          'posts_per_page' => - 1,
                      ),
                  ),
                  // Other sub-fields here
            ),
        );
        
        $meta_boxes[] = array(
            'id' => 'must-include-related',
            'title' => esc_html__( 'Related Articles', 'CQ_Custom' ),
            'pages'    => array( 'post' ),
            'desc' => 'Add related articles that must be shown',
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                      'name'        => 'Select an article',
                      'id'          => 'related-article',
                      'type'        => 'post',
                      'post_type'   => 'post',
                      'field_type'  => 'select_advanced',
                      'placeholder' => 'Select an article',
                      'clone'       => true,
                      'max_clone'   => 12,
                      'ajax' => true,
                      'query_args'  => array(
                          'post_status'    => 'publish',
                          'posts_per_page' => 10,
                      ),
                      'js_options' => array(
                        'minimumInputLength' => 3,
                     ),
                  ),

                
            )
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-ship-accomodation',
            'title' => esc_html__( 'Accomodation', 'CQ_Custom' ),
            'pages'    => array( 'cruise-ship' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'   => 'Accomodation', // Optional
                    'id'     => 'cruise_ship-accomodation',
                    'type'   => 'group',
                    'clone'  => true,
                    'sort_clone' => true,
                    // List of sub-fields
                    'fields' => array(
                        array(
                            'name' => 'Name',
                            'id'   => 'accomodation_name',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'Accomodation Description',
                            'id'   => 'accomodation_description',
                            'type' => 'wysiwyg',
                            'options' => array('teeny' => true, 'media_buttons' => false)
                        ),
                        array(
                            'name' => 'Accomodation Images',
                            'id'   => 'accomodation_images',
                            'type' => 'image_advanced',
                            'max_file_uploads' => 5,
                        ),
                        array(
                            'id'      => 'accomodation_widgety_images',
                            'name'    => 'Widgety Images',
                            'type'    => 'text_list',
                            'clone' => true,
                            'options' => array(
                                            'Large Image URL'      => 'Large Image',
                                            'Thumbnail URL' => 'Thumbnail',
                            )
                        ),
                        // Other sub-fields here
                    ),
                ),
                
            )
        );
        
        $meta_boxes[] = array(
            'id' => 'cruise-ship-entertainment',
            'title' => esc_html__( 'Entertainment', 'CQ_Custom' ),
            'pages'    => array( 'cruise-ship' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name'   => 'Entertainment', // Optional
                    'id'     => 'cruise_ship-entertainment',
                    'type'   => 'group',
                    'clone'  => true,
                    'sort_clone' => true,
                    // List of sub-fields
                    'fields' => array(
                        array(
                            'name' => 'Name',
                            'id'   => 'entertainment_name',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'Entertainment Description',
                            'id'   => 'entertainment_description',
                            'type' => 'wysiwyg',
                            'options' => array('teeny' => true, 'media_buttons' => false)
                        ),
                        array(
                            'name' => 'Entertainment Images',
                            'id'   => 'entertainment_images',
                            'type' => 'image_advanced',
                            'max_file_uploads' => 5,
                        ),
                        array(
                            'id'      => 'entertainment_widgety_images',
                            'name'    => 'Widgety Images',
                            'type'    => 'text_list',
                            'clone' => true,
                            'options' => array(
                                            'Large Image URL'      => 'Large Image',
                                            'Thumbnail URL' => 'Thumbnail',
                            )
                        ),
                    ),
                ),
                
            )
        );
        
        return $meta_boxes;
        
    }
    
    public function archive_item_number( $query ) {

     if (is_post_type_archive( 'cruise-line' ) && !isset($_POST['page']) && $query->is_main_query()) {
        
        $meta_query = array(
            array(
                'key' => '_thumbnail_id',
            )
        );
         
       // show 20 posts
       $query->set('meta_query', $meta_query);
       $query->set('posts_per_page', 20);
       $query->set( 'orderby', array( 'menu_order' => 'DESC', 'title' => 'ASC' ) );
     }
  }
    
    public function get_loadmore_template($args) {
        //get the item template to be used during AJAX loadmore
        if (isset($args['post_type']) && $args['post_type'] == 'cruise-line') {
                
            ob_start();
            cq_get_template('cruise-line/cruise-line-listing.php');
            $post = ob_get_clean();

            echo $post;

        }
        
        return;
        
    }
    
    public function cq_ajax_loadmore_args($args) {
        
        if ($args['post_type'] == 'cruise-line') {
            
            $args['posts_per_page'] = 20;
            
            $offset = 10;
            $page_offset = $offset + ( ($_POST['page']-1) * 20 ) + 19;
	
	        $args['offset'] = $page_offset;
            
        }
        
        return $args;
        
    }
    
    public function cq_ajax_loadmore_wrapper_classes($classes, $args) {
        
        if ($args['post_type'] == 'cruise-line') {
            
            $key = array_search('archive-row', $classes);
            unset($classes[$key]);
            
            $classes[] = 'cruise-lines-wrapper';
            
        }
        
        return $classes;
        
    }

    function udg_admin_css() {
      echo '<style>
        body.taxonomy-cruise-type .rwmb-meta-box {
          padding: 0;
          border: 1px solid #c3c4c7;
          background-color: white;
          border-radius: 5px;
          margin-bottom: 1rem;
        }
        body.taxonomy-cruise-type .rwmb-meta-box > h2 {
            margin: 0;
            padding: 15px;
            border-bottom: 1px solid #f6f6f6;
        }
        body.taxonomy-cruise-type .rwmb-meta-box > .rwmb-field {
            padding: 0 15px;
            display: flex;
        }
        #destination-cruise-lines ul.rwmb-input-list{
            display: grid;
            grid-template-columns: repeat( auto-fit, minmax(250px, 1fr) );
            grid-gap: 10px;
        }
      </style>';
    }
}
cqDestinations::init();