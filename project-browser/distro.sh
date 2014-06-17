#!/bin/bash

# Create distro project-browser.tar.gz for all needed files for NBCR's project-browser

DIR=project-browser
PREREQ=projects.tar.gz
# these are part of $PREREQ
DIVfiles="div-csp div-dbp"

if [ ! -f $PREREQ ] ; then
    echo "Missing distro $PREREQ file. "
	echo "Please make distro file in dbps-csps/ using run.sh (need host with  Sphinx-enabled python)"
	exit 1
fi

# copy jquery files
mkdir $DIR
cp -p -r lib $DIR

# copy prereq files
tar xzf $PREREQ
mv projects $DIR

# create main index.html file
cat index.head $DIVfiles index.tail > $DIR/index.html

# create distro for installation in /var/www/html
tar czf $DIR.tar.gz $DIR
rm -rf $DIR $DIVfiles
echo "Created $DIR.tar.gz file. Install (untar) on website host in /var/www/html/"

