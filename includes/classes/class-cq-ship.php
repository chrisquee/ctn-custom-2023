<?php
class cqshipObject {
    
    public $ship_id = '';
    public $ship_meta = array();
    public $ship_title = '';
    public $ship_url = '';
    public $ship_facts = array();
    public $ship_teaser = '';
    public $ship_accommodation = array();
    public $ship_accommodation_intro = '';
    public $ship_enrichment = array();
    public $ship_enrichment_intro = '';
    public $ship_intro = '';
    public $ship_description = '';
    public $ship_page_link = '';
    public $ship_cruise_line = '';
    public $ship_cruise_line_link = '';
    public $ship_cruise_types = array();
    public $ship_health_fitness = '';
    public $ship_health_fitness_intro = '';
    public $ship_dining = '';
    public $ship_entertainment = '';
    public $ship_entertainment_intro = '';
    public $ship_deckplans = array();
    public $ship_health_dining_intro = '';
    
    public function __construct($ship_id = null){
        
        if (is_numeric($ship_id)) {
			$this->cq_setup_ship_data($ship_id);
		} else {
			$this->cq_setup_ship_data();
		}
  
    }
    
    public function cq_setup_ship_data($ship_id = null) {
        
        global $post;
        
        if (is_int($ship_id)) {
			$post = get_post( $ship_id );
            setup_postdata( $post );
		}
        
        if (get_post_type( $post->ID ) != 'cruise-ship') {
            return;
        }
	  
	   if (is_numeric($post->ID) && get_post_type( $post->ID ) == 'cruise-ship') { 
          
          $ship_meta = get_post_meta( get_the_ID() );
          $this->ship_meta = $ship_meta;
          $this->ship_id = $post->ID;
          $this->ship_title = get_the_title();
          $this->ship_teaser = get_the_excerpt();
          $this->ship_description = get_the_content();
          
          $this->ship_accommodation = get_post_meta($this->ship_id, 'cruise_ship-accomodation', true);
          $this->ship_enrichment = get_post_meta($this->ship_id, 'cruise_ship-enrichment', true);
          $this->ship_entertainment = get_post_meta($this->ship_id, 'cruise_ship-entertainment', true);
          $this->ship_health_fitness = get_post_meta($this->ship_id, 'cruise_ship-health_fitness', true);
          $this->ship_dining = get_post_meta($this->ship_id, 'cruise_ship-dining', true);
          $this->ship_deckplans = get_post_meta($this->ship_id, 'cruise_ship-deckplans', true);
          $this->ship_facts = get_object_vars(get_post_meta($this->ship_id, 'ship_facts', true));
           
          $this->ship_accommodation_intro = isset($ship_meta['accommodation_intro'][0]) && $ship_meta['accommodation_intro'][0] != '' ? $ship_meta['accommodation_intro'][0] : '';
          $this->ship_enrichment_intro = isset($ship_meta['enrichment_intro'][0]) && $ship_meta['enrichment_intro'][0] != '' ? $ship_meta['enrichment_intro'][0] : '';
          $this->ship_entertainment_intro = isset($ship_meta['entertainment_intro'][0]) && $ship_meta['entertainment_intro'][0] != '' ? $ship_meta['entertainment_intro'][0] : '';
          $this->ship_health_fitness_intro = isset($ship_meta['health_fitness_intro'][0]) && $ship_meta['health_fitness_intro'][0] != '' ? $ship_meta['health_fitness_intro'][0] : '';
          $this->ship_health_dining_intro = isset($ship_meta['dining_intro'][0]) && $ship_meta['dining_intro'][0] != '' ? $ship_meta['dining_intro'][0] : '';
           
          $this->ship_page_link = get_permalink($this->ship_id);
          $this->ship_cruise_line = get_post_meta( $this->ship_id, 'cruise_line', true );
          $this->ship_cruise_line_link = get_permalink($this->ship_cruise_line);
           

       }
        
    }
    
    public function maybe_add_https($url) {
        
        if(strpos($url,"https") === false){
            $url = 'https:' . $url;
        }
        
        return $url;
        
    }
    
    public function maybe_add_suffix($key, $value) {
        
        if (!is_array($value)) {
            if ($key == 'width' || $key == 'length') {
                $value = $value . ' meters';
            }
            if ($key == 'speed') {
                $value = $value . ' knots';
            }
            if (!$value) {
                return 'false';
            }
        }
        
        return $value;
        
    }
    
    public function ship_breadcrumbs($echo = false) {
        
        $separator          = '/';
        $breadcrumbs_id      = 'breadcrumbs';
        $breadcrumbs_class   = 'breadcrumbs';
        $home_title         = 'Home';
        $prefix = '';
        $cat_display = '';
        
        $line_parents = wp_get_object_terms( $this->ship_cruise_line, 'cruise-type' );
        $line_links = '';
        
        //print_r($line_parents);
        
        foreach ($line_parents as $line) {
            $line_links .= '<li class="item-archive"><span class="bread-archive"><a class="bread-cat bread-custom-post-type-cruise-ships" href="' . get_term_link($line->term_id, 'cruise-type') . '" title="' . $line->name . '">' . $line->name . '</a></li>
                           <li class="separator"> ' . $separator . ' </li>';
        }
        
        $html = '<ul id="' . $breadcrumbs_id . '" class="' . $breadcrumbs_class . '">
                    <li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>
                    <li class="separator"> ' . $separator . ' </li>
                    ' . $line_links . '
                    <li class="item-archive"><span class="bread-archive"><a class="bread-cat bread-custom-post-type-cruise-ships" href="' . $this->ship_cruise_line_link . '" title="' . get_the_title($this->ship_cruise_line) . '">' . get_the_title($this->ship_cruise_line) . '</a></span></li>
                    <li class="separator"> ' . $separator . ' </li>
                    <li class="item-current item-' . $this->ship_id . '"><span class="bread-current bread-' . $this->ship_id . '" title="' . $this->ship_title . '">' . $this->ship_title . '</span></li>';
        
        if (!$echo) {
            return $html;
        } else {
            echo $html;
        }
        
    }
    
}
