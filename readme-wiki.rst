Set up wiki
------------

#. Point browser to http://your.host.name/wiki and follow a set up link.

#. A link opens the installation from  to fill in 

   **Site config** ::

     Wiki name: choose
     Contact e-mail: choose
     Language: en - English

     Copyright/license: choose No license metadata

     Admin username: create 
     Password: create

     Object caching: choose No caching

   **E-mail, e-mail notification and authentication setup** ::

     E-mail features (global): choose Enabled
     User-to-user e-mail: choose Disabled
     E-mail notification about changes: choose  Enabled for changes to user discussion pages...
     E-mail address authentication: choose Enabled

   **Database config** ::

     Database type: coose MySQL
     Database host: localhost:/var/lib/mysql/mysql.sock

   NOTE: host must contain location of mysql socket similar to above.  ::

     Database name: wikidb
     DB username: create
     DB password: create

     Superuser account: select  "Use superuser account"
     Superuser name: root
     Superuser password: fill in

   **MySQL-specific options** ::

     Database table prefix: leave empty
     Storage Engine:  choose InnoDB

     Database character set: choose MySQL 4.1/5.0 UTF-8

   Click on ``Install MediaWiki`` button.  

   A screen will show an error or a successfull configuration 

#. Complete  installation

   move ``config/LocalSettings.php`` to the parent directory and change file permissions as ::
 
     chown apache:apache LocalSettings.php
     chmod 600 LocalSettings.php

Wiki modifucations
-------------------

#. Enable wiki uploads ::

     chown apache:apache /var/www/html/wiki/images
     Edit /var/www/html/wiki/LocalSettings.php:
       set $wgEnableUploads       = true;
       $wgUseImageMagick = true;
       add $wgFileExtensions = array('png','gif','jpg','jpeg','doc','xls','mpp','pdf','ppt','tiff','bmp','docx', 'xlsx', 'pptx','ps','odt','ods','odp','odg', 'txt');
       add $wgVerifyMimeType=false;
    
   NOTE: put all needed file extensions in the array above

#. Change upload file size ::

    Edit /etc/php.ini and set :
        upload_max_filesize = 25M   (orig 2M)
        post_max_size = 28M         (orig 8M)

    /etc/init.d/httpd restart

   NOTE: the ``post_max_size`` must be bigger then ``upload_max_size``

#. Authorization changes

   Add the following lines to enable speciufic features in ``LocalSettings.php`` ::

     # Requires that users are registered before they can edit
     $wgGroupPermissions['*']['edit'] = false;

     # Hide user tools for anonymous (IP address) visitors
     $wgShowIPinHeader = false;

     # prevent account creation by anyone except sysops
     $wgGroupPermissions['*']['createaccount'] = false;

     # allow external imges linking
     $wgAllowExternalImages = true;

