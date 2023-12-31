<?php

get_header();

$cruise_type = get_queried_object();
$children = get_term_children( $cruise_type->term_id, 'cruise-type' );
?>

<div id="main-content-wrapper">

    <article <?php post_class( 'cruise-type'); ?>>

    <?php include('cruise-types/cruise-types-header.php'); ?>

    <?php if (!empty($children)) {

        include('cruise-types/cruise-types-regions.php');

        } else {
    
            include('cruise-types/cruise-types-about.php');
            include('cruise-types/cruise-types-what-we-love.php');
            include('cruise-types/cruise-types-feature.php');
            include('cruise-types/cruise-types-destinations.php');

        }

        include('cruise-types/cruise-types-selling-tips.php');

        include('cruise-types/cruise-types-cruise-lines.php');

        include('cruise-types/cruise-types-news.php');

        if ($cruise_type->parent == 0) {

        get_template_part( 'loop-templates/content', 'subscribe-footer' );

        }

        if ($cruise_type->parent != 0) {

            include('cruise-types/cruise-types-latest-issue.php');

        }

        ?>

    </article>

</div> <!-- Primary End -->
        
            
<?php get_footer(); ?>          