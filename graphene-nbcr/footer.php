<?php
/**
 * The template for displaying the footer.
 *
 * Closes the <div> for #content, #content-main and #container, <body> and <html> tags.
 *
 * @package WordPress
 * @subpackage Graphene
 * @since Graphene 1.0
 */
global $graphene_settings;
?>
  
    </div><!-- #content-main -->
    
    <?php
    
        /* Sidebar 1 on the right side? */
        if ( in_array(graphene_column_mode(), array('two-col-left', 'three-col-left')) ){
            get_sidebar();
        }
        /* Sidebar 2 on the right side? */
        if ( in_array(graphene_column_mode(), array('three-col-left', 'three-col-center')) ){
            get_sidebar('two');
        }
    
    ?>
    

</div><!-- #content -->

<?php /* Get the footer widget area */ ?>
<?php get_template_part('sidebar', 'footer'); ?>

<?php do_action('graphene_before_footer'); ?>

<div id="footer">

    <?php if (!$graphene_settings['hide_copyright']) : ?>
        <div id="copyright" <?php if (!$graphene_settings['show_cc'] && !is_rtl()) {
        echo 'style="background:none;padding-left:20px;"';
    } elseif (!$graphene_settings['show_cc'] && is_rtl()) {
        echo 'style="background:none;padding-right:20px;"';
    } ?>>

            <?php if ($graphene_settings['copy_text'] == '') : ?>
                <p>
<!--
                <?php _e('Except where otherwise noted, content on this site is licensed under a <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons Licence</a>.', 'graphene'); ?>
-->
                <img src="<?php echo get_stylesheet_directory_uri().'/images/logos/NBCR-logo.png'; ?>" alt="" class="small-logo" />
                <img src="<?php echo get_stylesheet_directory_uri().'/images/logos/NIH-logo.png'; ?>" alt="" class="small-logo" />
                <img src="<?php echo get_stylesheet_directory_uri().'/images/logos/NIGMS-logo.png'; ?>" alt="" class="small-logo" />
                </p>
            <?php else : ?>
            <?php echo stripslashes($graphene_settings['copy_text']); ?>
        <?php endif; ?>

    <?php do_action('graphene_copyright'); ?>
        </div>
<?php endif; ?>


    <div id="w3c">
        <p>
            <a title="<?php esc_attr_e('Valid XHTML 1.0 Strict', 'graphene'); ?>" href="http://validator.w3.org/check?uri=referer" id="w3c_xhtml"><span><?php _e('Valid XHTML 1.0 Strict', 'graphene'); ?></span></a> 
            <a title="<?php esc_attr_e('Valid CSS', 'graphene'); ?>" href="http://jigsaw.w3.org/css-validator/check/referer/" id="w3c_css"><span><?php _e('Valid CSS Level 2.1', 'graphene'); ?></span></a>
        </p>

    <?php do_action('graphene_w3c'); ?>
    </div>


    <div id="developer">
        <p>
        <?php /* translators: %1$s is the blog title, %2$s is the theme's name, %3$s is the theme's author */ ?>
<?php printf(__('%1$s uses %2$s-based theme', 'graphene'), '<a href="' . get_home_url() . '">' . get_bloginfo('name') . '</a>', '<a href="http://www.khairul-syahir.com/wordpress-dev/graphene-theme">' . ucfirst(get_template()) . '</a>' ); ?>
        </p>

<?php do_action('graphene_developer'); ?>
    </div>
    <div class="sidebar-wrap clearfix">
        <ul>
            <li><?php wp_register(); ?></li>
            <li><?php wp_loginout(); ?></li>
        </ul>
    </div>



</div><!-- #footer -->

<?php do_action('graphene_after_footer'); ?>

</div><!-- #container -->

<?php if (!get_theme_mod('background_image', false) && !get_theme_mod('background_color', false)) : ?>
    </div><!-- .bg-gradient -->
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
