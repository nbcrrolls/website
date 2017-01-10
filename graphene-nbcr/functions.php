<?php 

//disable auto p
remove_filter ('the_content', 'wpautop');

//disable wptexturize
remove_filter('the_content', 'wptexturize');

include('sw/switem-options-defaults.php');

/* test funciton */
function show_sw_test ($a) {
    echo 'HERE'.$a;
}

/* prints paragraph. pheader is heading in bold, pcontent is tcontent  */
function show_sw_paragraph ($pheader, $pcontent) {
    global $switem_defaults;
    if ($switem_defaults[$pcontent]) :
        $line = '<p><strong>'.$switem_defaults[$pheader].' </strong>'.$switem_defaults[$pcontent].'</p>';
        echo $line;
    endif;
}

/* prints a link as list item. lcontent is url link, lheader is the name */
function show_sw_url ($lheader, $lcontent) {
    global $switem_defaults;
    if ($switem_defaults[$lcontent]) :
        $line = '<li><a href="'.$switem_defaults[$lcontent].'">'.$lheader.'</a></li>';
        echo $line;
    endif;
}

/* prints web service url, lcontent is url link */
function show_ws_url ($lcontent) {
    global $switem_defaults;

    if ($switem_defaults[$lcontent]) :
        $needle = ".ucsd.edu";
        $pos = strpos($switem_defaults[$lcontent],$needle);
        if($pos == false) { // short server name
            $name = $switem_defaults[$lcontent]; 
        }
        else { // remove opal dashboard from name
            $name = substr($switem_defaults[$lcontent], 0, $pos) ;
        }
        $line = '<li><a href="http://'.$switem_defaults[$lcontent].'">'.$name.'</a></li>';
        echo $line;
    endif;
}

/* prints general and NBCR acknoledgement */
function show_sw_disclaimer () {
    global $switem_defaults;

    $line = '<h5>'.$switem_defaults['disclaimer_header'].' </h5>'.$switem_defaults['disclaimer'].'</p>';
    echo $line;
}

/* prints general and NBCR acknoledgement */
function show_sw_acknowledgments () {
    global $switem_defaults;

    $line = '<h5>'.$switem_defaults['acknowledgment_header'].' </h5><p>'.$switem_defaults['acknowledgment'].'</p>';
    $line .= '<p><strong>'.$switem_defaults['acknowledgment_nbcr_header'].' </strong>'.$switem_defaults['acknowledgment_nbcr'].'</p>';
    echo $line;
}

/* prints software item citation info */
function show_sw_citation () {
    global $switem_defaults;

    $line = '<p><strong>'.$switem_defaults['sw_name'].' '.$switem_defaults['sw_citation_header'].' </strong><span class="sw-citation">';
        
    /* add bibtex ciation if exists */
    $biburlpref = get_stylesheet_directory_uri().'/docs/citations/';
    $biburl = $switem_defaults['sw_citation_bib_link'];
    $part_bib = $biburl ? '[<a href="'.$biburlpref.$biburl.'">'.$switem_defaults['sw_citation_bib'].'</a>]' : '';
    $line .= $part_bib ? $part_bib.' ' : '';  

    /* add endnote ciation if exists */
    $endnoteurl = $switem_defaults['sw_citation_endnote_link'];
    $part_endnote = $endnoteurl ? '[<a href="'.$endnoteurl.'">'.$switem_defaults['sw_citation_endnote'].'</a>]' : '';
    $line .= $part_endnote ? $part_endnote.' ' : '';

    /* add plaintext ciation if exists (can be url or local file name */
    $plainurl = $switem_defaults['sw_citation_plain_link'];
    $plainurlpref = '';
    if ($plainurl) :
        $plainurlpref = substr_count($plainurl, 'http') ? '' : get_stylesheet_directory_uri().'/docs/citations/';
    endif;
    $part_plain = $plainurl ? '[<a href="'.$plainurlpref.$plainurl.'">'.$switem_defaults['sw_citation_plain'].'</a>]' : '';
    $line .= $part_plain ? $part_plain.' ' : '';  

    /* print citation line */
    $line .= '</span></p>';   /* complete the line */
    $checkline = $biburl . $endnoteurl . $plainurl;
    $line = $checkline ? $line : '';  /* reset to empty if no citations */
    echo $line;
}

/* prints software item license info */
function show_sw_license ($lheader, $lcontent) {
    global $switem_defaults;

    $lurl = $switem_defaults[$lcontent];
    $lurlpref = '';
    if ($lurl) :
        $lurlpref = substr_count($lurl, 'http') ? '' : get_stylesheet_directory_uri().'/docs/licenses/';
        $line = '<li><a href="'.$lurlpref.$lurl.'">'.$switem_defaults[$lheader].'</a></li>';
        echo $line;
    endif;
}

/* prints software item  logo image */
function  show_sw_img () {
    global $switem_defaults;
    $img_link = get_stylesheet_directory_uri().'/images/sw/'.$switem_defaults['sw_image'];
    $img_options = '" alt="" class="switem-img" />';
    $line = '<img src="'.$img_link.$img_options;
    echo $line;
}

/* prints software item  thum logo image */
function  show_sw_thumimg () {
    global $switem_defaults;
    $img_link = get_stylesheet_directory_uri().'/images/sw/thum/'.$switem_defaults['sw_image'];
    $img_options = '" alt="" class="switem-img-thum" />';
    $line = '<img src="'.$img_link.$img_options;
    echo $line;
}

/* prints software item thum logo image, requires sw name*/
function  show_thumimg ($name) {
    $img_link = get_stylesheet_directory_uri().'/images/sw/thum/'.$name.'.png';
    $img_options = '" class="switem-img-thum" alt="" />';
    $line = '<img src="'.$img_link.$img_options;
    echo $line;
}


/* prints software item description */
function show_sw_desc () {
    global $switem_defaults;
    show_sw_paragraph('sw_version_header', 'sw_version');
    show_sw_paragraph('sw_name', 'sw_description'); 
    show_sw_paragraph('sw_platforms_header', 'sw_platforms');
    show_sw_paragraph('acknowledgment_specific_header', 'acknowledgment_specific');
    show_sw_paragraph('acknowledgment_nbcr_header', 'acknowledgment_nbcr');
    show_sw_citation ();
}

/* prints software item links */
function show_sw_links () {
    global $switem_defaults;
    show_sw_url('Download', 'link_download');
    show_sw_url('Documentation', 'link_documentation');
    show_sw_url('Users Guide', 'link_users_guide');
    show_sw_url('Tutorials', 'link_tutorials');
    show_sw_url('Datasets', 'link_datasets');
    show_sw_url('Mailing Lists', 'link_mailing_lists');
    show_sw_url('Bug Report', 'link_bug_report');
    show_sw_license ('sw_license_header', 'sw_license');
    show_webservices();

}

/* prints software web serivces link */
function show_webservices () {
    global $switem_defaults;
    if ($switem_defaults['link_webservice1']) :
        $line = '<li><br><strong>Web servers:</strong></li>';
	echo $line;
        show_ws_url('link_webservice1');
        show_ws_url('link_webservice2');
        show_ws_url('link_webservice3');
    endif;
}

/* define header images */
function graphene_nbcr_get_default_headers() {
	return array(
		'Abstract1' => array(
			'url' => '%s/images/headers/abstract1.jpg',
			'thumbnail_url' => '%s/images/headers/abstract1-thumb.jpg',
			'description' => __('Header image distorted from continuity', 'graphene')
		),
		'Abstract2' => array(
			'url' => '%s/images/headers/abstract2.jpg',
			'thumbnail_url' => '%s/images/headers/abstract2-thumb.jpg',
			'description' => __('Header image ', 'graphene')
		),
		'Abstract3' => array(
			'url' => '%s/images/headers/abstract3.jpg',
			'thumbnail_url' => '%s/images/headers/abstract3-thumb.jpg',
			'description' => __('Header image distorted from continuity', 'graphene')
		),
		'Abstract4' => array(
			'url' => '%s/images/headers/abstract4.jpg',
			'thumbnail_url' => '%s/images/headers/abstract4-thumb.jpg',
			'description' => __('Header image distorted from continuity', 'graphene')
		),
		'Abstract5' => array(
			'url' => '%s/images/headers/abstract5.jpg',
			'thumbnail_url' => '%s/images/headers/abstract5-thumb.jpg',
			'description' => __('Header image Vina-JCC', 'graphene')
		),
		'Abstract6' => array(
			'url' => '%s/images/headers/abstract6.jpg',
			'thumbnail_url' => '%s/images/headers/abstract6-thumb.jpg',
			'description' => __('Header image ', 'graphene')
		),
		'Abstract7' => array(
			'url' => '%s/images/headers/abstract7.jpg',
			'thumbnail_url' => '%s/images/headers/abstract7-thumb.jpg',
			'description' => __('Header image ', 'graphene')
		),
		'Abstract8' => array(
			'url' => '%s/images/headers/abstract8.jpg',
			'thumbnail_url' => '%s/images/headers/abstract8-thumb.jpg',
			'description' => __('Header image LV-RV endocardium', 'graphene')
		),
	);
}

/* show highlights images */
function  show_highlights_image ($name) {
    $img_link = get_stylesheet_directory_uri().'/images/highlights/'.$name.'.png';
    $img_options = '" class="highlights-img align-left" alt="" />';
    $line = '<img src="'.$img_link.$img_options;
    echo $line;
}

/* prints post images */
function  show_post_image ($name) {
    $img_link = get_stylesheet_directory_uri().'/images/posts/'.$name.'.png';
    $img_options = '" class="post-img align-left" alt="" />';
    $line = '<img src="'.$img_link.$img_options;
    echo $line;
}

function test_show_post_image ($n1, $n2 = null, $n3 = null) {
    $img_options = '" class="post-img align-left" alt="" />';

    /* add 1st image */
    $img_link = get_stylesheet_directory_uri().'/images/posts/'.$n1.'.png';
    $line = '<span style="white-space: nowrap">';
    $line .= '<img src="'.$img_link.$img_options;
    $numargs = func_num_args();

    /* add 2nd image */
    if ($numargs >= 2) {
        $img_link = get_stylesheet_directory_uri().'/images/posts/'.$n2.'.png';
        $line .= '<img src="'.$img_link.$img_options;
    }

    /* add 3rd image */
    if ($numargs == 3) {
        $img_link = get_stylesheet_directory_uri().'/images/posts/'.$n3.'.png';
        $line .= '<img src="'.$img_link.$img_options;
    }

    $line .= '</span>';
    echo $line;
}

/* overwrite parent theme function here */
function graphene_get_header_image($post_id = NULL){
        global $graphene_settings;

        if ( is_singular() && has_post_thumbnail( $post_id ) && ( /* $src, $width, $height */ $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'post-thumbnail' ) ) &&  $image[1] >= HEADER_IMAGE_WIDTH && !$graphene_settings['featured_img_header']) {
                $header_img = get_the_post_thumbnail( $post_id, 'post-thumbnail' );
                $header_img = explode('" class="', $header_img);
                $header_img = $header_img[0];
                $header_img = explode('src="', $header_img);
                $header_img = $header_img[1]; // only the url
        }
        else if ($graphene_settings['use_random_header_img']){
                $default_header_images = graphene_nbcr_get_default_headers();
                $randomkey = array_rand($default_header_images);
                $header_img = str_replace('%s', get_stylesheet_directory_uri(), $default_header_images[$randomkey]['url']);
        } else {
                $header_img = get_header_image();
        }
return $header_img;
}

/*
 foreach ( $switem_defaults as $key => $value )
    echo $key . " => " . $value . "<br />";
*/

/* functions to show people info */
function show_person_desc () {
    global $person_defaults;
    show_person_paragraph('name_header', 'name');
    show_person_paragraph('affiliation_header', 'affiliation'); 
    show_person_paragraph('research_role_header', 'research_role');
    show_person_paragraph('expertise_header', 'expertise');
    show_person_paragraph('nbcr_role_header', 'nbcr_role');
}

function show_person_paragraph ($pheader, $pcontent) {
    global $person_defaults;
    if ($person_defaults[$pcontent]) :
        $line = '<p><strong>'.$person_defaults[$pheader].' </strong>'.$person_defaults[$pcontent].'</p>';
        echo $line;
    endif;
}

function  show_person_img () {
    global $person_defaults;
    $img_link = get_stylesheet_directory_uri().'/images/people/'.$person_defaults['photo'];
    $img_options = '" alt="" class="person-img" />';
    $line = '<img src="'.$img_link.$img_options;
    echo $line;
}

function show_person_links () {
    global $person_defaults;
    if ($person_defaults['home_url']) :
        $line = '<li><a href="'.$person_defaults['home_url'].'">'.$person_defaults['home_url_header'].'</a></li>';
        echo $line;
    endif;

    if ($person_defaults['email']) :
        $line = '<li><a href="'.$person_defaults['email'].'">'.$person_defaults['email_header'].'</a></li>';
        echo $line;
    endif;
}

function show_tutorials () {
    $bindir = getcwd().'/wp-content/themes/graphene-nbcr/bin/';
    $prog = 'parseTutorials.sh';
    $swdir = getcwd().'/wp-content/themes/graphene-nbcr/sw';

    $output = array();
    exec("$bindir/$prog $swdir", $output);
    foreach($output as $item) {
        $explodeit = explode(" ", $item);
        $name = $explodeit[0];
        $url = $explodeit[1];
        $line = "<a href=" . $url . '>' . $name . '</a><br>';
        echo $line ; 
    }
}

// 2016-12-23 remvoe ver from css and js files
// remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

?>
