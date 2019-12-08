#!/bin/bash

PATH_SCRIPT=`readlink -e "$0"`
DIRECTORY=`dirname "$PATH_SCRIPT"`
cd $DIRECTORY

cat table.txt | grep -v 'id user city phone' | awk '{print $3}' | sort | uniq -c | sort -nrk1 -k2i | head -n 3
