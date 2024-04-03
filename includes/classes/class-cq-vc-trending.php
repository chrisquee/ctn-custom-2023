<?php

class cqVcTrending {
    
    private $plugin_name = 'cq-custom';
    
    public static function init() {
		$self = new self();
		add_action( 'vc_before_init', array($self, 'cq_vc_trending' ));
        add_filter( 'vc_autocomplete_cq_popular_posts_post_id_render', 'cq_post_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_popular_posts_post_id_callback', 'cq_post_autocomplete_suggester', 10, 1 );
  	}
    
    public function cq_vc_trending() {
	
        global $wpdb;

        $output_categories = array();

        if (isset($_POST['action']) && $_POST['action'] == 'vc_edit_form') {
            $categories = get_categories();
            $output_categories[] = array('', 'Choose Category');

            foreach($categories as $category) { 
                $output_categories[] = array($category->term_id, html_entity_decode($category->name));
            }
        }
        
        $output_ad_placements = array('Select Placement' => '');
        $placements = get_option( 'advads-ads-placements' );
        
        if (is_array($placements)) {
            
            foreach ($placements as $key => $value) {
                $output_ad_placements[$value['name']] = $key;
            }
            
        }

        vc_map( array(
            "name" => __( "CQ Popular Posts", 'CQ_Custom' ),
            "base" => "cq_popular_posts",
            "description" => "Popular Posts",
            "class" => "",
            "icon" => "",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Number of Posts", 'CQ_Custom' ),
                    "param_name" => "popular_number",
                    "value" => array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15),
                    "description" => __( "Choose the number of posts to display", 'CQ_Custom' )
                ),
                array(
                    'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Must Include', 'CQ_Custom' ),
                    'param_name'    => 'post_id',
                    "admin_label" => true,
                    "description" => __( "Choose some posts that must be displayed", 'CQ_Custom' ),
                    'settings' => array('multiple' => true, 'sortable' => true, 'unique_values' => true),
                ),
                array(
                    "type" => "textfield",
                    "heading" => __( "Extra class name", "CQ_Custom" ),
                    "param_name" => "el_class",
                    "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Select Category", 'CQ_Custom' ),
                    "param_name" => "category",
                    "value" => $output_categories,
                    "description" => __( "Limit results by category.", 'CQ_Custom' )
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Select Style", 'CQ_Custom' ),
                    "param_name" => "style",
                    "value" => array(
                                    array('full', 'Full'),
                                    array('compact', 'Compact')
                                    ),
                    "description" => __( "Limit results by category.", 'CQ_Custom' )
                ),
                array(
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Include Ad Space", "CQ_Custom" ),
                    "description"   => __("Include an ad space in this element", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "ad_space"
                ),
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Ad Content", 'CQ_Custom' ),
					"param_name" => "ad_shortcode",
					"value" => $output_ad_placements,
                    "label" => "Ad Placement",
                    "admin_label" => true,
					"description" => __( "Choose the ad placement to use.", 'CQ_Custom' ),
                    "dependency"    => array(
                        'element'   => 'ad_space',
                        'value'     => 'true'
                    ),
				),
            )
       ) );
    }
}
cqVcTrending::init();