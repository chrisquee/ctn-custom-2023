<?php
class cqCarousels {
    
    public static function init() {
        $self = new self();
        add_action( 'init', array( $self, 'register_cq_carousel_post_type' ));
        add_action( 'init', array( $self, 'register_cq_carousel_taxonomy'), 0 );
        add_filter( 'rwmb_meta_boxes', array( $self, 'cq_carousel_meta_box') );
    }
    
    function register_cq_carousel_post_type() {

        $labels = array(
            'name'                  => _x( 'Carousel Items', 'Post Type General Name', 'CQ_Custom' ),
            'singular_name'         => _x( 'Carousel Item', 'Post Type Singular Name', 'CQ_Custom' ),
            'menu_name'             => __( 'CQ Carousel', 'CQ_Custom' ),
            'name_admin_bar'        => __( 'CQ Carousel', 'CQ_Custom' ),
            'archives'              => __( 'Item Archives', 'CQ_Custom' ),
            'attributes'            => __( 'Item Attributes', 'CQ_Custom' ),
            'parent_item_colon'     => __( 'Parent Item:', 'CQ_Custom' ),
            'all_items'             => __( 'All Items', 'CQ_Custom' ),
            'add_new_item'          => __( 'Add New Item', 'CQ_Custom' ),
            'add_new'               => __( 'Add New', 'CQ_Custom' ),
            'new_item'              => __( 'Add New Carousel Item', 'CQ_Custom' ),
            'edit_item'             => __( 'Edit Carousel Item', 'CQ_Custom' ),
            'update_item'           => __( 'Update Carousel Item', 'CQ_Custom' ),
            'view_item'             => __( 'View Carousel Item', 'CQ_Custom' ),
            'view_items'            => __( 'View Carousel Items', 'CQ_Custom' ),
            'search_items'          => __( 'Search Carousel Item', 'CQ_Custom' ),
            'not_found'             => __( 'Not found', 'CQ_Custom' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'CQ_Custom' ),
            'featured_image'        => __( 'Carousel Image', 'CQ_Custom' ),
            'set_featured_image'    => __( 'Set Carousel image', 'CQ_Custom' ),
            'remove_featured_image' => __( 'Remove Carousel image', 'CQ_Custom' ),
            'use_featured_image'    => __( 'Use as Carousel image', 'CQ_Custom' ),
            'insert_into_item'      => __( 'Insert into Carousel item', 'CQ_Custom' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'CQ_Custom' ),
            'items_list'            => __( 'Items list', 'CQ_Custom' ),
            'items_list_navigation' => __( 'Items list navigation', 'CQ_Custom' ),
            'filter_items_list'     => __( 'Filter items list', 'CQ_Custom' ),
        );
        $args = array(
            'label'                 => __( 'Carousel Item', 'CQ_Custom' ),
            'description'           => __( 'Carousel Items', 'CQ_Custom' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'thumbnail', 'custom-fields' ),
            'taxonomies'            => array( 'cq_carousels' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        
        register_post_type( 'cq_carousel', $args );

    }
    
    public function register_cq_carousel_taxonomy() {

        $labels = array(
            'name'                       => _x( 'Carousels', 'Taxonomy General Name', 'CQ_Custom' ),
            'singular_name'              => _x( 'Carousel', 'Taxonomy Singular Name', 'CQ_Custom' ),
            'menu_name'                  => __( 'Carousels', 'CQ_Custom' ),
            'all_items'                  => __( 'All Items', 'CQ_Custom' ),
            'parent_item'                => __( 'Parent Item', 'CQ_Custom' ),
            'parent_item_colon'          => __( 'Parent Item:', 'CQ_Custom' ),
            'new_item_name'              => __( 'New Carousel', 'CQ_Custom' ),
            'add_new_item'               => __( 'Add New Carousel', 'CQ_Custom' ),
            'edit_item'                  => __( 'Edit Carousel', 'CQ_Custom' ),
            'update_item'                => __( 'Update Carousel', 'CQ_Custom' ),
            'view_item'                  => __( 'View Carousel', 'CQ_Custom' ),
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
        );
        register_taxonomy( 'cq_carousels', array( 'cq_carousel' ), $args );

    }
    
    public function cq_carousel_meta_box( $meta_boxes ) {
        $meta_boxes[] = array(
            'title'      => __( 'Carousel Item Link', 'CQ_Custom' ),
            'post_types' => array( 'cq_carousel' ),
            'fields'     => array(
                array(
                    'id'   => 'varousel-item-link',
                    'name' => __( 'Image Link', 'CQ_Custom' ),
                    'type' => 'text',
                )	
                )
            );
	
        
        return $meta_boxes;
    }
}
cqCarousels::init();  
    