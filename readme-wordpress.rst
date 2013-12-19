.. highlight:: rest

Wordpress installation and management
======================================

Initial wordpress configuration
--------------------------------

Install newer version of wordpress as /var/www/html/wordpress2

Make redirect on the server, tell apache to use wordpress2 ::

    vim /var/www/html/index.html
    change from  URL=/wordpress/ to  URL=/wordpress2/

Create a wordpress database *wpdb* and set permissions. Use real values for USER and PASS ::

    # mysqladmin create wpdb
    # mysql -u root -p
    mysql> grant all privileges on wpdb.* to 'USER'@'localhost' identified by 'PASS';

Create initial wp-config.php file. ::

    # cd wordpress2/
    # cp wp-config-sample.php wp-config.php

Edit wp-config.php 

   #. define dbnamme, dbuser, dbpass, dbhost ::

       define('DB_NAME', 'wpdb');
       define('DB_USER', 'USER');       <-- put user account info
       define('DB_PASSWORD', 'PASS');   <-- put user account info
       define('DB_HOST', 'localhost:/var/lib/mysql/mysql.sock');

   #. Generate 8 keys at  https://api.wordpress.org/secret-key/1.1/salt/ and put in ::

       define('AUTH_KEY',         'put your unique phrase here');
       define('SECURE_AUTH_KEY',  'put your unique phrase here');
       define('LOGGED_IN_KEY',    'put your unique phrase here');
       define('NONCE_KEY',        'put your unique phrase here');
       define('AUTH_SALT',        'put your unique phrase here');
       define('SECURE_AUTH_SALT', 'put your unique phrase here');
       define('LOGGED_IN_SALT',   'put your unique phrase here');
       define('NONCE_SALT',       'put your unique phrase here');

   #. define WP\_SITEURL, WP\_HOME ::

       define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/wordpress2');
       define('WP_HOME',    'http://' . $_SERVER['HTTP_HOST'] . '/wordpress2');

   #. add multisite (if using multiple hostings) :: 

       define( 'MULTISITE', true );
       define( 'SUBDOMAIN_INSTALL', false );
       $base = '/wordpress2/';
       define( 'DOMAIN_CURRENT_SITE', 'nbcr.ucsd.edu' );
       define( 'PATH_CURRENT_SITE', '/wordpress2/' );
       define( 'SITE_ID_CURRENT_SITE', 1 );
       define( 'BLOG_ID_CURRENT_SITE', 1 );

Create /var/www/html/wordpress2/.htaccess ::

       #<IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /wordpress2/
       RewriteRule ^index\.php$ - [L]
       
       # uploaded files
       RewriteRule ^([_0-9a-zA-Z-]+/)?files/(.+) wp-includes/ms-files.php?file=$2 [L]
       
       # add a trailing slash to /wp-admin
       RewriteRule ^([_0-9a-zA-Z-]+/)?wp-admin$ $1wp-admin/ [R=301,L]
       
       RewriteCond %{REQUEST_FILENAME} -f [OR]
       RewriteCond %{REQUEST_FILENAME} -d
       RewriteRule ^ - [L]
       RewriteRule  ^[_0-9a-zA-Z-]+/(wp-(content|admin|includes).*) $1 [L]
       RewriteRule  ^[_0-9a-zA-Z-]+/(.*\.php)$ $1 [L]
       RewriteRule . index.php [L]
       #<IfModule>

       #RewriteRule ^([_0-9a-zA-Z-]+/)?siteN/files/(.+) wp-content/blogs.dir/N/files/$2 [L]

Create child theme ::
       
       cd /var/www/html/wordpress2/wp-content/themes
       mkdir graphene-nbcr
        
 
Theme changes
---------------

Custom files used by theme-specific php code. 

**bin/** - for scripts used in functions.php

**docs/** - for short docss used in software-related pages ::

      citations/ - citations for software. Each file represents multiple citations for
                   a single software item. Naming convention: SWNAME.EXT where SWNAME is
                   a software item name form the software list (see below) and EXT specifies  
                   file format  and can be  bibtext, plain pr bibtex.
      licenses/  - for  licenses, if needed by the software. Naming convention: SWNAME, format is ascii.

**images/**  - categorize images as ::

       headers/    - header images 960x100
       highlights/ - images for highlights pages
       logos/      - for logos
       people/     - people photos, ~250x300. Images will be scaled by templates. 
       posts/      - post images, names consistent with post title (ex: chagas for chagas). Size  ~1000x616
       sw/         - software logos, ~200x200 (size, ratio are variable)
       sw/thum/    - software logos thums, created from logo images. size ~27x16
       users/      - image maps

**sw/** - contains template files for software items and php templates for showing them ::

      switem-options-defaults.php - all default options
      switem-layout.php - layout of the sw item on the page
      template.php - template with all needed variables
      SWNAME.php  - for each software item, SWNAME is software item name from the software list below. 

 
Adding a new sw item 
~~~~~~~~~~~~~~~~~~~~~~

#. Check sw name lineup below. 
   if name is not there, add it and update numerical order below
   and also on all respective software pages that change due to new item. The chages will be in *Order* tab
   in page attributes section. ::

    1 ADT
    2 AMD
    3 APBS
    4 Autoclick
    5 AutoGrow
    6 Browndye
    7 CADD
    8 Continuity
    9 CSMOL
    10 ePMV
    11 FETK
    12 Gamer
    13 iAPBS
    14 MEME
    15 MGLTools
    16 NNScore
    17 Opal
    18 PDB2PQR
    19 PMV
    20 POVME
    21 SMOL
    22 TxBR

#. Create a new php file for the new sw item ::

     cd sw/
     cp template.php swname.php (copy a template with all required variables)
   
   edit swname.php and put all information that exist, leave unknown as is.

#. Add software images as ::
     
      images/sw/swname.png
      images/sw/thum/swname.png  (image size 27x16)
      
   images will be scaled according to nbcr.css style settings

#. Create a new page with a title as a name of the software item.
   In "Page Attributes" section set the following using menues  ::

         Parent: Software
         Template: Software Item
         Order: use a number from the name line-up
         in "Custom Fields" under "Name" menu select "filename" and add
         in corresponding "Value"  field a file name as sw/swname.php 
  
   Once the page is published, note its  id (at the top near title)

#. Edit  page "Software" and  update the software item in the table with the page id link, for example: ::

       <td width="20%">CSMOL</td>
       becomes
       <td width="20%"><a href="?page_id=1032">CSMOL</a></td>

#. In Dashboard's "Appearance" menu choose "Widgets". 
   In "Sidebar Widget Area" menu on the right hand side of 
   the page choose widget "Text: Available Software".  
   Add html text for the new software per already existing style. Need page id and software name, for example: ::

       <tr class="swbar">
       <td class="left"><a href="?page_id=909"><?php show_thumimg('opal'); ?> Opal</a></td>
       </tr>

   Here name *opal* is used for getting thum image, *Opal* is sw item name, and *909* is Opal page_id in wordpress

Turn off comments on images
~~~~~~~~~~~~~~~~~~~~~~~~~~~

The usual method of turning off comments on posts and pages does not work on images. The workaround ::

       cd /var/www/html/wordpress2/wp-content/themes/graphene-nbcr
       cp /var/www/html/wordpress2/wp-content/themes/twentyten/attachment.php attachment.php
       cp /var/www/html/wordpress2/wp-content/themes/twentyten/loop-attachment.php loop-attachment.php
       Edit loop-attachment.php and put if statement around comments_template() call

Dealing with tables
~~~~~~~~~~~~~~~~~~~
Tables are generated with *WP-Table Reloaded* plugin.  

* Tables can be edited via a plugin
  but this is a lengthy update if tables had ordered info. 

* To ease updates of ordered tables, export all the tables as xml files
  and keep them in website/tables/. 

* When need a table update, edit a table xml file directly then import it into
  the needed table in the plugin. 

* New tables can be added as xml files. 

 
Change wordpress host fqdn 
---------------------------

#. save htaccess ::

    cp /var/www/html/wordpress2/.htaccess /var/www/html/wordpress2/htaccess.save

#. save text widgets: ::

     login to wordpress admin interface, 
     in Appearance->Widgets->Sidebar Widget Area open Text widgets 
         Available software 
         Available web services 

   copy and save text.

#. dump current db ::

    cd /root/wp
    mysqldump -u root -p wpdb > dump.sql
    cp dump.sql rocce-vm0.sql

#. change to new server fqdn ::

      sed -i "s/www2\.nbcr\.net/nbcr\.ucsd\.edu/g" dump.sql
      vim dump.sql
      cat dump.sql | /usr/bin/mysql -u wpadmin -p wpdb
    
   Note: the following commands suggested for server name change did not work
   and resulted in all pages reloading to home page. The multisite may be an issue  ::

      mysql - root -p
      mysql> UPDATE wp_options SET option_value = replace(option_value, 'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2') 
             where option_name = 'home' OR option_name = 'siteurl';
      mysql> UPDATE wp_posts SET guid = replace(guid,'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2');
      mysql> UPDATE wp_posts SET post_content = replace(post_content, 'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2');
      mysql> UPDATE wp_links SET link_url = replace(link_url, 'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2');


#. Check all the files in wordpress2/ 
   and change all occurences of old FQDN to new one ::

    cd /var/www/html/wordpress2/
    grep -r -l www2.nbcr.net .

   Edit all listed files and make corrections. 

#. Login to wordpress web admin interface 
   and recreate text widgets for software and web servers 
   if they are no longer present. Use  text saved in *save text widget* above.


