.. highlight:: rest

Wordpress installation and management
======================================

Initial wordpress configuration
--------------------------------

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

Directories for custom files. Not editable directly via wordpress dashboard. 
Used by custom functions and php templates.  Any updates are simply drop-in 
a new file in a location. The file must conform to naming convention and format. 

**bin/** -  scripts used by finctions.php

**docs/** - specific docs snippets ::

    citations/ - for software citations. Each file is for a specific software item.
                 Naming: same as software item, filename extention signifies the format: 
                 *bibtext, plain or endnote*.  Can have 0 - 3 files per software item. 
    licenses/ - for software licenses, one file per software item. Format: plain ascii. 
                 Naming: same as software item, no extention. 

**images/** - categorize images ::

    headers/ - main page header images 960x100
    highlights/ - highlights pages images
    logos/ - logo images
    people/ - people photos, approx. 250x300
    posts/   - post images, names consistent with post title (ex: chagas for chagas). Size 1000x616
    sw/      - software logos
    sw/thum/ - software logo thums, created from logo images. size 27x16
    users/   - image maps 
    
**people/** - contain php files for people and phph templates for showing them ::

    people-options-defaults.php - default options
    people-layout.php - layout of the people item on the page
    blank.php - blank template with all needed variables
    NAME.php - each person's php file ( NAME = first initial + lastname)
    
**stats/** - statistics pages, html files created with google chart. Need updates for yearly stats.
Displayed under *Statistics* page.

**sw/**  - contains php files for software items and php templates for showing them ::

    switem-options-defaults.php - default options
    switem-layout.php - layout of the sw item on the page
    template.php - blank template with all needed variable
    NAME.ph - each software NAME item

Adding a new sw item 
~~~~~~~~~~~~~~~~~~~~~~~

#. Check sw name lineup below, if name is not there, add it and update numerical order below
   and also on all respective software pages that change due to new item. The chages will be in "Order"
   in page attributes section: ::
  
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

#. add software images as ::
     
     images/sw/swname.png
     images/sw/thum/swname.png  (image size 27x16)
     images will be scaled according to nbcr.css style settings

#. create new page with a title as a name of the software item
   in "Page Attributes" section set using menues ::

      Parent: Software
      Template: Software Item
      Order: check number in file linup
      in "Custom Fields" under "Name" menu select "filename" and add
      in corresponding "Value"  field a file name as sw/swname.php 
  
    Once the page is published, note its page id (at the top near title)

#. Edit  page "Software" and  update the software item in the table with the page id link, for example: ::

     <td width="20%">CSMOL</td>
     becomes
     <td width="20%"><a href="?page_id=1032">CSMOL</a></td>

#. In Dashboard's "Appearance" menu choose "Widgets". In "Sidebar Widget Area" menu on the right hand side of 
   the page choose widget "Text: Available Software".  Add html text for the new software per already existing 
   style. Need page id and software name, for example: ::

       <tr class="swbar">
       <td class="left"><a href="?page_id=909"><?php show_thumimg('opal'); ?> Opal</a></td>
       </tr>

   Here name *opal* is used for getting thum image, *Opal* is sw item name, and *909* is Opal page_id in wordpress

Turn off comments on images 
~~~~~~~~~~~~~~~~~~~~~~~~~~~~
There is a  way to turn comments off on individual 
posts and pages (via admin dashboard) but not on images. This is a work around.

::

   cd /var/www/html/wordpress2/wp-content/themes/graphene-nbcr
   cp /var/www/html/wordpress2/wp-content/themes/twentyten/attachment.php attachment.php
   cp /var/www/html/wordpress2/wp-content/themes/twentyten/loop-attachment.php loop-attachment.php

Edit *loop-attachment.php* and put *if* statement around *comments_template()* call


Change wordpress host IP 
--------------------------------

