<?php
/**
 * Template Name: People Item 
 * @package WordPress
 * @subpackage Graphene-NBCR
 */

/* use one-column page setting */
global $graphene_settings;
$graphene_settings['column_mode']='one-column'; 

global $person_defaults;

get_header(); 

/* include values for sw item per specified custom field */
$custom_fields = get_post_custom(); 
$my_custom_field = $custom_fields['filename'];
$file = $my_custom_field[0];
include($file);

include('people/people-options-defaults.php');
include('people/people-layout.php');

get_footer();
