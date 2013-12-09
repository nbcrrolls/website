<?php
/**
 * Template Name: Software Item 
 * @package WordPress
 * @subpackage Graphene-NBCR
 */

/* use one-column page setting */
global $graphene_settings;
$graphene_settings['column_mode']='one-column'; 

global $switem_defaults;

get_header(); 

/* include values for sw item per specified custom field */
$custom_fields = get_post_custom(); 
$my_custom_field = $custom_fields['filename'];
$file = $my_custom_field[0];
include($file);

include('sw/switem-options-defaults.php');
include('sw/switem-layout.php');

get_footer();

/*
  foreach ( $my_custom_field as $key => $value )
    echo $key . " => " . $value . "<br />";
*/
?>

