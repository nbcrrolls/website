<?php 
/**
 * Set the default values for person settings. 
 */

$person_defaults = array(
    'name_header' => 'Name:',
    'name' => ($name ? $name : ''),

    'affiliation_header' => 'Department Affiliation:',
    'affiliation' => ($affiliation ? $affiliation : ''),

    'research_role_header' => 'Role in Research Unit:',
    'research_role' => ($research_role? $research_role: ''),

    'expertise_header' => 'Areas of Expertise and Interest:',
    'expertise' => ($expertise ? $expertise : ''),

    'home_url_header' => 'Homepage',
    'home_url' => ($home_url ? $home_url : ''),

    'email_header' => 'Email',
    'email' => ($email ? $email : ''),

    'nbcr_role_header' => 'Role in NBCR:',
    'nbcr_role' => ($nbcr_role? $nbcr_role: ''),

    'photo' => ($photo ? $photo : ''),
);
?>
