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
 

