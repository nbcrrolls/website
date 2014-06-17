#!/bin/bash

# clean old distro
make clean

# create rst files from raw files
echo "Creatikng dbp files"
./makeRst dbp
echo "Creatikng csp files"
./makeRst csp

# create html files from rst
make html

# create tar of all html and div files as projects.tar.gz: div-* projects/*
make tar
