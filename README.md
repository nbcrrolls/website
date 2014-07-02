This repository contains NBCR website (wordpress) and wiki
related  files.

Contents
---------

* **tables/** - all tables from WP-Table Reloaded plugin. 
The tables were exported as xml files and can be imported back into the pligin
after the update. 

* **graphene-nbcr/** - theme used for NBCR web site, based on graphene theme. 
  
* **graphene-nbcr/stats/** -  html files created with Google Charts scripting
to produce nbcr stats. Can be used as html pages and to produce images from html pages. 

* **scripts/** 
  - wp-backup - backup of wordpress and its db
  - www-backup - backup of /var/www/html/*
  - create-ssl-request.sh - create SSL certificate request, see http://syswiki.ucsd.edu/index.php/SSL_certs

* **readme-wordpress.rst** -  nbcr-specific wordpress howto

* **collaborator/** - php forms for collaborator application

* **workflows/** 
  - js code to show kepler workflows availability ( adapted from code by kepler group)
  - workflows (from Amaro lab):

    * Clustering: TrajectoriesConcatenate
    * Electrostatic: LigandParameterization  PDB2PDBQT
    * Utilities: CreateDirectoryCopy
 

Enable captcha (done on vm1 as a test, still TODO)
----------------
Enable captcha in grunion contact form plugin:
* replace plugin file grunion-contact-form.php with  modified  per http://wordpress.org/support/topic/captcha-needed-for-grunion-contact-form

* get public and private recaptcha keys from google and put in the grunion-contact-form.php:  
	Step 1 log into your google account  
	Step 2 type recaptcha in google search and get to https://www.google.com/recaptcha site  
        Step 3 click on "Get reCAPTCHA" button  
	Step 4 ON  a new page that starts with  "Use reCAPTCHA ON YOUR SITE" Click "Sign up Now!"  
	Step 5 follow directions to create keys  

* mkdir includes/ (inside the grunion plugin directory)

* touch includes/index.php

* download recaptcha library from http://code.google.com/p/recaptcha/ and put the file recaptchalib.php 
  in includes/
