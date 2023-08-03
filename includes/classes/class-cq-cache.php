<?php

class cqCache {
    
    public static function init() {
    	$self = new self();
		add_filter( 'cron_schedules', array( $self, 'add_cq_daily_cron_schedule') );
//        add_action( 'cq_daily',array( $self, 'clear_litespeed_cache') );
    
        /*if ( ! wp_next_scheduled( 'cq_daily' ) ) {
            wp_schedule_event( strtotime('00:10:00 Europe/London'), 'cq_daily', 'cq_daily' );
        }*/
        
  	}

    // Register a new cron schedule with 86400 seconds interval
    public function add_cq_daily_cron_schedule( $schedules ) { 
        if(!isset($schedules["cq_daily"])){
            $schedules['cq_daily'] = array(
                'interval' => 86400,
                'display'  => esc_html__( 'CQ Every Day' ), );
        }
        return $schedules;
    }

    /*public function clear_litespeed_cache() {
        if (class_exists('\LiteSpeed\Purge')) {
            \LiteSpeed\Purge::purge_all();
        }
    }*/
}
cqCache::init();