<?php

class cqSpeakers {
    
    public static function init() {
        $self = new self();
        add_action( 'init', array( $self, 'register_cq_speakers_post_type' ));
        add_action( 'init', array( $self, 'create_speaker_category_taxonomy'), 0 );
        add_filter( 'rwmb_meta_boxes', array( $self, 'cq_speakers_meta_box') );
    }
    
    public function register_cq_speakers_post_type() {

        $labels = array(
            'name'                  => _x( 'Speakers', 'Post Type General Name', 'CQ_Custom' ),
            'singular_name'         => _x( 'Speaker', 'Post Type Singular Name', 'CQ_Custom' ),
            'menu_name'             => __( 'Speakers', 'CQ_Custom' ),
            'name_admin_bar'        => __( 'Speakers', 'CQ_Custom' ),
            'archives'              => __( 'Speakers Archives', 'CQ_Custom' ),
            'attributes'            => __( 'Speakers Attributes', 'CQ_Custom' ),
            'parent_item_colon'     => __( 'Parent Item:', 'CQ_Custom' ),
            'all_items'             => __( 'All Speakers', 'CQ_Custom' ),
            'add_new_item'          => __( 'Add New Speaker', 'CQ_Custom' ),
            'add_new'               => __( 'Add New', 'CQ_Custom' ),
            'new_item'              => __( 'Add New Speaker', 'CQ_Custom' ),
            'edit_item'             => __( 'Edit Speaker', 'CQ_Custom' ),
            'update_item'           => __( 'Update Speaker', 'CQ_Custom' ),
            'view_item'             => __( 'View Speaker', 'CQ_Custom' ),
            'view_items'            => __( 'View Speaker', 'CQ_Custom' ),
            'search_items'          => __( 'Search Speakers', 'CQ_Custom' ),
            'not_found'             => __( 'Not found', 'CQ_Custom' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'CQ_Custom' ),
            'featured_image'        => __( 'Speaker\'s Photo', 'CQ_Custom' ),
            'set_featured_image'    => __( 'Set Speaker\'s Photo', 'CQ_Custom' ),
            'remove_featured_image' => __( 'Remove Speaker\'s Photo', 'CQ_Custom' ),
            'use_featured_image'    => __( 'Use as Speaker\'s Photo', 'CQ_Custom' ),
            'insert_into_item'      => __( 'Insert into Speaker', 'CQ_Custom' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'CQ_Custom' ),
            'items_list'            => __( 'Speakers list', 'CQ_Custom' ),
            'items_list_navigation' => __( 'Items list navigation', 'CQ_Custom' ),
            'filter_items_list'     => __( 'Filter Speakers', 'CQ_Custom' ),
        );
        $args = array(
            'label'                 => __( 'Speaker', 'CQ_Custom' ),
            'description'           => __( 'Speakers', 'CQ_Custom' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'taxonomies'            => array( 'cq_sessions' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'cq_speakers', $args );

    }
    
    public function create_speaker_category_taxonomy() {

        $labels = array(
            'name'                       => _x( 'Speaker Categories', 'Taxonomy General Name', 'CQ_Custom' ),
            'singular_name'              => _x( 'Speaker Category', 'Taxonomy Singular Name', 'CQ_Custom' ),
            'menu_name'                  => __( 'Speaker Categories', 'CQ_Custom' ),
            'all_items'                  => __( 'All Items', 'CQ_Custom' ),
            'parent_item'                => __( 'Parent Item', 'CQ_Custom' ),
            'parent_item_colon'          => __( 'Parent Item:', 'CQ_Custom' ),
            'new_item_name'              => __( 'New Speaker Category', 'CQ_Custom' ),
            'add_new_item'               => __( 'Add New Speaker Category', 'CQ_Custom' ),
            'edit_item'                  => __( 'Edit Speaker Category', 'CQ_Custom' ),
            'update_item'                => __( 'Update Speaker Category', 'CQ_Custom' ),
            'view_item'                  => __( 'View Speaker Category', 'CQ_Custom' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'CQ_Custom' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'CQ_Custom' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'CQ_Custom' ),
            'popular_items'              => __( 'Popular Items', 'CQ_Custom' ),
            'search_items'               => __( 'Search Items', 'CQ_Custom' ),
            'not_found'                  => __( 'Not Found', 'CQ_Custom' ),
            'no_terms'                   => __( 'No items', 'CQ_Custom' ),
            'items_list'                 => __( 'Items list', 'CQ_Custom' ),
            'items_list_navigation'      => __( 'Items list navigation', 'CQ_Custom' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'supports'          => array( 'thumbnail' ),
        );
        register_taxonomy( 'cq_speaker_category', array( 'cq_speakers' ), $args );

    }
    
    public function cq_speakers_meta_box( $meta_boxes ) {
        $meta_boxes[] = array(
            'title'      => __( 'Details', 'CQ_Custom' ),
            'post_types' => array( 'cq_speakers' ),
            'fields'     => array(
                array(
                    'id'   => 'speaker-job-title',
                    'name' => __( 'Job Title', 'CQ_Custom' ),
                    'type' => 'text',
                	),
				 array(
                    'id'   => 'speaker-company',
                    'name' => __( 'Company', 'CQ_Custom' ),
                    'type' => 'text',
                	)
                )
            );
	
        
        return $meta_boxes;
    }
}
cqSpeakers::init();