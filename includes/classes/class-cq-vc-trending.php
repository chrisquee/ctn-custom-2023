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
                $output_categories[] = array($category->term_id, $category->name);
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
                    "value" => array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ,14, 15),
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
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Include Ad Space", "CQ_Custom" ),
                    "description"   => __("Include an ad space in this element", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "ad_space"
                ),
                array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Ad Content", 'CQ_Custom' ),
					"param_name" => "ad_shortcode",
					"value" => '',
                    "label" => "Ad Shortcode",
                    "admin_label" => true,
					"description" => __( "Enter the ad placement id.", 'CQ_Custom' ),
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