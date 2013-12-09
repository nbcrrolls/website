<?php
/**
 * Template Name Posts: One column, no sidebar
 *
 * A custom post template without sidebar.
 *
 * @package WordPress
 * @subpackage Graphene-NBCR
 * @since Graphene 1.0.5
 */ 
/* use one-column page setting */
global $graphene_settings;
$graphene_settings['column_mode']='one-column'; 

 get_header(); ?>
 
    <?php
    /* Run the loop to output the posts.
     * If you want to overload this in a child theme then include a file
     * called loop-single.php and that will be used instead.
     */
     get_template_part('loop', 'single');
    ?>

<?php get_footer(); ?>

