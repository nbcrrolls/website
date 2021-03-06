.. highlight:: rest
.. contents:: NBCR wordpress installation and management

Initial wordpress configuration
--------------------------------

Install newer version of wordpress as /var/www/html/wordpress2

Make redirect on the server, tell apache to use wordpress2 ::

    vim /var/www/html/index.html
    change from  URL=/wordpress/ to  URL=/wordpress2/

Create a wordpress database ``wpdb`` and set permissions. Use real values for ``USER`` and ``PASS`` ::

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
                   a single software item. Naming convention: swname.ext where swname is
                   a software item name form the software list (see below) and ext specifies  
                   file format  and can be  bibtext, plain pr bibtex.
      licenses/  - for  licenses, if needed by the software. Naming convention: swname, format is ascii.

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
      swname.php  - for each software item, swname is software item name from the software list below. 

 
Adding a new sw item 
~~~~~~~~~~~~~~~~~~~~~~

#. Check sw name lineup below, if name is not there, add it. ::

    ADT         CADD            iAPBS           PMV
    AMD         Continuity      MEME            POVME
    APBS        CSMOL           MGLTools        SMOL
    Autoclick   ePMV            NNScore         TxBR
    AutoGrow    FETK            Opal            
    Browndye    Gamer           PDB2PQR

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
         Order: 1
         in "Custom Fields" under "Name" menu select "filename" and add
         in corresponding "Value"  field a file name as sw/swname.php 
  
   Once the page is published, note its  id (at the top near title)

#. Edit  page "Software" and  update the software item in the table with the page id link, for example: ::

       <td width="20%">CSMOL</td>
       becomes
       <td width="20%"><a href="?page_id=1032">CSMOL</a></td>

#. In dashboard's ``Appearance`` menu choose ``Widgets``. 
   In ``Sidebar Widget Area`` menu on the right hand side of 
   the page choose widget ``Text: Available Software``.  
   Add html text for the new software per already existing style (find
   its position in alphabetical order shown in ``Software`` page). 
   Need page id and software name, for example: ::

       <tr class="swbar">
       <td class="left"><a href="?page_id=909"><?php show_thumimg('opal'); ?> Opal</a></td>
       </tr>

   Here name ``opal`` is used for getting thum image, ``Opal`` is sw item name, and ``909`` is Opal page id in wordpress.

Turn off comments on images
~~~~~~~~~~~~~~~~~~~~~~~~~~~

The usual method of turning off comments on posts and pages does not work on images. The workaround ::

       cd /var/www/html/wordpress2/wp-content/themes/graphene-nbcr
       cp /var/www/html/wordpress2/wp-content/themes/twentyten/attachment.php attachment.php
       cp /var/www/html/wordpress2/wp-content/themes/twentyten/loop-attachment.php loop-attachment.php
       Edit loop-attachment.php and put if statement around comments_template() call

Dealing with tables
~~~~~~~~~~~~~~~~~~~
Tables are generated with ``WP-Table Reloaded`` plugin.  

* Tables can be edited via a plugin
  but this is a lengthy update if tables had ordered info. 

* To ease updates of ordered tables, export all the tables as xml files
  and keep them in website/tables/. 

* When need a table update, edit a table xml file directly then import it into
  the needed table in the plugin. 

* New tables can be added as xml files. 

Dealing with tabs
~~~~~~~~~~~~~~~~~~~
Tabs are generated via ``Post UI tabs`` plugin. To change the settings for plugin 
use  plugin configuration in ``Settings``.

Tabs are created with the code :: 

    [tab name="name 1"] content goes here ... [/tab]
    [tab name="name 2"] content goes here ... [/tab]
    [tab name="name 3"] content goes here ... [/tab]
    [end_tabset]
 
Change wordpress host fqdn 
---------------------------

#. Save htaccess ::

    cp /var/www/html/wordpress2/.htaccess /var/www/html/wordpress2/htaccess.save

#. Save text widgets: ::

     login to wordpress admin interface, 
     in Appearance->Widgets->Sidebar Widget Area open Text widgets 
         Available software 
         Available web services 

   copy and save text.

#. Dump current db ::

    cd /root/wp
    mysqldump -u root -p wpdb > dump.sql
    cp dump.sql rocce-vm0.sql

#. Change to new server fqdn ::

      sed -i "s/www2\.nbcr\.net/nbcr\.ucsd\.edu/g" dump.sql
      vim dump.sql
      cat dump.sql | /usr/bin/mysql -u wpadmin -p wpdb
    
   Note: the following commands suggested for server name change did not work
   and resulted in all pages reloading to home page. The multisite may be an issue  ::

      mysql - root -p
      mysql> update wp_options set option_value = replace(option_value, 'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2') 
             where option_name = 'home' OR option_name = 'siteurl';
      mysql> update wp_posts set guid = replace(guid,'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2');
      mysql> update wp_posts set post_content = replace(post_content, 'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2');
      mysql> update wp_links set link_url = replace(link_url, 'http://rocce-vm0.ucsd.edu/wordpress2', 'http://www2.nbcr.net/wordpress2');


#. Check all the files in wordpress2/ 
   and change all occurences of old FQDN to new one ::

    cd /var/www/html/wordpress2/
    grep -r -l www2.nbcr.net .

   Edit all listed files and make corrections. 

#. Login to wordpress web admin interface 
   and recreate text widgets for software and web servers 
   if they are no longer present. Use  text saved in *Save text widget* above.


Move wordpress to another host 
-------------------------------

On old host dump the wordpress and its db ::

    cd  /var/www/html
    tar czf www-wordpress.tar.gz wordpress2
    scp www-wordpress.tar.gz my.new.host:/tmp

    mysqldump -u USER -pPASS DB | gzip > wpdb.sql.gz
    scp wpdb.sql.gz my.new.host:/tmp

On new host
 
#. Restore wordpress files ::

     cd /var/www/html
     tar xzvf /tmp/www-wordpress.tar.gz 

#. Start mysql if not running ::

     ps -ef | grep mysqld
     /sbin/chkconfig --add mysqld
     /sbin/chkconfig --list mysqld
     /etc/init.d/mysql start

#. Add root password for mysql access if not present ::

     /usr/bin/mysqladmin -u root password 'PASS'
     /usr/bin/mysqladmin -u root -h my.new.host password 'PASS'

#. Create a wordpress database ``wpdb`` and set permissions. ::

     mysqladmin create wpdb -p
     mysql -u root -p
     mysql> grant all privileges on wpdb.* to 'USER'@'localhost' identified by 'PASS';

#. Restore wp db content from a backup ::

     cd /tmp
     zcat wpdb.sql.gz | /usr/bin/mysql --user USER -p wpdb

#. Update settings in the database to new urls ::

     /usr/bin/mysql -u root -p wpdb
     mysql>update wp_options set option_value = replace(option_value, 'http://old.ucsd.edu/wordpress2', 'http://new.ucsd.edu/wordpress2') 
           where option_name = 'home' OR option_name = 'siteurl';
     mysql>update wp_posts set guid = replace(guid,'http://old.ucsd.edu/wordpress2', 'http://new.ucsd.edu/wordpress2');
     mysql>update wp_posts set post_content = replace(post_content, 'http://old.ucsd.edu/wordpress2', 'http://new.ucsd.edu/wordpress2');

   On rocce-vm1 fixed with additional ::

       # for cardiacphysiome site
       update wp_2_options set option_value = replace(option_value, 'nbcr.ucsd.edu', 'rocce-vm1.ucsd.edu');
       update wp_2_posts set guid = replace(guid, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_2_posts set post_content = replace(post_content, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_2_posts set pinged = replace(pinged, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_2_links set link_url = replace(link_url, 'http://nbcr.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu/wordpress2');
       update wp_2_postmeta set meta_value = replace(meta_value,'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_2_comments set comment_author_url = replace(comment_author_url,'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_2_blogs set domain=replace(domain,'nbcr.ucsd.edu','rocce-vm1.ucsd.edu');

       # for prime site
       update wp_3_options set option_value = replace(option_value, 'nbcr.ucsd.edu', 'rocce-vm1.ucsd.edu');
       update wp_3_posts set guid = replace(guid, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_3_posts set post_content = replace(post_content, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_3_posts set pinged = replace(pinged, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_3_links set link_url = replace(link_url, 'http://nbcr.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu/wordpress2');
       update wp_3_postmeta set meta_value = replace(meta_value,'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_3_comments set comment_author_url = replace(comment_author_url,'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_3_blogs set domain=replace(domain,'nbcr.ucsd.edu','rocce-vm1.ucsd.edu');

       # for SI site
       update wp_4_options set option_value = replace(option_value, 'nbcr.ucsd.edu', 'rocce-vm1.ucsd.edu');
       update wp_4_posts set guid = replace(guid, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_4_posts set post_content = replace(post_content, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_4_posts set pinged = replace(pinged, 'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_4_links set link_url = replace(link_url, 'http://nbcr.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu/wordpress2');
       update wp_4_postmeta set meta_value = replace(meta_value,'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_4_comments set comment_author_url = replace(comment_author_url,'http://nbcr.ucsd.edu', 'http://rocce-vm1.ucsd.edu');
       update wp_4_blogs set domain=replace(domain,'nbcr.ucsd.edu','rocce-vm1.ucsd.edu');
       
       # for main site tables 
       update wp_options set option_value = replace(option_value, 'http://nbcr.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu/wordpress2') where option_name = 'home' OR option_name = 'siteurl';
       update wp_posts set post_content = replace(post_content, 'http://nbcr.ucsd.edu/wordpress2','http://rocce-vm1.ucsd.edu/wordpress2');
       update wp_posts set post_title = replace(post_title, 'http://nbcr.ucsd.edu/wordpress2','http://rocce-vm1.ucsd.edu.wordpress2');
       update wp_posts set pinged = replace(pinged, 'http://nbcr.ucsd.edu/wordpress2','http://rocce-vm1.ucsd.edu/wordpress2');
       update wp_posts set guid = replace(guid, 'http://nbcr.ucsd.edu/wordpress2','http://rocce-vm1.ucsd.edu/wordpress2');
       update wp_links set link_url = replace(link_url, 'http://nbcr.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu/wordpress2');
       update wp_blogs set domain=replace(domain,'nbcr.ucsd.edu','rocce-vm1.ucsd.edu');

       update wp_site set domain = replace(domain, 'nbcr.ucsd.edu', 'rocce-vm1.ucsd.edu')
       update wp_sitemeta set meta_value = replace(meta_value, 'http://nbcr.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu/wordpress2') where meta_key = 'siteurl';


Enable Google Analytics
-----------------------

#. Create google account.
   There was already an account set for nbcr.net.  Login with personal credentials. ::

    Create new property and new view (for nbcr.ucsd.edu). 
    Click on the Admin page on the right side after login
    Select a account from the dropdown list in the Account column
    In property column click on tracking info
    Click on the tracking code then copy the code

   Tracking code  ::

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-890371-2', 'ucsd.edu');
      ga('send', 'pageview');
    
    </script>

#. Add tracking code to wordpress ::

    Login to your WordPress blog as admin
    Click on Appearance then click Graphene Options. In the body of the page under General tab
    find Google Analytics Options tab and open it. Paste the tracking code where directed and check
    Enabling ... button. Click on Save options button at the end of the frame.

   Note: It mabe be better to add the Google analytics code just before ``</head>``
   in the ``head.php`` theme file. Double check the results of analytics.

#. Add the same code snippet 
   to /var/www/html/index.html


Enable captcha  on Contact form
--------------------------------

Enable captcha in grunion contact form plugin  in wordpress2/wp-content/plugins/grunion-contact-form/  

#. replace plugin file grunion-contact-form.php with modified  per http://wordpress.org/support/topic/captcha-needed-for-grunion-contact-form 

#. get public and private recaptcha keys from google and put in the grunion-contact-form.php:  

   - Step 1 log into your google account  
   - Step 2 type recaptcha in google search and get to https://www.google.com/recaptcha site  
   - Step 3 click on "Get reCAPTCHA" button  
   - Step 4 In a new window  "Click "Sign up Now!"  
   - Step 5 follow directions to create keys 
        
#. mkdir includes/  

#. touch includes/index.php  

#. download recaptcha library from http://code.google.com/p/recaptcha/ and put the file recaptchalib.php 
   in includes/

Move wordpress configuration  to root
-------------------------------------

2016, Feb. Request to remove wordporess2/ from the website. 
Need to move wordpress installation to root. 
None of the recipes in http://codex.wordpress.org/Moving_WordPress#Moving_WordPress_Multisite 
work. They are for a single site only.  Per this link https://codex.wordpress.org/Changing_The_Site_URL need to do a manual change.

#. back up wpdb and /var/www/html/wordpress2/

#. find all occurences of wordpress2/ in files in wordpress2/ :: 

      # cd /var/www/html/wordpress2/ 
      # find -l -r wordpress2 . 

   - in .htaccess comment out line RewriteBase /wordpress2/
   - in wp-config.php substitute ``/wordpress2/`` with ``/``
   - in all other files  rm wordpress2/ 

#. move all files fromn wordpress2 ::

      # cd /var/www/html
      # mv wordpress2/* .
      # mv wordpress2/.htaccess .

#. update wpdb entries ::

      # mysql -u root -p
      mysql> use wpdb; 
      execute the following queries
      update wp_3_options set option_value = replace(option_value, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu') where option_name = 'home' OR option_name = 'siteurl';
      update wp_3_posts set guid = replace(guid, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_3_posts set post_content = replace(post_content, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_3_links  set link_url = replace(link_url, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');

      update wp_2_options set option_value = replace(option_value, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu') where option_name = 'home' OR option_name = 'siteurl';
      update wp_2_posts set guid = replace(guid, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_2_posts set post_content = replace(post_content, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_2_links  set link_url = replace(link_url, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');

      update wp_4_options set option_value = replace(option_value, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu') where option_name = 'home' OR option_name = 'siteurl'; 
      update wp_4_posts set guid = replace(guid,'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_4_posts set post_content = replace(post_content, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_4_links  set link_url = replace(link_url, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');

      update wp_options set option_value = replace(option_value, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu') where option_name = 'home' OR option_name = 'siteurl'; 
      update wp_posts set guid = replace(guid, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_posts set post_content = replace(post_content, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');
      update wp_links  set link_url = replace(link_url, 'http://rocce-vm1.ucsd.edu/wordpress2', 'http://rocce-vm1.ucsd.edu');

      update wp_site set path = replace(path, '/wordpress2/', '/');
      update wp_blogs set path = replace(path, '/wordpress2/', '/');

   This is done on a test server first (already updated wordpress 4.x. 
   Do similar on main server. 

   on a test server can see the other 3 sites but cardyac physiome has a link to point to main server
   on a main server none of the site blogs are awailalbea. Get an error:
   ``The requested URL /cardiacphysiome/wp-admin/ was not found on this server.``

   **FIX**  Redo mdultiple quieries, clean the order, simplify, the result
   should be ::

       update wp_2_options set option_value = replace(option_value, '/wordpress2','');
       update wp_2_posts set guid = replace(guid, '/wordpress2','');
       update wp_2_posts set post_content = replace(post_content, '/wordpress2','');
       update wp_2_posts set pinged = replace(pinged, '/wordpress2','');
       update wp_2_links set link_url = replace(link_url, '/wordpress2', '');
       update wp_2_postmeta set meta_value = replace(meta_value, '/wordpress2','');
       update wp_2_comments set comment_author_url = replace(comment_author_url,'/wordpress2','');

       update wp_3_options set option_value = replace(option_value, '/wordpress2','');
       update wp_3_posts set guid = replace(guid, '/wordpress2','');
       update wp_3_posts set post_content = replace(post_content, '/wordpress2','');
       update wp_3_posts set pinged = replace(pinged, '/wordpress2','');
       update wp_3_links set link_url = replace(link_url, '/wordpress2', '');
       update wp_3_postmeta set meta_value = replace(meta_value, '/wordpress2','');
       update wp_3_comments set comment_author_url = replace(comment_author_url,'/wordpress2','');

       update wp_4_options set option_value = replace(option_value, '/wordpress2','');
       update wp_4_posts set guid = replace(guid, '/wordpress2','');
       update wp_4_posts set post_content = replace(post_content, '/wordpress2','');
       update wp_4_posts set pinged = replace(pinged, '/wordpress2','');
       update wp_4_links set link_url = replace(link_url, '/wordpress2', '');
       update wp_4_postmeta set meta_value = replace(meta_value, '/wordpress2','');
       update wp_4_comments set comment_author_url = replace(comment_author_url,'/wordpress2','');

       update wp_options set option_value = replace(option_value, '/wordpress2','');
       update wp_posts set guid = replace(guid, '/wordpress2','');
       update wp_posts set post_content = replace(post_content, '/wordpress2','');
       update wp_posts set pinged = replace(pinged, '/wordpress2','');
       update wp_links  set link_url = replace(link_url, '/wordpress2', '');
       update wp_sitemeta set meta_value = replace(meta_value, '/wordpress2','');
       update wp_tdomf_table_widgets set widget_value = replace(widget_value,'/wordpress2','');
       update wp_site set path = replace(path, '/wordpress2/', '/');
       update wp_blogs set path = replace(path, '/wordpress2/', '/');

Log
-----

* 2016-12-23

  update nbcr.conf apache file with 

  * add cache expiration  :: 

      ### EXPIRES CACHING 
      #<IfModule mod_expires.c>
      ExpiresActive On
      ExpiresDefault "access plus 1 month"
      ExpiresByType image/jpg "access plus 1 year"
      ExpiresByType image/jpeg "access plus 1 year"
      ExpiresByType image/gif "access plus 1 year"
      ExpiresByType image/png "access plus 1 year"
      ExpiresByType text/css "access plus 1 month"
      ExpiresByType application/pdf "access plus 1 month"
      ExpiresByType text/x-javascript "access plus 1 month"
      ExpiresByType application/x-shockwave-flash "access plus 1 month"
      ExpiresByType image/x-icon "access plus 1 year"
      #</IfModule>
      ### EXPIRES CACHING 

  * cache control headers ::

      ### BEGIN Cache-Control Headers, set caching to 4 weeks for each
      #<IfModule mod_headers.c>
        <filesMatch "\.(ico|jpg|jpeg|png|gif|swf)$">
          Header set Cache-Control "max-age=2419200, must-revalidate"
        </filesMatch>
      <filesMatch "\.(css)$">
        Header set Cache-Control "max-age=2419200"
      </filesMatch>
      <filesMatch "\.(js)$">
        Header set Cache-Control "max-age=2419200"
      </filesMatch>
      <filesMatch "\.(x?html?|php)$">
        Header set Cache-Control "max-age=2419200, must-revalidate"
      </filesMatch>
      <filesMatch "\.analytics.js$">
        Header set Cache-Control "max-age=2419200"
      </filesMatch>
      #</IfModule>
      ### END Cache-Control Headers

  * turn off etags ::

      ### Turn ETags Off
      #<ifModule mod_headers.c>
        Header unset ETag
      #</ifModule>
      FileETag None

      # Make sure proxies don't deliver the wrong content
      Header append Vary User-Agent env=!dont-vary
      <FilesMatch "\.(ico|pdf|flv|jpg|jpeg|png|gif|js|css|swf)$">
        Header set Expires "Sun, 31 Jan 2017 20:00:00 GMT"
      </FilesMatch> 
      ### Turn ETags Off

  * rm last modified header, leave commented out ::

      ### Remove Last-Modified Header
      #<ifModule mod_headers.c>
      #  Header unset Last-Modified
      #</ifModule>
      ### Remove Last-Modified Header

  * add compression ::

      # Compress only a few types
      AddOutputFilterByType DEFLATE text/plain text/css text/html text/xml
      text/javascript
      AddOutputFilterByType DEFLATE application/x-javascript application/javascript


* 2016-02-12 

  update themse:  graphene 1.9.4.2, magazine-basic, twentyten

  update plugins: formidable, global-content-blocks, captcha

  delete inactive plugins: akismet download-manager lightview-plus

  put simple-retail-menus tabby-responsive-tabs tdo-mini-forms thethe-image-slider wp-compare-tables wp-filebase 

* 2016-02-11 

  move multisite to root form wordpress2/

Search, indexing
------------------

#. submit site to search engines: 

   https://www.google.com/webmasters/tools/submit-url?continue=/addurl&pli=1
   http://www.bing.com/toolbox/submit-site-url
   
   Also submit  site map to Google via  Webmaster Tools  http://www.google.com/webmasters/tools
        
#. google search console 
    
   Use URL https://www.google.com/webmasters/tools/home?hl=en to get to the webmasters tools
   and click on the website link nbcr.ucsd.edu to get to the dashboard.
   Use Crawl menu to see errors, and stats. clean errors.
    
#. google analytics
   https://analytics.google.com/analytics

#. Check privacy option in wordpress. 2016-03-09
   
   Visit wp-admin/options.php of the blog. it's not linked to anywhere within the admin panel. 
   It's purpose is simply to show all of blog's configuration options -- anything placed in 
   the options table of the tabase. Be careful what you change within this screen!

   find the blog_public option in that list. If you want your blog to be indexed by search engines, 
   make sure blog_public option is set to 1 and save.

   Finally, check the blog and View Source. Ensure that the following bit of code does not appear::
   
       <meta name='robots' content='noindex,nofollow' />
    
   NOTE: blog_public was 0 as of 2016-03-09 on rocce-vm0 but 1 on test rocce-vm1. Not sure when or how
   the setting was changed. No direct access to this option.php page form admin pages unless typed verbatim.
   
#. see if google knows about the site and its pages ::

   site:nbcr.ucsd.edu
   info:nbcr.ucsd.edu
   
#. create sitemaap.xml 
   
   use https://www.xml-sitemaps.com/ to create sitemap.xml. Download, and edit to remove extras
   (attachments, old docs links, etc, erroneous links). UPload to website and install as sitemap.xml at /
   
   At google webtools search console https://www.google.com/webmasters/tools/sitemap-list?
   add new sitemap.  Test at the earch console, result : 407 pages submitted.

#. check google webmaster guidlines https://support.google.com/webmasters/answer/35769 

   see also guidlines as a list http://www.hobo-web.co.uk/webmaster-guidelines/
   
   Search engine optimization guide from google:
   http://static.googleusercontent.com/media/www.google.com/en//webmasters/docs/search-engine-optimization-starter-guide.pdf
   
#. enabling RSS feeds

   Normally, these are enabled by default. Check site via validator http://validator.w3.org/feed/

   The problem  with graphene-nbcr theme was in a few php files where there was an empty line outside of <?php ...?>
   Fix: remove empty lines and recheck with validator

Optimization, validation, performance
----------------------------------------

#. **Five free tools to improve yout website page load speed** 
   
   See an article at 
   http://www.itworld.com/internet/381129/five-free-tools-improve-your-websites-page-loading-time?source=ITWNLE_nlt_today_2013-11-02

   * Google PageSpeed Insights http://developers.google.com/speed/pagespeed/insights/
   * Pingdom Website Speed Test http://tools.pingdom.com/fpt/
   * Web Page Test http://www.webpagetest.org/
   * GTmetrix http://gtmetrix.com/
   * Web Page Analyzer http://www.websiteoptimization.com/services/analyze/

#. Test javascript using Javascript usage tool  https://varvy.com/tools/js/

Links for editing styles
-------------------------

#. animation delay property with css  http://www.w3schools.com/cssref/css3_pr_animation-delay.asp


Links
-------

* Installing on the root vs. a subdirectory  https://premium.wpmudev.org/forums/topic/installing-wordpress-on-the-root-vs-a-sub-directory
* moving https://codex.wordpress.org/Moving_WordPress
* robotx.txt fetch error  https://support.google.com/webmasters/answer/2409682?hl=en
* crawl errors ( need google login) https://www.google.com/webmasters/tools/crawl-errors?hl=en&authuser=0&siteUrl=http://nbcr.ucsd.edu/#t1=1
* updating https://codex.wordpress.org/Updating_WordPress
 
