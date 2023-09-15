<?php
class cqVcExtend {
	
	private $plugin_name = 'cq-custom';
	
	public static function init() {
		$self = new self();
		add_action( 'vc_before_init', array($self, 'cq_large_cta') );
        add_action( 'vc_before_init', array($self, 'cq_add_container_row') );
		add_action( 'vc_before_init', array($self, 'cq_title_separator') );
        add_action( 'vc_before_init', array($self, 'cq_featured_news') );
        add_action( 'vc_before_init', array($self, 'cq_latest_news') );
        add_action( 'vc_before_init', array($self, 'cq_latest_digital_issues') );
        add_action( 'vc_before_init', array($self, 'cq_latest_issue') );
        add_action( 'vc_before_init', array($self, 'cq_latest_post_row') );
        add_action( 'vc_before_init', array($self, 'cq_publication_box') );
        add_action( 'vc_before_init', array($self, 'cq_in_page_menu') );
        add_action( 'vc_before_init', array($self, 'cq_vc_events_list') );
        add_action( 'vc_before_init', array($self, 'cq_vc_fullevents_list') );
        add_action( 'vc_before_init', array($self, 'cq_category_carousel') );
        add_action( 'vc_before_init', array($self, 'cq_category_carousel_item') );
        add_action( 'vc_before_init', array($self, 'cq_category_grid') );
        add_action( 'vc_before_init', array($self, 'cq_category_grid_item') );
        add_action( 'vc_before_init', array($self, 'cq_category_link_block') );
        add_action( 'vc_before_init', array($self, 'cq_vc_newsletter_block') );
        add_action( 'vc_before_init', array($self, 'cq_single_ad_space') );
        add_action( 'vc_before_init', array($self, 'cq_vc_post_timeline') );
        add_action( 'vc_before_init', array($self, 'cq_single_region') );
        add_action( 'vc_before_init', array($self, 'cq_featured_regions') );
        add_action( 'vc_before_init', array($self, 'cq_featured_regions_item') );
        add_action( 'vc_before_init', array($self, 'cq_featured_destinations') );
        add_action( 'vc_before_init', array($self, 'cq_featured_destinations_item') );
        add_action( 'vc_before_init', array($self, 'cq_featured_cruise_lines') );
        add_action( 'vc_before_init', array($self, 'cq_featured_cruise_lines_item') );
        add_action( 'vc_before_init', array($self, 'cq_featured_cruise_ships') );
        add_action( 'vc_before_init', array($self, 'cq_featured_cruise_ships_item') );
        add_action( 'vc_before_init', array($self, 'cq_udg_full_width_block') );
        add_action( 'vc_before_init', array($self, 'cq_speaker_list') );
        add_action( 'vc_before_init', array($self, 'cq_custom_agenda_day') );
        add_action( 'vc_before_init', array($self, 'cq_standard_carousel') );
        add_action( 'vc_before_init', array($self, 'cq_grid_links') );
        add_action( 'vc_before_init', array($self, 'cq_grid_links_item') );
        add_action( 'vc_before_init', array($self, 'cq_latest_jobs_row') );
        add_action( 'vc_before_init', array($self, 'cq_call_to_action') );
        //vc_add_shortcode_param( 'timefield', array($self, 'cq_add_vc_time') );
        //vc_add_shortcode_param( 'datefield', array($self, 'cq_add_vc_date') );
        add_filter( 'vc_autocomplete_cq_category_carousel_item_category_id_render', 'cq_category_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_category_carousel_item_category_id_callback', 'cq_category_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_category_grid_item_category_id_render', 'cq_category_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_category_grid_item_category_id_callback', 'cq_category_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_latest_news_post_id_render', 'cq_post_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_latest_news_post_id_callback', 'cq_post_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_news_post_id_render', 'cq_post_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_news_post_id_callback', 'cq_post_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_latest_news_category_not_render', 'cq_category_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_latest_news_category_not_callback', 'cq_category_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_regions_item_region_id_render', 'cq_region_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_regions_item_region_id_callback', 'cq_region_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_destinations_item_destination_id_render', 'cq_destination_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_destinations_item_destination_id_callback', 'cq_destination_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_cruise_lines_item_cruise_line_id_render', 'cq_cruise_line_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_cruise_lines_item_cruise_line_id_callback', 'cq_cruise_line_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_cruise_ships_item_cruise_ship_id_render', 'cq_ship_autocomplete_suggester_render', 10, 1 );
        add_filter( 'vc_autocomplete_cq_featured_cruise_ships_item_cruise_ship_id_callback', 'cq_ship_autocomplete_suggester', 10, 1 );
        add_filter( 'vc_autocomplete_cq_events_list_event_id_render', array($self, 'cq_event_autocomplete_suggester_render'), 10, 1 );
        add_filter( 'vc_autocomplete_cq_events_list_event_id_callback', array($self, 'cq_event_autocomplete_suggester'), 10, 1 );
        add_action('admin_enqueue_scripts', array( $self, 'enqueue_scripts'));
  	}
    
    function enqueue_scripts(){
        
        global $pagenow;
        
        wp_enqueue_script( 'cq-file-picker', plugins_url('/cq-custom/assets/js/cq-admin-js.js', 'cq-custom'), array( 'jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-droppable' ), '1.0.0', true );
    }
    
    public function cq_large_cta() {
        
        vc_map( array(
			"name" => __( "CQ Large CTA", "CQ_Custom" ),
			"base" => "cq_large_cta",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
					"type" => "attach_image",
					"heading" => __( "Background Image", "CQ_Custom" ),
					"param_name" => "cq_fw_cta_bg_img",
					"description" => __( "Select a background image for this element", "CQ_Custom" )
				),
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Title Size", 'CQ_Custom' ),
					"param_name" => "title_size",
					"value" => array( 'Select' => '', 'H1' => 'h1','H2' => 'h2', 'H3' => 'h3' ),
					"description" => __( "Choose the size of the title, H1 is the default.", 'CQ_Custom' )
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Title", 'CQ_Custom' ),
					"param_name" => "fw_cta_title",
					"value" => '',
					"description" => __( "Enter the title", 'CQ_Custom' )
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Subtitle", 'CQ_Custom' ),
					"param_name" => "fw_cta_subtitle",
					"value" => '',
					"description" => __( "Enter the subtitle text, keep to around 20 words.", 'CQ_Custom' )
				),
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Text Colour", 'CQ_Custom' ),
					"param_name" => "text_colour",
					"value" => array( 'Select' => '', 'Dark' => 'text-dark', 'Light' => 'text-light' ),
					"description" => __( "The colour of the text, dark for light backgrounds, light for dark backgrounds?", 'CQ_Custom' )
				),
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Content Position", 'CQ_Custom' ),
					"param_name" => "content_position",
					"value" => array( 'Select' => '', 'Left' => 'left','Center' => 'center', 'Right' => 'right' ),
					"description" => __( "Where would you like the content to be positioned?", 'CQ_Custom' )
				),
                array(
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Add Countdown", "CQ_Custom" ),
                    "description"   => __("Add a countdown timer to the CTA", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "add_countdown",
                ),
                array(
                    "type" => "datefield",
                    "heading" => __("Countdown End Date", "CQ_Custom"),
                    "param_name" => "countdown_end_date",
                    "description" => __("Add the end date for the countdown.", "CQ_Custom"),
                    "dependency"    => array(
                        'element'   => 'add_countdown',
                        'value'     => 'true'
                    ),
                ),
                array(
                    'type' => 'timefield',
                    'value' => '',
                    'heading' => esc_html__( 'Countdown End Time', "CQ_Custom" ),
                    'param_name' => 'countdown_end_time',
                    "description" => __("Add the end time for the countdown.", "CQ_Custom"),
                    'dependency'    => array(
                        'element'   => 'add_countdown',
                        'value'     => 'true'
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => esc_html__( 'Countdown Timeout Message', "CQ_Custom" ),
                    'param_name' => 'countdown_timeout_message',
                    "description" => __("Add a message to display when the timer ends.", "CQ_Custom"),
                    'dependency'    => array(
                        'element'   => 'add_countdown',
                        'value'     => 'true'
                    ),
                ),
				array(
                	"type" => "vc_link",
                	"class" => "",
                	"heading" => __( "Button 1 Link and Text", 'CQ_Custom' ),
                	"param_name" => "fw_cta_button_1_link",
                	"value" => '',
					"description" => __( "Enter the URL link for this to link to.", 'CQ_Custom' )
            	),
				array(
                	"type" => "vc_link",
                	"class" => "",
                	"heading" => __( "Button 2 Link and Text", 'CQ_Custom' ),
                	"param_name" => "fw_cta_button_2_link",
                	"value" => '',
					"description" => __( "Enter the URL link for this to link to.", 'CQ_Custom' )
            	),
			)
		) );
    }
    
    public function cq_title_separator() {
        
        vc_map( array(
			"name" => __( "CQ Title Separator", "CQ_Custom" ),
			"base" => "cq_title_separator",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Title", 'CQ_Custom' ),
					"param_name" => "separator_title",
					"value" => '',
                    "admin_label" => true,
					"description" => __( "Enter the title", 'CQ_Custom' )
				),
				array(
                	"type" => "vc_link",
                	"class" => "",
                	"heading" => __( "See More Link and Text", 'CQ_Custom' ),
                	"param_name" => "see_more_link",
                	"value" => '',
					"description" => __( "Optional: Enter the link and text.", 'CQ_Custom' )
            	),
			)
		) );
    }
    
    public function cq_featured_news() {
        
        $output_categories = array('All' => '');
        $categories = get_categories();

        foreach($categories as $category) { 
            $cat_name = $category->parent == 0 ? html_entity_decode($category->name) : html_entity_decode(get_cat_name($category->parent)) . ' - ' . html_entity_decode($category->name);
            $output_categories[] = array($category->term_id, $cat_name);
        }
        
        
        $output_ad_placements = array('Select Placement' => '');
        $placements = get_option( 'advads-ads-placements' );
        
        if (is_array($placements)) {
            
            foreach ($placements as $key => $value) {
                $output_ad_placements[$value['name']] = $key;
            }
            
        }
        
        vc_map( array(
			"name" => __( "CQ Featured News", "CQ_Custom" ),
			"base" => "cq_featured_news",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Category", 'CQ_Custom' ),
                	"param_name" => "featured_post_category",
                	"value" => $output_categories,
                	"description" => __( "Choose the category the articles will be selected from", 'CQ_Custom' )
            	),
                array(
                    'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Must Include', 'CQ_Custom' ),
                    'param_name'    => 'post_id',
                    "admin_label" => true,
                    "description" => __( "Choose some articles that must be displayed", 'CQ_Custom' ),
                    'settings' => array('multiple' => true, 'sortable' => true, 'unique_values' => true),
                ),
                array(
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Suppress Sticky Posts", "CQ_Custom" ),
                    "description"   => __("Remove any sticky posts from this block. Useful if you are displaying from a particular category.", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "suppress_sticky",
                ),
                array(
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Include Ad Space", "CQ_Custom" ),
                    "description"   => __("description", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "ad_space",
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
    
    public function cq_latest_news() {
        
        $output_categories = array('All' => '');
        $categories = get_categories();

        foreach($categories as $category) { 
            $cat_name = $category->parent == 0 ? html_entity_decode($category->name) : html_entity_decode(get_cat_name($category->parent)) . ' - ' . html_entity_decode($category->name);
            $output_categories[] = array($category->term_id, $cat_name);
        }
        
        $standard_layout_array = array(1 => array('cols' => 2,
                                             'types' => array( 1 => 'overlay', 2 => 'overlay')
                                        ),
                                       2 => array('cols' => 3,
                                                  'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard')
                                            ),
                                      );
        
        $standard_layout = base64_encode(serialize($standard_layout_array));
        
        $latest_6_array = array(1 => 
                                       array('cols' => 3,
                                             'types' => array( 1 => 'overlay', 2 => 'overlay', 3 => 'overlay')
                                        ),
                                       2 => array('cols' => 3,
                                                  'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard')
                                            ),
                                      );
        
        $latest_6 = base64_encode(serialize($latest_6_array));
        
        $latest_4_overlay_array = array(1 => array('cols' => 2,
                                             'types' => array( 1 => 'overlay', 2 => 'overlay')
                                        ),
                                       2 => array('cols' => 2,
                                                  'types' => array( 1 => 'overlay', 2 => 'overlay')
                                            ),
                                      );
        
        $latest_4_overlay = base64_encode(serialize($latest_4_overlay_array));
        
        $latest_6_overlay_array = array(1 => 
                                       array('cols' => 3,
                                             'types' => array( 1 => 'overlay', 2 => 'overlay', 3 => 'overlay')
                                        ),
                                       2 => array('cols' => 3,
                                                  'types' => array( 1 => 'overlay', 2 => 'overlay', 3 => 'overlay')
                                            ),
                                      );
        
        $latest_6_overlay = base64_encode(serialize($latest_6_overlay_array));
        
        $latest_6_standard_array = array(1 => 
                                       array('cols' => 3,
                                             'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard')
                                        ),
                                       2 => array('cols' => 3,
                                                  'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard')
                                            ),
                                      );
        
        $latest_6_standard = base64_encode(serialize($latest_6_standard_array));
        
        $latest_6_new_array = array(1 => 
                                       array('cols' => 3,
                                             'types' => array( 1 => 'overlay', 2 => 'standard', 3 => 'overlay')
                                        ),
                                       2 => array('cols' => 3,
                                                  'types' => array( 1 => 'standard', 2 => 'overlay', 3 => 'standard')
                                            ),
                                      );
        
        $latest_6_new = base64_encode(serialize($latest_6_new_array));
        
        $latest_7_new_array = array(1 => 
                                       array('cols' => 1,
                                             'types' => array( 1 => 'overlay')
                                        ),
                                       2 => array('cols' => 2,
                                                  'types' => array( 1 => 'overlay', 2 => 'overlay')
                                            ),
                                      );
        
        $latest_7_new = base64_encode(serialize($latest_7_new_array));
        
        $latest_8_new_array = array(1 => array('cols' => 1,
                                             'types' => array( 1 => 'overlay')
                                        ),
                                       2 => array('cols' => 3,
                                                  'types' => array( 1 => 'overlay', 2 => 'overlay', 3 => 'overlay')
                                            ),
                                      );
        
        $latest_8_new = base64_encode(serialize($latest_8_new_array));
        
        $latest_9_new_array = array(1 => array('cols' => 1,
                                             'types' => array( 1 => 'to_side')
                                           ),
                                           2 => array('cols' => 3,
                                                      'types' => array( 1 => 'overlay', 2 => 'overlay', 3 => 'overlay')
                                            ),
                                          );
        $latest_9_new = base64_encode(serialize($latest_9_new_array));
        
        $latest_10_new_array = array(1 => array('cols' => 1,
                                             'types' => array( 1 => 'to_side')
                                           ),
                                           2 => array('cols' => 3,
                                                      'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard')
                                            ),
                                          );
        $latest_10_new = base64_encode(serialize($latest_10_new_array));
        
        $latest_11_new_array = array(1 => array('cols' => 1,
                                             'types' => array( 1 => 'overlay')
                                        ),
                                      );
        
        $latest_11_new = base64_encode(serialize($latest_11_new_array));
        
        $latest_12_new = array(1 => array('cols' => 2,
                                             'types' => array( 1 => 'standard', 2 => 'standard')
                                        ),
                                       2 => array('cols' => 3,
                                                  'types' => array( 1 => 'standard', 2 => 'standard', 3 => 'standard')
                                            ),
                                      );
        
        $latest_12_new = base64_encode(serialize($latest_12_new));
        
        vc_map( array(
			"name" => __( "CQ Latest News", "CQ_Custom" ),
			"base" => "cq_latest_news",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Category", 'CQ_Custom' ),
                	"param_name" => "latest_post_category",
                	"value" => $output_categories,
                	"description" => __( "Choose the category the articles will be selected from", 'CQ_Custom' )
            	),
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Desktop Display", 'CQ_Custom' ),
                	"param_name" => "desktop_display",
                	"value" => array('Full Width' => 'full_width',
                                     'Cards' => 'cards'),
                	"description" => __( "Choose how this element should look on desktop", 'CQ_Custom' )
            	),
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Mobile Display", 'CQ_Custom' ),
                	"param_name" => "mobile_display",
                	"value" => array('With Image' => 'with_image',
                                     'No Image' => 'no_image'),
                	"description" => __( "Choose how this element should look on mobile", 'CQ_Custom' )
            	),
                array(
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Add Load More?", "CQ_Custom" ),
                    "description"   => __("Add the option to load more articles.", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "load_more",
                ),
                /*array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Layout", 'CQ_Custom' ),
                	"param_name" => "latest_post_layout",
                	"value" => array('Select Layout' => '', 
                                     '2 top 3 bottom' => $standard_layout, 
                                     '3 top 3 bottom' => $latest_6, 
                                     '2 top 2 bottom all overlay type' => $latest_4_overlay, 
                                     '3 top 3 bottom all overlay type' => $latest_6_overlay, 
                                     '3 top 3 bottom all standard type' => $latest_6_standard, 
                                     'new layout' => $latest_6_new,
                                     '1 top 2 bottom all overlay type' => $latest_7_new,
                                     '1 top 3 bottom all overlay type' => $latest_8_new,
                                     '1 top 3 bottom - top to side' => $latest_9_new,
                                     '1 top 3 bottom - top to side - bottom standard' => $latest_10_new,
                                     'Single Row Overlay' => $latest_11_new,
                                     '2 top 3 bottom all standard type' => $latest_12_new
                                    ),
                	"description" => __( "Choose the layout for this element.", 'CQ_Custom' )
            	),
				array(
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Include Ad Space", "CQ_Custom" ),
                    "description"   => __("description", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "ad_space",
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
				),*/
			)
		) );
    }
    
    public function cq_latest_digital_issues() {
        
        $output_publications = array('All' => '');
        $publications = get_terms( array( 
            'taxonomy' => 'cq_publications',
            'parent'   => 0
        ) );
        
        foreach ($publications as $publication) {
            $output_publications[$publication->name] = $publication->term_id;
        }
        
        vc_map( array(
			"name" => __( "CQ Latest Digital Issues", "CQ_Custom" ),
			"base" => "cq_latest_digital_issues",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Number to show", 'CQ_Custom' ),
					"param_name" => "to_show",
					"value" => array( 'Select' => '', '3' => '3','4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8' ),
					"description" => __( "Select how many to show in the slider?", 'CQ_Custom' )
				),
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Publication", 'CQ_Custom' ),
                	"param_name" => "publication",
                	"value" => $output_publications,
                	"description" => __( "Choose the publication the digital issues will be selected from", 'CQ_Custom' )
            	),
			)
		) );
    }
    
    public function cq_category_carousel() {
        
        vc_map( array(
            "name" => __( "CQ Category Carousel", 'CQ_Custom' ),
            "as_parent" => array( 'only' => 'cq_category_carousel_item' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"is_container" => true,
			"content_element" => true,
			"js_view" => 'VcColumnView',
            "base" => "cq_category_carousel",
            "description" => "Carousel of categories that have images",
            "class" => "",
            "icon" => "",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
       ) );
        
       /*if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_Cq_Category_Carousel extends WPBakeryShortCodesContainer {}
		}*/
    }
    
    public function cq_category_carousel_item() {
	
		vc_map( array(
			"name" => __( "CQ Category Carousel Item", "CQ_Custom" ),
			"base" => "cq_category_carousel_item",
			"content_element" => true,
			"as_child" => array( 'only' => 'cq_category_carousel' ),
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Category Name', 'alispx' ),
                    'param_name'    => 'category_id',
                    'settings' => array('multiple' => false, 'sortable' => true, 'unique_values' => true),
                    'admin_label' => true,
            	),
			)
		) );
	
		
		/*if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Cq_Category_Carousel_Item extends WPBakeryShortCode {}
		}*/
	}
    
    public function cq_category_grid() {
        
        vc_map( array(
            "name" => __( "CQ Category Grid", 'CQ_Custom' ),
            "as_parent" => array( 'only' => 'cq_category_grid_item' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"is_container" => true,
			"content_element" => true,
			"js_view" => 'VcColumnView',
            "base" => "cq_category_grid",
            "description" => "Grid view of categories that have images",
            "class" => "",
            "icon" => "",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
       ) );
        
    }
    
    public function cq_category_grid_item() {
	
		vc_map( array(
			"name" => __( "CQ Category Grid Item", "CQ_Custom" ),
			"base" => "cq_category_grid_item",
			"content_element" => true,
			"as_child" => array( 'only' => 'cq_category_grid' ),
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Category Name', 'alispx' ),
                    'param_name'    => 'category_id',
                    'settings' => array('multiple' => false, 'sortable' => true, 'unique_values' => true),
                    'admin_label' => true,
            	),
			)
		) );
	
	}
    
    public function cq_latest_issue() {
        
        $output_publications = array('All' => '');
        $publications = get_terms( array( 
            'taxonomy' => 'cq_publications',
            'parent'   => 0
        ) );
        
        foreach ($publications as $publication) {
            $output_publications[$publication->name] = $publication->term_id;
        }
        
        vc_map( array(
			"name" => __( "CQ Latest Issue", "CQ_Custom" ),
			"base" => "cq_latest_issue",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Publication", 'CQ_Custom' ),
                	"param_name" => "publication",
                	"value" => $output_publications,
                	"description" => __( "Choose the publication the digital issues will be selected from", 'CQ_Custom' )
            	),
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Display Style", 'CQ_Custom' ),
                	"param_name" => "style",
                	"value" => array('Compact' => 'compact', 'Large' => 'large'),
                	"description" => __( "Choose the style for this section, compact is cover only.", 'CQ_Custom' )
            	),
			)
		) );
    }
    
    public function cq_in_page_menu() {
        
        $output_menus = array();
        $menus = wp_get_nav_menus();
        
        foreach ($menus as $menu) {
            $output_menus[$menu->name] = $menu->term_id;
        }
        
        vc_map( array(
			"name" => __( "CQ In Page Menu", "CQ_Custom" ),
			"base" => "cq_in_page_menu",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Publication", 'CQ_Custom' ),
                	"param_name" => "menu_id",
                	"value" => $output_menus,
                	"description" => __( "Choose the menu to display", 'CQ_Custom' )
            	),
			)
		) );
    }
    
    public function cq_vc_newsletter_block() {
        
        vc_map( array(
			"name" => __( "CQ Newsletter Subscribe Block", "CQ_Custom" ),
			"base" => "cq_newsletter_block",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
		) );
    }
    
    public function cq_latest_post_row() {
	
        global $wpdb;

        $output_categories = array('All' => '');
        $categories = get_categories();

        foreach($categories as $category) { 
            $output_categories[] = array($category->term_id, $category->name);
        }
	
		vc_map( array(
			"name" => __( "CQ latest post row", "CQ_Custom" ),
			"base" => "cq_latest_post_row",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Number to show", 'CQ_Custom' ),
					"param_name" => "to_show",
					"value" => array( 'Select' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4' ),
					"description" => __( "Select how many to show in this row?", 'CQ_Custom' )
				),
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Style", 'CQ_Custom' ),
					"param_name" => "style",
					"value" => array( 'Select' => '', 'Standard' => 'standard', 'Overlay' => 'overlay', 'Vertical (max 3 articles)' => 'vertical' ),
					"description" => __( "Select how many to show in this row?", 'CQ_Custom' )
				),
				array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Category", 'CQ_Custom' ),
                	"param_name" => "latest_post_category",
                	"value" => $output_categories,
                	"description" => __( "Choose the category the articles will be selected from", 'CQ_Custom' )
            	)
			)
		) );
	}
    
    public function cq_category_link_block() {
        
        global $wpdb;

        $output_categories = array();
        $categories = get_categories(array(
                                    'orderby' => 'name',
                                    'order'   => 'ASC',
                                    'parent'  => 0,
                                        )
                                    );

        foreach($categories as $category) { 
            $output_categories[] = array($category->term_id, html_entity_decode($category->name));
            $sub_categories = get_categories(array(
                                    'orderby' => 'name',
                                    'order'   => 'ASC',
                                    'parent'  => $category->term_id,
                                        )
                                    );
            if ($sub_categories) {
                foreach($sub_categories as $sub_category) {
                    $output_categories[] = array($sub_category->term_id, html_entity_decode('- ' . $sub_category->name));
                }
            }
        }
        
        vc_map( array(
			"name" => __( "CQ Category Link Block", "CQ_Custom" ),
			"base" => "cq_category_link_block",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Category", 'CQ_Custom' ),
                	"param_name" => "category_id",
                	"value" => $output_categories,
                	"description" => __( "Choose the category the articles will be selected from", 'CQ_Custom' )
            	),
                array(
                    "type" => "colorpicker",
                    "param_name" => "background_color",
                    "heading" => __( "Select Background Color", 'CQ_Custom' ),
                    "label" => "Background Color",
                    "admin_label" => true,
                ),
			)
		) );
        
    }
    
    public function cq_publication_box() {
	
		vc_map( array(
			"name" => __( "CQ Publication Box", "CQ_Custom" ),
			"base" => "cq_publication_box",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
					"type" => "attach_image",
					"heading" => __( "Logo Image", "CQ_Custom" ),
					"param_name" => "cq_pub_logo",
					"description" => __( "Select a logo", "CQ_Custom" )
				),
                array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Publication Title", 'CQ_Custom' ),
					"param_name" => "title",
					"value" => '',
                    "label" => "Title",
                    "admin_label" => true,
					"description" => __( "Enter the title", 'CQ_Custom' )
				),
                array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Publication Description", 'CQ_Custom' ),
					"param_name" => "description",
					"value" => '',
					"description" => __( "Enter a short description", 'CQ_Custom' )
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Style", 'CQ_Custom' ),
					"param_name" => "style",
					"value" => array( 'Select' => '', 'Small' => 'pub_small', 'Large' => 'pub_large' ),
					"description" => __( "Select the style", 'CQ_Custom' )
				),
                array(
                    "type" => "colorpicker",
                    "param_name" => "background_color",
                    "heading" => __( "Select Background Color", 'CQ_Custom' ),
                    "label" => "Background Color",
                    "admin_label" => true,
                ),
                array(
                	"type" => "vc_link",
                	"class" => "",
                	"heading" => __( "Button Link and Text", 'CQ_Custom' ),
                	"param_name" => "see_more_link",
                	"value" => '',
					"description" => __( "Optional: Enter the link and text.", 'CQ_Custom' )
            	),
                array(
                    "type" => "colorpicker",
                    "param_name" => "button_colour",
                    "heading" => __( "Select Button Color", 'CQ_Custom' ),
                    "label" => "Button Colour",
                    "admin_label" => true,
                ),
                array(
                    "type" => "colorpicker",
                    "param_name" => "button_text_colour",
                    "heading" => __( "Select Button Text Color", 'CQ_Custom' ),
                    "label" => "Button Colour",
                    "admin_label" => true,
                ),
			)
		) );
	}
    
    public function cq_add_container_row() {
        vc_add_param("vc_row", array(
            "type" => "dropdown",
            "class" => "",
            "param_name" => "full_width",
            "value" => array(
                "Default" => "",
                "In Container" => "in_container",
                "Stretch Row" => "stretch_row",
                "Stretch Row and Content" => "stretch_row_content",
                "Stretch row and content (no paddings)" => "stretch_row_content_no_spaces"
            )
        ));
    }
    
    function cq_vc_events_list() {
        
        $output_categories = array('All' => '');
	
		if (isset($_POST['action']) && $_POST['action'] == 'vc_edit_form') {
			$categories = get_terms( 'event-category', array('hide_empty' => false) );
		
			foreach($categories as $category) { 
				$output_categories[] = array($category->term_id, $category->name);
			}
        }
	
        vc_map( array(
            "name" => __( "CQ Events List", 'CQ_Custom' ),
            "base" => "cq_events_list",
            "description" => "Events List",
            "class" => "",
            "icon" => "",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Max Events", 'CQ_Custom' ),
                    "param_name" => "max_events",
                    'value'       => array(
                        '1'   => '1',
                        '3'   => '3',
                        '5' => '5',
                        '9999'  => 'All'
                    ),
                    "description" => __( "Maximum number of events to show", 'CQ_Custom' )
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __( "Future Only", 'CQ_Custom' ),
                    "param_name" => "future_only",
                    "value" =>  __( "1", 'CQ_Custom' ),
                    "description" => __( "Show only events in the future", 'CQ_Custom' )
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Select Category", 'CQ_Custom' ),
                    "param_name" => "category",
                    "value" => $output_categories,
                    "description" => __( "Input number of upcoming auctions to show.", 'CQ_Custom' )
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => __( "Border Color", 'CQ_Custom' ),
                    "param_name" => "border_color",
                    "value" => '',
                    "description" => __( "Choose the colour border around the events list", 'CQ_Custom' )
                )
            )
       ) );
    }
    
    function cq_vc_post_timeline() {
        
        $output_categories = array('All' => '');
	
		if (isset($_POST['action']) && $_POST['action'] == 'vc_edit_form') {
			$categories = get_terms( 'category', array('hide_empty' => true) );
		
			foreach($categories as $category) { 
				$output_categories[] = array($category->term_id, $category->name);
			}
        }
	
        vc_map( array(
            "name" => __( "CQ Post Timeline", 'CQ_Custom' ),
            "base" => "cq_post_timeline",
            "description" => "Post Timeline",
            "class" => "",
            "icon" => "",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Max Posts", 'CQ_Custom' ),
					"param_name" => "max_posts",
					"value" => '10',
					"description" => __( "Maximum number of items to show", 'CQ_Custom' )
				),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Select Category", 'CQ_Custom' ),
                    "param_name" => "category",
                    "value" => $output_categories,
                ),
            )
       ) );
    }
    
    public function cq_single_ad_space() {
        
        vc_map( array(
			"name" => __( "CQ Single Ad Space", "CQ_Custom" ),
			"base" => "cq_single_ad_space",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
                array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Ad Content", 'CQ_Custom' ),
					"param_name" => "ad_shortcode",
					"value" => '',
                    "label" => "Ad Shortcode",
                    "admin_label" => true,
					"description" => __( "Enter the ad placement id.", 'CQ_Custom' ),
				),
			)
		) );
        
    }
    
    public function cq_single_region() {
        
        $output_regions = array('All' => '');
        $regions = get_terms( array( 
            'taxonomy' => 'cruise-type',
        ) );
        
        foreach ($regions as $region) {
            $output_regions[$region->name] = $region->term_id;
        }
        
        vc_map( array(
			"name" => __( "Single Region/Cruise Type", "CQ_Custom" ),
			"base" => "cq_single_region",
			"category" => __( 'UDG', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Style", 'CQ_Custom' ),
                	"param_name" => "style",
                	"value" => array( 'Select' => '', 'Large/Full Width' => 'large', 'Compact' => 'compact'),
                	"description" => __( "Choose the style of the box to display, large is better suited to full width. Use compact if displaying in columns", 'CQ_Custom' )
            	),
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Orientation", 'CQ_Custom' ),
                	"param_name" => "orientation",
                	"value" => array( 'Select' => '', 'Image on Left' => 'left', 'Image on right' => 'right'),
                    "dependency" => array('element' => 'style', 'value' => 'large'),
                	"description" => __( "Choose which way round to display the image and the text", 'CQ_Custom' )
            	),
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Region", 'CQ_Custom' ),
                	"param_name" => "region_id",
                	"value" => $output_regions,
                	"description" => __( "Choose the region or cruise type to display", 'CQ_Custom' )
            	),
			)
		) );
    }
    
    public function cq_featured_regions() {
        
        vc_map( array(
            "name" => __( "CQ Featured Regions", 'CQ_Custom' ),
            "as_parent" => array( 'only' => 'cq_featured_regions_item' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"is_container" => true,
			"content_element" => true,
			"js_view" => 'VcColumnView',
            "base" => "cq_featured_regions",
            "description" => "Selection of regions to feature",
            "class" => "",
            "icon" => "",
            "category" => __( 'UDG', 'CQ_Custom' ),
            "params" => array(
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
       ) );
    }
    
    public function cq_featured_regions_item() {
	
		vc_map( array(
			"name" => __( "CQ Featured Regions Item", "CQ_Custom" ),
			"base" => "cq_featured_regions_item",
			"content_element" => true,
			"as_child" => array( 'only' => 'cq_featured_regions' ),
			"category" => __( 'UDG', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Region Name', 'CQ_Custom' ),
                    'param_name'    => 'region_id',
                    'settings' => array('multiple' => false, 'sortable' => true, 'unique_values' => true),
                    'admin_label' => true,
            	),
			)
		) );
	}
    
    public function cq_featured_destinations() {
        
        vc_map( array(
            "name" => __( "CQ Featured Destinations", 'CQ_Custom' ),
            "as_parent" => array( 'only' => 'cq_featured_destinations_item' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"is_container" => true,
			"content_element" => true,
			"js_view" => 'VcColumnView',
            "base" => "cq_featured_destinations",
            "description" => "Selection of destinations to feature",
            "class" => "",
            "icon" => "",
            "category" => __( 'UDG', 'CQ_Custom' ),
            "params" => array(
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
       ) );
    }
    
    public function cq_featured_destinations_item() {
	
		vc_map( array(
			"name" => __( "CQ Featured Destinations Item", "CQ_Custom" ),
			"base" => "cq_featured_destinations_item",
			"content_element" => true,
			"as_child" => array( 'only' => 'cq_featured_destinations' ),
			"category" => __( 'UDG', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Destination Name', 'CQ_Custom' ),
                    'param_name'    => 'destination_id',
                    'settings' => array('multiple' => false, 'sortable' => true, 'unique_values' => true),
                    'admin_label' => true,
            	),
			)
		) );
	}
    
    public function cq_featured_cruise_lines() {
        
        vc_map( array(
            "name" => __( "CQ Featured Cruise Lines", 'CQ_Custom' ),
            "as_parent" => array( 'only' => 'cq_featured_cruise_lines_item' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"is_container" => true,
			"content_element" => true,
			"js_view" => 'VcColumnView',
            "base" => "cq_featured_cruise_lines",
            "description" => "Selection of cruise lines to feature",
            "class" => "",
            "icon" => "",
            "category" => __( 'UDG', 'CQ_Custom' ),
            "params" => array(
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
       ) );
    }
    
    public function cq_featured_cruise_lines_item() {
	
		vc_map( array(
			"name" => __( "CQ Featured Cruise Lines Item", "CQ_Custom" ),
			"base" => "cq_featured_cruise_lines_item",
			"content_element" => true,
			"as_child" => array( 'only' => 'cq_featured_cruise_lines' ),
			"category" => __( 'UDG', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Cruise Line Name', 'CQ_Custom' ),
                    'param_name'    => 'cruise_line_id',
                    'settings' => array('multiple' => false, 'sortable' => true, 'unique_values' => true),
                    'admin_label' => true,
            	),
			)
		) );
	}
    
    public function cq_featured_cruise_ships() {
        
        vc_map( array(
            "name" => __( "CQ Featured Cruise Ships", 'CQ_Custom' ),
            "as_parent" => array( 'only' => 'cq_featured_cruise_ships_item' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"is_container" => true,
			"content_element" => true,
			"js_view" => 'VcColumnView',
            "base" => "cq_featured_cruise_ships",
            "description" => "Selection of cruise ships to feature",
            "class" => "",
            "icon" => "",
            "category" => __( 'UDG', 'CQ_Custom' ),
            "params" => array(
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
       ) );
    }
    
    public function cq_featured_cruise_ships_item() {
	
		vc_map( array(
			"name" => __( "CQ Featured Cruise Ships Item", "CQ_Custom" ),
			"base" => "cq_featured_cruise_ships_item",
			"content_element" => true,
			"as_child" => array( 'only' => 'cq_featured_cruise_ships' ),
			"category" => __( 'UDG', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	'type'          => 'autocomplete',
                    'class'         => '',
                    'heading'       => esc_html__( 'Cruise Ship Name', 'CQ_Custom' ),
                    'param_name'    => 'cruise_ship_id',
                    'settings' => array('multiple' => false, 'sortable' => true, 'unique_values' => true),
                    'admin_label' => true,
            	),
			)
		) );
	}
    
    public function cq_udg_full_width_block() {
	
		vc_map( array(
			"name" => __( "CQ UDG Full Width Block", "CQ_Custom" ),
			"base" => "cq_udg_full_width_block",
			"category" => __( 'UDG', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Orientation", 'CQ_Custom' ),
                	"param_name" => "orientation",
                	"value" => array( 'Select' => '', 'Image on Left' => 'left', 'Image on right' => 'right'),
                	"description" => __( "Choose which way round to display the image and the text", 'CQ_Custom' )
            	),
				array(
                	'type'          => 'textfield',
                    'class'         => '',
                    'heading'       => esc_html__( 'Title', 'CQ_Custom' ),
                    'param_name'    => 'title',
                    'admin_label' => true,
            	),
                array(
                	'type'          => 'textarea',
                    'class'         => '',
                    'heading'       => esc_html__( 'Description', 'CQ_Custom' ),
                    'param_name'    => 'description',
            	),
                array(
                	'type'          => 'vc_link',
                    'class'         => '',
                    'heading'       => esc_html__( 'Image/Button Link and Text', 'CQ_Custom' ),
                    'param_name'    => 'button_link',
            	),
                array(
                	'type'          => 'attach_image',
                    'class'         => '',
                    'heading'       => esc_html__( 'Image', 'CQ_Custom' ),
                    'param_name'    => 'image',
            	),
			)
		) );
	}
    
    public function cq_speaker_list() {
	
        global $wpdb;

        $output_carousels = array();

        $cat_args = array(
            'orderby'       => 'term_id', 
            'order'         => 'ASC',
            'hide_empty'    => true, 
        );

        $categories = get_terms('cq_speaker_category', $cat_args);

        $output_categories[] = array('', 'All Categories');

        foreach($categories as $category) { 
            $output_categories[] = array($category->term_id, $category->name);
        }

        vc_map( array(
            "name" => __("CQ Speakers List", "CQ_Custom"),
            "base" => "cq_speaker_list",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Select which sessions to display from", 'CQ_Custom' ),
                    "param_name" => "category_id",
                    'admin_label' => true,
                     "value" => $output_categories,
                    "description" => __( "Choose the session to display from", 'CQ_Custom' )
                    ),
                array(
                    "type" => "textfield",
                    "heading" => __("Extra class name", "CQ_Custom"),
                    "param_name" => "add_class",
                    "description" => __("If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", "CQ_Custom")
                    ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Number of images to display", 'CQ_Custom' ),
                    "param_name" => "no_items",
                     "value" => array( 0,1,2,3,4,5,6,7,8,9,10),
                    "description" => __( "Choose the number of speakers to display at once. Select 0 for all", 'CQ_Custom' )
                    ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Carousel ordering", 'CQ_Custom' ),
                    "param_name" => "speaker_order",
                     "value" => array( 'Select Order' => '', 'Ascending' => 'ASC', 'Descending' => 'DESC', 'Random' => 'rand'),
                    "description" => __( "Choose the ordering of the images", 'CQ_Custom' )
                    ),
                )
            ) 
        );

    }
    
    public function cq_add_vc_time( $settings, $value ) {
        return '<div class="timefield_block">'
           .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
           esc_attr( $settings['param_name'] ) . ' ' .
           esc_attr( $settings['type'] ) . '_field" type="time" value="' . esc_attr( $value ) . '" />' .
           '</div>'; // This is html markup that will be outputted in content elements edit form
    }

    public function cq_add_vc_date( $settings, $value ) {
        return '<div class="datefield_block">'
           .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
           esc_attr( $settings['param_name'] ) . ' ' .
           esc_attr( $settings['type'] ) . '_field" type="date" value="' . esc_attr( $value ) . '" />' .
           '</div>'; // This is html markup that will be outputted in content elements edit form
    }

    public function cq_custom_agenda_day() {

        $args = array('posts_per_page' => -1,
                      'post_status' => 'publish',
                      'post_type' => 'cq_speakers',
                      'order' => 'ASC',
                      'orderby' => 'title');

        $speakers = get_posts($args);

        $speaker_options = array(array('', 'Select Speaker'));

        foreach ($speakers as $speaker) {
            $speaker_options[] = array($speaker->ID, $speaker->post_title);
        }

        vc_map( array(
                "name" => __("CQ Agenda", "CQ_Custom"),
                "base" => "cq_custom_agenda_day",
                "category" => __( 'by CQ', 'CQ_Custom' ),
                "params" => array(
                // add params same as with any other content element
                    array(
                        'type' => 'param_group',
                        'value' => '',
                        'heading'         => esc_html__( 'Agenda Days', 'elem' ),
                        'param_name' => 'agenda_day',
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => __("Title", "CQ_Custom"),
                                "param_name" => "title",
                                "description" => __("Add a title for this container.", "my-text-domain")
                            ),
                            array(
                                "type" => "datefield",
                                "heading" => __("Date", "CQ_Custom"),
                                "param_name" => "date",
                                "description" => __("Add a title for this container.", "my-text-domain")
                            ),
                            array(
                                'type' => 'param_group',
                                'value' => '',
                                'heading'         => esc_html__( 'Agenda Items', 'elem' ),
                                'param_name' => 'agenda_items',
                                'params' => array(
                                    array(
                                      'type' => 'timefield',
                                      'value' => '',
                                      'heading' => esc_html__( 'Start Time', 'elem' ),
                                      'param_name' => 'start_time',
                                    ),
                                    array(
                                      'type' => 'timefield',
                                      'value' => '',
                                      'heading' => esc_html__( 'End Time', 'elem' ),
                                      'param_name' => 'end_time',
                                    ),
                                    array(
                                      'type' => 'textfield',
                                      'value' => '',
                                      'heading' => esc_html__( 'Session Title', 'elem' ),
                                      'param_name' => 'session_title',
                                    ),
                                    array(
                                      'type' => 'textarea',
                                      'value' => '',
                                      'heading' => esc_html__( 'Synopsis', 'elem' ),
                                      'param_name' => 'synopsis',
                                      'description' => 'Add a brief synopsis, but don\'t make it too long as it\'ll look weird on the front end!'
                                    ),
                                     array(
                                        'type' => 'param_group',
                                        'value' => '',
                                        'heading'         => esc_html__( 'Speaker(s)', 'elem' ),
                                        'param_name' => 'speakers',
                                        'params' => array(
                                            array(
                                                "type" => "dropdown",
                                                "class" => "",
                                                "heading" => __( "Select Speaker", 'CQ_Custom' ),
                                                "param_name" => "speaker",
                                                "value" => $speaker_options,
                                                "description" => __( "Choose the speaker", 'CQ_Custom' )
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),                    
                    ),
                     array(
                        "type" => "textfield",
                        "heading" => __("Extra class name", "CQ_Custom"),
                        "param_name" => "add_class",
                        "description" => __("If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", "my-text-domain")
                    ),
                )
            )   
        );
    }
    
    public function cq_standard_carousel() {
	
        global $wpdb;

        $output_carousels = array();

        $cat_args = array(
            'orderby'       => 'term_id', 
            'order'         => 'ASC',
            'hide_empty'    => true, 
        );

        $carousels = get_terms('cq_carousels', $cat_args);

        foreach($carousels as $carousel) { 
            $output_carousels[] = array($carousel->term_id, $carousel->name);
        }

        vc_map( array(
            "name" => __("CQ Standard Carousel", "CQ_Custom"),
            "base" => "cq_standard_carousel",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
            // add params same as with any other content element
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Select carousel to display", 'CQ_Custom' ),
                    "param_name" => "carousel_id",
                    'admin_label' => true,
                     "value" => $output_carousels,
                    "description" => __( "Choose the Carousel to display", 'CQ_Custom' )
                    ),
                array(
                    "type" => "textfield",
                    "heading" => __("Extra class name", "CQ_Custom"),
                    "param_name" => "add_class",
                    "description" => __("If you wish to style this particular content element differently, then use this field to add a class name and then refer to it in your css file.", "CQ_Custom")
                    ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Number of images to display", 'CQ_Custom' ),
                    "param_name" => "no_items",
                    "value" => array( 1,2,3,4,5,6,7,8,9,10),
                    "description" => __( "Choose the number of images to display at once", 'CQ_Custom' )
                    ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Carousel ordering", 'CQ_Custom' ),
                    "param_name" => "carousel_order",
                     "value" => array( 'Select Order' => '', 'Ascending' => 'ASC', 'Descending' => 'DESC', 'Random' => 'rand'),
                    "description" => __( "Choose the ordering of the images", 'CQ_Custom' )
                    ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Carousel ordering", 'CQ_Custom' ),
                    "param_name" => "carousel_order",
                     "value" => array( 'Select Order' => '', 'Ascending' => 'ASC', 'Descending' => 'DESC', 'Random' => 'rand'),
                    "description" => __( "Choose the ordering of the images", 'CQ_Custom' )
                    ),
                array(
                    "type"          => "checkbox",
                    "admin_label"   => true,
                    "weight"        => 10,
                    "heading"       => __( "Enable Auto-Scroll", "CQ_Custom" ),
                    "description"   => __("The carousel will scroll automatically, with no user interaction", "CQ_Custom"),
                    "value"         => '',
                    "param_name"    => "autoscroll",
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Scroll every X seconds", 'CQ_Custom' ),
                    "param_name" => "scroll_timing",
                    "value" => array( 1,2,3,4,5,6,7,8,9,10),
                    "description" => __( "Select the number of seconds between scrolling.", 'CQ_Custom' )
                    ),
                )
            ) 
        );

    }
    
    public function cq_grid_links() {
        
        vc_add_shortcode_param( 'file_picker', array($this, 'file_picker_settings_field'), WP_PLUGIN_DIR . '/plugin-name/assets/js/cq-admin-js.js' );
        
        vc_map( array(
            "name" => __( "CQ Grid Links", 'CQ_Custom' ),
            "as_parent" => array( 'only' => 'cq_grid_links_item' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"is_container" => true,
			"content_element" => true,
			"js_view" => 'VcColumnView',
            "base" => "cq_grid_links",
            "description" => "A grid of links or downloadable items",
            "class" => "",
            "icon" => "",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Grid Style", 'CQ_Custom' ),
                    "param_name" => "grid_style",
                    "value" => array('cards' => 'Card Style', 'large' => 'Full Width Style' ),
                    "description" => __( "Select the format for this section", 'CQ_Custom' )
                ),
                array(
                        "type" => "textfield",
                        "heading" => __( "Extra class name", "CQ_Custom" ),
                        "param_name" => "el_class",
                        "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'CQ_Custom' )
                    ),
            )
       ) );
    }
    
    public function cq_grid_links_item() {
	
		vc_map( array(
			"name" => __( "CQ Grid Links Item", "CQ_Custom" ),
			"base" => "cq_grid_links_item",
			"content_element" => true,
			"as_child" => array( 'only' => 'cq_grid_links' ),
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
				array(
                	'type'          => 'attach_image',
                    'class'         => '',
                    'heading'       => esc_html__( 'Image', 'CQ_Custom' ),
                    'param_name'    => 'image_id',
                    'admin_label' => true,
                    'description'   => __("If you are using to download a PDF, by leaving this blank, the cover of the PDF will be used.", "CQ_Custom"),
            	),
                array(
                    "type" => "textfield",
                    "heading" => __("Title", "CQ_Custom"),
                    "param_name" => "title",
                    "description" => __("Add a title for this item.", "CQ_Custom")
                ),
                array(
                	'type'          => 'textarea',
                    'class'         => '',
                    'heading'       => esc_html__( 'Description', 'CQ_Custom' ),
                    'param_name'    => 'description',
            	),
                array(
                    "type"          => "dropdown",
                    "admin_label"   => true,
                    "heading"       => __( "Is Download Link", "CQ_Custom" ),
                    "description"   => __("Select if this is a download link", "CQ_Custom"),
                     "value" => array('Standard Link' => 'no', 'Download Link' => 'yes' ),
                    "param_name"    => 'is_download',
                ),
                array(
                	"type" => "vc_link",
                	"class" => "",
                	"heading" => __( "Link Location", 'CQ_Custom' ),
                	"param_name" => "link",
                	"value" => '',
					"dependency"    => array(
                        'element'   => 'is_download',
                        'value'     => 'no',
                    ),
            	),
                array(
                	"type" => "file_picker",
                	"class" => "",
                	"heading" => __( "Attach Media", 'CQ_Custom' ),
                	"param_name" => "file_picker",
                	"value" => '',
					"dependency"    => array(
                        'element'   => 'is_download',
                        'value'     => 'yes'
                    ),
            	),
                
			)
		) );
	}
    
    public function file_picker_settings_field( $settings, $value ) {
        $output = '';
        $select_file_class = '';
        $remove_file_class = ' hidden';
        $attachment_url = wp_get_attachment_url( $value );
        if ( $attachment_url ) {
          $select_file_class = ' hidden';
          $remove_file_class = '';
        }
        $output .= '<div class="file_picker_block">
                      <div class="' . esc_attr( $settings['type'] ) . '_display">' .
                        $attachment_url .
                      '</div>
                      <input type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
                       esc_attr( $settings['param_name'] ) . ' ' .
                       esc_attr( $settings['type'] ) . '_field" value="' . esc_attr( $value ) . '" />
                      <button class="button file-picker-button' . $select_file_class . '">Select File</button>
                      <button class="button file-remover-button' . $remove_file_class . '">Remove File</button>
                    </div>
                    ';
        return $output;
    }
    
    /* BOF Latest Jobs */
    public function cq_latest_jobs_row() {
	
        global $wpdb;    
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dir_bpa_job_functions", ARRAY_A);
        $jobType_options = array(array('', 'Select Job Type'));

        foreach ($results as $jobtype) {
            $jobType_options[] = array($jobtype['id'], $jobtype['type']);
        }
		vc_map( array(
			"name" => __( "CQ latest Jobs row", "CQ_Custom" ),
			"base" => "cq_latest_jobs_row",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Number to show", 'CQ_Custom' ),
					"param_name" => "to_show",
					"value" => array( 'Select' => '', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5'=>'5','6'=>'6', '7'=>'7', '8'=>'8', '9'=>'9' ),
					"description" => __( "Select how many to show in this row?", 'CQ_Custom' )
				),
				array(
                	"type" => "dropdown",
                	"class" => "",
                	"heading" => __( "Job Type", 'CQ_Custom' ),
                	"param_name" => "latest_jobs_category",
                	"value" => $jobType_options,
                	"description" => __( "Choose the Job Type the articles will be selected from", 'CQ_Custom' )
                ),
                array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __( "Columns", 'CQ_Custom' ),
					"param_name" => "column_show",
					"value" => array( 'Select' => '2', '1' => '1', '2' => '2', '3' => '3' ),
					"description" => __( "Select number of columns", 'CQ_Custom' )
				)
			)
		) );
	}
    /* EOF Latest Jobs */
    /* BOF call to action */
    public function cq_call_to_action() {
		vc_map( array(
			"name" => __( "CQ Call to Action", "CQ_Custom" ),
			"base" => "cq_call_to_action",
			"category" => __( 'by CQ', 'CQ_Custom' ),
			"params" => array(
				// add params same as with any other content element
                array(
                    "type" => "textfield",
                    "heading" => __("Title", "CQ_Custom"),
                    "param_name" => "cq_heading",
                    'value' => esc_html__( '', 'CQ_Custom' ),
                    "description" => __("Add a title for this item.", "CQ_Custom")
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Background color', 'CQ_Custom' ),
                    'param_name' => 'custom_background',
                    'description' => esc_html__( 'Select custom background color.', 'CQ_Custom' ),
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array( 'custom' ),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Text color', 'CQ_Custom' ),
                    'param_name' => 'custom_text',
                    'description' => esc_html__( 'Select custom text color.', 'CQ_Custom' ),
                    'dependency' => array(
                        'element' => 'style',
                        'value' => array( 'custom' ),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Content', 'CQ_Custom' ),
                    'param_name' => 'cq_content',
                    'value' => esc_html__( '', 'CQ_Custom' ),
                    // 'value' => esc_html__( '' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Width', 'CQ_Custom' ),
                    'param_name' => 'cq_width_screen',
                    'value' => array(
                        '100%' => '',
                        '90%' => 'xl',
                        '80%' => 'lg',
                        '70%' => 'md',
                        '60%' => 'sm',
                        '50%' => 'xs',
                    ),
                    'description' => esc_html__( 'Select call to action width (percentage).', 'CQ_Custom' ),
                ),
                array(
					"type" => "attach_image",
					"heading" => __( "Background Image", "CQ_Custom" ),
					"param_name" => "cq_fw_takeover_img",
					"description" => __( "Select a background image for this element", "CQ_Custom" )
				),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Text on the button', 'CQ_Custom' ),
                    'param_name' => 'cq_button_text',
                    'value' => esc_html__( 'Text on the button', 'CQ_Custom' ),
                    'description' => esc_html__( 'Add text on the button.', 'CQ_Custom' ),
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__( 'URL (Link)', 'CQ_Custom' ),
                    'param_name' => 'cq_link',
                    'description' => esc_html__( 'Add link to button (Important: adding link automatically adds button).', 'CQ_Custom' ),
                ),
			)
		) );
	}
    /* EOF call to action */
    
    public function cq_vc_fullevents_list() {
        
        $output_categories = array('', 'All');
	
		if (isset($_POST['action']) && $_POST['action'] == 'vc_edit_form') {
			$categories = get_terms( 'event-category', array('hide_empty' => false) );
		
			foreach($categories as $category) { 
				$output_categories[] = array($category->term_id, $category->name);
			}
        }
	
        vc_map( array(
            "name" => __( "CQ Events Full List", 'CQ_Custom' ),
            "base" => "cq_fullevents_list",
            "description" => "Events Full List",
            "class" => "eventfulllistEvent",
            "icon" => "",
            "category" => __( 'by CQ', 'CQ_Custom' ),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Max Events", 'CQ_Custom' ),
                    "param_name" => "max_events",
                    'value'       => array(
                        '1'   => '1',
                        '3'   => '3',
                        '5' => '5',
                        'All'  => '9999'
                    ),
                    "description" => __( "Maximum number of events to show", 'CQ_Custom' )
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __( "Future Only", 'CQ_Custom' ),
                    "param_name" => "future_only",
                    "value" =>  __( "1", 'CQ_Custom' ),
                    "description" => __( "Show only events in the future", 'CQ_Custom' )
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __( "Select Category", 'CQ_Custom' ),
                    "param_name" => "category",
                    "value" => $output_categories,
                    "description" => __( "Input number of upcoming auctions to show.", 'CQ_Custom' )
                ),
                array(
                    "type" => "colorpicker",
                    "class" => "",
                    "heading" => __( "Border Color", 'CQ_Custom' ),
                    "param_name" => "border_color",
                    "value" => '',
                    "description" => __( "Choose the colour border around the events list", 'CQ_Custom' )
                )
            )
       ) );
    }
    
    public function cq_event_autocomplete_suggester_render( $query ) {
        $query = trim( $query[ 'value' ] );

        // get value from requested
        if ( !empty( $query ) ) {
            $post_object = get_post( ( int )$query );
            if ( is_object( $post_object ) ) {
                $post_title = $post_object->post_title;
                $post_id = $post_object->ID;
                $data = array();
                $data[ 'value' ] = $post_id;
                $data[ 'label' ] = $post_title;
                return !empty( $data ) ? $data : false;
            }
            return false;
        }
        return false;
    }

    public function cq_event_autocomplete_suggester( $query ) {
        global $wpdb;
        //$post_id = ( int )$query;
        $post_results = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title FROM {$wpdb->posts} AS a
    WHERE a.post_type = 'events' AND a.post_status != 'trash' AND a.post_title LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );
        $results = array();
        if ( is_array( $post_results ) && !empty( $post_results ) ) {
            foreach ( $post_results as $value ) {
                $data = array();
                $data[ 'value' ] = $value[ 'id' ];
                $data[ 'label' ] = $value[ 'title' ] . ' - '. get_the_time('d-m-Y', $value[ 'id' ]);;
                $results[] = $data;
            }
        }
        return $results;
    }

}
cqVcExtend::init();

add_action( 'vc_before_init', 'vc_container_init' );
function vc_container_init() {
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Cq_Category_Carousel extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Cq_Category_Carousel_Item extends WPBakeryShortCode {}
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Cq_Category_Grid extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Cq_Category_Grid_Item extends WPBakeryShortCode {}
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Cq_Featured_Regions extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Cq_Featured_Regions_Item extends WPBakeryShortCode {}
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Cq_Featured_Destinations extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Cq_Featured_Destinations_Item extends WPBakeryShortCode {}
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Cq_Grid_Links extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Cq_Grid_Links_Item extends WPBakeryShortCode {}
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Cq_Featured_Cruise_Lines extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Cq_Featured_Cruise_Lines_Item extends WPBakeryShortCode {}
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Cq_Featured_Cruise_Ships extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Cq_Featured_Cruise_Ships_Item extends WPBakeryShortCode {}
    }
}

function cq_region_autocomplete_suggester_render( $query ) {
	$query = trim( $query[ 'value' ] );

	// get value from requested
	if ( !empty( $query ) ) {
		$region_object = get_term( ( int )$query );
		if ( is_object( $region_object ) ) {
			$region_title = $region_object->name;
			$region_id = $region_object->term_id;
			$data = array();
			$data[ 'value' ] = $region_id;
			$data[ 'label' ] = $region_title;
			return !empty( $data ) ? $data : false;
		}
		return false;
	}
	return false;
}

function cq_region_autocomplete_suggester( $query ) {
	
	$region_results = get_terms( 'cruise-type', array( 'search' => $query, 'hide_empty' => false, ) );
	$results = array();
	if ( is_array( $region_results ) && !empty( $region_results ) ) {
		foreach ( $region_results as $value ) {
			$data = array();
			$data[ 'value' ] = $value->term_id;
			$data[ 'label' ] = $value->name;
			$results[] = $data;
		}
	}
	return $results;
}

function cq_cruise_line_autocomplete_suggester_render( $query ) {
	$query = trim( $query[ 'value' ] );

	// get value from requested
	if ( !empty( $query ) ) {
		$line_object = get_post( ( int )$query );
		if ( is_object( $line_object ) ) {
			$line_title = $line_object->post_title;
			$line_id = $line_object->ID;
			$data = array();
			$data[ 'value' ] = $line_id;
			$data[ 'label' ] = $line_title;
			return !empty( $data ) ? $data : false;
		}
		return false;
	}
	return false;
}

function cq_cruise_line_autocomplete_suggester( $query ) {
	
	$line_results = get_posts( array('post_type' => 'cruise-line', 's' => $query) );
	$results = array();
	if ( is_array( $line_results ) && !empty( $line_results ) ) {
		foreach ( $line_results as $value ) {
			$data = array();
			$data[ 'value' ] = $value->ID;
			$data[ 'label' ] = $value->post_title;
			$results[] = $data;
		}
	}
	return $results;
}

function cq_destination_autocomplete_suggester_render( $query ) {
	$query = trim( $query[ 'value' ] );

	// get value from requested
	if ( !empty( $query ) ) {
		$destination_object = get_post( ( int )$query );
		if ( is_object( $destination_object ) ) {
			$destination_title = $destination_object->post_title;
			$destination_id = $destination_object->ID;
			$data = array();
			$data[ 'value' ] = $destination_id;
			$data[ 'label' ] = $destination_title;
			return !empty( $data ) ? $data : false;
		}
		return false;
	}
	return false;
}

function cq_destination_autocomplete_suggester( $query ) {
	
	$destination_results = get_posts( array('post_type' => 'destinations', 's' => $query) );
    
	$results = array();
	if ( is_array( $destination_results ) && !empty( $destination_results ) ) {
		foreach ( $destination_results as $value ) {
			$data = array();
			$data[ 'value' ] = $value->ID;
			$data[ 'label' ] = $value->post_title;
			$results[] = $data;
		}
	}
	return $results;
}

function cq_ship_autocomplete_suggester_render( $query ) {
	$query = trim( $query[ 'value' ] );

	// get value from requested
	if ( !empty( $query ) ) {
		$ship_object = get_post( ( int )$query );
		if ( is_object( $ship_object ) ) {
			$ship_title = $ship_object->post_title;
			$ship_id = $ship_object->ID;
			$data = array();
			$data[ 'value' ] = $ship_id;
			$data[ 'label' ] = $ship_title;
			return !empty( $data ) ? $data : false;
		}
		return false;
	}
	return false;
}

function cq_ship_autocomplete_suggester( $query ) {
	
	$ship_results = get_posts( array('post_type' => 'cruise-ship', 's' => $query) );
    
	$results = array();
	if ( is_array( $ship_results ) && !empty( $ship_results ) ) {
		foreach ( $ship_results as $value ) {
			$data = array();
			$data[ 'value' ] = $value->ID;
			$data[ 'label' ] = $value->post_title;
			$results[] = $data;
		}
	}
	return $results;
}
if (!function_exists('cq_post_autocomplete_suggester_render')) {
    function cq_post_autocomplete_suggester_render( $query ) {
        $query = trim( $query[ 'value' ] );

        // get value from requested
        if ( !empty( $query ) ) {
            $post_object = get_post( ( int )$query );
            if ( is_object( $post_object ) ) {
                $post_title = $post_object->post_title;
                $post_id = $post_object->ID;
                $data = array();
                $data[ 'value' ] = $post_id;
                $data[ 'label' ] = $post_title;
                return !empty( $data ) ? $data : false;
            }
            return false;
        }
        return false;
    }
}
if (!function_exists('cq_post_autocomplete_suggester')) {
    function cq_post_autocomplete_suggester( $query ) {
        global $wpdb;
        //$post_id = ( int )$query;
        $post_results = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title FROM {$wpdb->posts} AS a
    WHERE (a.post_type = 'post' OR a.post_type = 'page') AND a.post_status != 'trash' AND a.post_title LIKE '%%%s%%'", stripslashes( $query ) ), ARRAY_A );
        $results = array();
        if ( is_array( $post_results ) && !empty( $post_results ) ) {
            foreach ( $post_results as $value ) {
                $data = array();
                $data[ 'value' ] = $value[ 'id' ];
                $data[ 'label' ] = $value[ 'title' ] . ' - '. get_the_time('d-m-Y', $value[ 'id' ]);;
                $results[] = $data;
            }
        }
        return $results;
    }
}
if (!function_exists('cq_category_autocomplete_suggester_render')) {
    function cq_category_autocomplete_suggester_render( $query ) {
        $query = trim( $query[ 'value' ] );

        // get value from requested
        if ( !empty( $query ) ) {
            $cat_object = get_category( ( int )$query );
            if ( is_object( $cat_object ) ) {
                $cat_title = $cat_object->name;
                $cat_id = $cat_object->term_id;
                $data = array();
                $data[ 'value' ] = $cat_id;
                $data[ 'label' ] = $cat_title;
                return !empty( $data ) ? $data : false;
            }
            return false;
        }
        return false;
    }
}
if (!function_exists('cq_category_autocomplete_suggester')) {
    function cq_category_autocomplete_suggester( $query ) {

        $category_results = get_terms( 'category', array( 'search' => $query, 'hide_empty' => false, ) );
        $results = array();
        if ( is_array( $category_results ) && !empty( $category_results ) ) {
            foreach ( $category_results as $value ) {
                $data = array();
                $data[ 'value' ] = $value->term_id;
                $data[ 'label' ] = $value->name;
                $results[] = $data;
            }
        }
        return $results;
    }
}