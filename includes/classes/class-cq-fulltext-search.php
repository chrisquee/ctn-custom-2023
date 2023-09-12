<?php
class cqFUllTextSearch {

    private $plugin_name = 'cq-custom';

    public static function init() {
        $self = new self();
        add_action( 'pre_get_posts', array( $self, 'add_search_variable'), 10 );
        add_filter( 'posts_clauses', array( $self, 'modify_search_query_clauses'), 20, 2 );
    }
    
    function add_search_variable( $wp_query ) {
        if ( ! is_admin() && $wp_query->is_main_query() ) {
            if ( $wp_query->is_search ) {
                $wp_query->set( 'query_id', 'distinct_query_id' );
                $wp_query->set( 'post_status', 'publish' );
                $wp_query->set( 'perm', 'readable' );
            }
        }
    }
    
    function modify_search_query_clauses( $clauses, $wp_query ) {
        
        global $wpdb;
        
        if ( ! is_admin() && ( is_search() || isset( $wp_query->query_vars['query_id'] ) && $wp_query->query_vars['query_id'] === 'distinct_query_id' ) ) {
            $query_string = esc_html( $wp_query->query_vars['s'] );

            if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
                $current_lang = ICL_LANGUAGE_CODE;
            } else {
                $current_lang = 'hr';
            }

            $clauses['distinct'] = "DISTINCT {$wpdb->posts}.*,";

            $clauses['fields'] = " GREATEST(
                                  COALESCE(MATCH ({$wpdb->posts}.post_title) AGAINST ('\"{$query_string}\" @4' IN BOOLEAN MODE), 1) * 100,
                                  COALESCE(MATCH ({$wpdb->posts}.post_content) AGAINST ('\"{$query_string}\" @4' IN BOOLEAN MODE), 1),
                                  COALESCE(MATCH ({$wpdb->postmeta}.meta_value) AGAINST ('\"{$query_string}\" @4' IN BOOLEAN MODE), 1)
                                ) AS score";

            $clauses['join'] = "LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id";

            $clauses['where'] = "AND ({$wpdb->posts}.post_type = 'post'
                                OR {$wpdb->posts}.post_type = 'page'
                                OR {$wpdb->posts}.post_type = 'faq-type')
                               AND {$wpdb->posts}.post_type != 'wpcf7_contact_form'
                               AND {$wpdb->posts}.post_type != 'revision'
                               AND (
                                 MATCH ({$wpdb->posts}.post_title) AGAINST ('\"{$query_string}\" @4' IN BOOLEAN MODE) > 0 OR
                                 MATCH ({$wpdb->posts}.post_content) AGAINST ('\"{$query_string}\" @4' IN BOOLEAN MODE) > 0 OR
                                 MATCH ({$wpdb->postmeta}.meta_value) AGAINST ('\"{$query_string}\" @4' IN BOOLEAN MODE) > 0
                               )
                               AND {$wpdb->posts}.post_status = 'publish'";

            $clauses['orderby'] = 'score DESC';
        }

        return $clauses;
    }
    
}
cqFUllTextSearch::init();