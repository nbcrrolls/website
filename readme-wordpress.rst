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
     mysql>UPDATE wp_options SET option_value = replace(option_value, 'http://old.ucsd.edu/wordpress2', 'http://new.ucsd.edu/wordpress2') 
           where option_name = 'home' OR option_name = 'siteurl';
     mysql>select * from wp_options where option_value='http://new.ucsd.edu/wordpress2';
     mysql>UPDATE wp_posts SET guid = replace(guid,'http://old.ucsd.edu/wordpress2', 'http://new.ucsd.edu/wordpress2');
     mysql>UPDATE wp_posts SET post_content = replace(post_content, 'http://old.ucsd.edu/wordpress2', 'http://new.ucsd.edu/wordpress2');

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

