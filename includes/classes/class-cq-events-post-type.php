<?php

class cqEvents {
    
    public static function init() {
        $self = new self();
        add_action( 'init', array( $self, 'create_event_postype' ));
        add_action( 'init', array( $self, 'create_eventcategory_taxonomy'), 0 );
        add_filter ('manage_edit-events_columns', array( $self, 'events_edit_columns'));
        add_action ('manage_posts_custom_column', array( $self, 'events_custom_columns'));
        add_filter('post_updated_messages',  array( $self, 'events_updated_messages'));
        add_filter( 'rwmb_meta_boxes', array( $self, 'cq_metaboxes') );
    }
    
    public function create_event_postype() {
 
        $labels = array(
            'name' => _x('Events', 'post type general name'),
            'singular_name' => _x('Event', 'post type singular name'),
            'add_new' => _x('Add New', 'events'),
            'add_new_item' => __('Add New Event'),
            'edit_item' => __('Edit Event'),
            'new_item' => __('New Event'),
            'view_item' => __('View Event'),
            'search_items' => __('Search Events'),
            'not_found' =>  __('No events found'),
            'not_found_in_trash' => __('No events found in Trash'),
            'parent_item_colon' => '',
        );

        $args = array(
            'label' => __('Events'),
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'can_export' => true,
            'show_ui' => true,
            '_builtin' => false,
            'capability_type' => 'post',
            'menu_icon' => get_bloginfo('template_url').'/functions/images/event_16.png',
            'hierarchical' => false,
            'rewrite' => array( "slug" => "events" ),
            'supports'=> array('title', 'thumbnail') ,
            'show_in_nav_menus' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'taxonomies' => array( 'event-category', 'post_tag')
        );

        register_post_type( 'events', $args);

    }
    
    public function create_eventcategory_taxonomy() {
 
        $labels = array(
            'name' => _x( 'Categories', 'taxonomy general name' ),
            'singular_name' => _x( 'Category', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Categories' ),
            'popular_items' => __( 'Popular Categories' ),
            'all_items' => __( 'All Categories' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __( 'Edit Category' ),
            'update_item' => __( 'Update Category' ),
            'add_new_item' => __( 'Add New Category' ),
            'new_item_name' => __( 'New Category Name' ),
            'separate_items_with_commas' => __( 'Separate categories with commas' ),
            'add_or_remove_items' => __( 'Add or remove categories' ),
            'choose_from_most_used' => __( 'Choose from the most used categories' ),
        );

        register_taxonomy('event-category','events', array(
            'label' => __('Event Category'),
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'event-category' ),
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
            'id' => 'events-settings',
            'title' => esc_html__( 'Event Settings', 'CQ_Custom' ),
            'pages'    => array( 'events' ),
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                'name'       => 'Start Date',
                'id'         => 'event_start_date',
                'type'       => 'date',

                // Date picker options. See here http://api.jqueryui.com/datepicker
                'js_options' => array(
                    'dateFormat'      => 'dd-mm-yy',
                '	showButtonPanel' => false,
                ),

                // Display inline?
                'inline' => false,

                // Save value as timestamp?
                'timestamp' => true,
                ),
                array(
                'name'       => 'End Date',
                'id'         => 'event_end_date',
                'type'       => 'date',

                // Date picker options. See here http://api.jqueryui.com/datepicker
                'js_options' => array(
                    'dateFormat'      => 'dd-mm-yy',
                '	showButtonPanel' => false,
                ),

                // Display inline?
                'inline' => false,

                // Save value as timestamp?
                'timestamp' => true,),
                array(
                'name'        => 'Event Website',
                'id'          => 'event_url',
                'desc'        => 'Please enter the website of the event',
                'type'        => 'text',),
                array(
                'name'        => 'Event Address',
                'id'          => 'event_address',
                'desc'        => 'Please enter the address of the event',
                'type'        => 'textarea',
                'rows'		  => 6,
                ),
                array(
                        'id'      => 'event-logo',
                        'name'    => __( 'Logo for the event', 'CQ_Custom' ),
                        'type'    => 'image_advanced',

                ),
            )

        );
        
        return $meta_boxes;
        
    }
    
    public function events_updated_messages( $messages ) {
 
        global $post, $post_ID;

        $messages['events'] = array(
          0 => '', // Unused. Messages start at index 1.
          1 => sprintf( __('Event updated. <a href="%s">View item</a>'), esc_url( get_permalink($post_ID) ) ),
          2 => __('Custom field updated.'),
          3 => __('Custom field deleted.'),
          4 => __('Event updated.'),
          /* translators: %s: date and time of the revision */
          5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
          6 => sprintf( __('Event published. <a href="%s">View event</a>'), esc_url( get_permalink($post_ID) ) ),
          7 => __('Event saved.'),
          8 => sprintf( __('Event submitted. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
          9 => sprintf( __('Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>'),
            // translators: Publish box date format, see http://php.net/date
            date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
          10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );

        return $messages;
    }
    
}
cqEvents::init();