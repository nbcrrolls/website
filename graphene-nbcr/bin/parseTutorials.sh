#!/bin/bash

path=$1
files=`ls $path/*php`
for file in $files
do
	name=`basename $file .php`
	str=`grep tutorial $file | grep -v "=>"`
        [ "$str" == "" ] && continue 
        part1=${str#*=}
        part2=${part1#* }
        part3=${part2%;*}
        [ "$part3" == "''" ] && continue 
        echo $name "$part3"
done
