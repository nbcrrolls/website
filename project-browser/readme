.. highlight:: rest
.. contents::

NBCR Project Browser
=======================

This file explains how to create html distribution for the project browser

Writign CSP and DBP files
-----------------------------

This section explains how to write DBP and CSP files

The following files are needed for each project X (X is a number) : ::

    raw text file cspX or dbpX in a specific format
    image file cspX.png or dbpX.png 

The text files are added to dbps-csps/ and image files are added to dbps-csps/images/ 
When dbp/csp files are updated a new html distributiion (see below) is created and put
on the web site. 

Tex file format 
------------------

The format is a "Section" line followed by the content lines for the section.
Most secionts have a single line of content except where noted. 
The following sections are  available ::

**CSP Number** -   project number 
**PI** - Project PI's name
**INSTITUTION** - organization name
**PROJECT TITLE** -  project title
**BTRC PERSONNEL** - personnel names separated by commas. If a first name starts with "R" or "L" escape with "\"
**TR&D PROJECT** - list core numbers (1-4)
**STATUS** - new, continued, or completed
**EXTERNAL FUNDING** - list project grants
**RELEVANT PUBICATIONS** - one publication per line. Each line includes authors, title and publisher info.
**IMAGE** - if there is an image for the project description 2 lines must follow  this section: ::
    #. image file name, a convention is cspX.png or dbpX.png where X is a project number
    #. image caption (single line).  
**DESCRIPTION**  - multiline description. Separate desired paragraphs by empty lines.

Here is an exmple of a project text file: ::

   CSP Number
   1
   PI
   Last, First M.I.
   INSTITUTION
   University of City, City, State
   PROJECT TITLE
   This project title 
   BTRC PERSONNEL
   \R. First, P. Second, J. Third
   TR&D PROJECT
   Cores 1, 2, and 4
   STATUS
   New
   EXTERNAL FUNDING
   NIH/NIGMS RXX XXYYZZ 9/2012-8/2017
   RELEVANT PUBLICATIONS
   K. L. One, C. D. Two, N. Three, S. R. Four, and A. A. FIve (2013). Some article title. Proc Natl Acad Sci U S A XYZ: 10XXX-10YYY
   A. Two and A. B. Three (2012). The role of articles in conformational transitions. PLoS Comput Biol X: e100XYZ.
   IMAGE
   csp1.png
   Overview of strategy for drug discovery.
   DESCRIPTION
   Ras proteins are key regulators of diverse cell-signaling pathways. 
   more lines here for the first paragraph. 
   
   We start second paragraph here. We hypothesize that writing more lines is beneficial 
   if they have useful information. Write more linse here. more lines can be added below. 
   
   Here can add more lines for the figure caption. The figure shows an overview and we give an 
   explanation of what can not fit in the caption here. 
   
Creating the html distribution 
--------------------------------

Create html distro for NBCR's project-browser.
This section os for the persons dealign with creating html context form raw csp/dbp files
and installgin the resultign distro.

   #. dbps-csps/  - contains all raw DBP and CSP project files
      and scripts to create html files
   #. on host with Sphinx-enabled python run run.sh in dbps-csps/
      this will create projects.tar.gz. 
   #. mv projects.tar.gz to this directory and run distro.sh
      to create project-browser.tar.gz 

4. copy project-browser.tar.gz to NBCR website host and untar in /var/www/html/
   (change permissions on resulting project-browser/ )
