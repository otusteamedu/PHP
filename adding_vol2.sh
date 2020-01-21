#!/bin/bash
a=$1
b=$2
echo | awk -v x=$a -v y=$b -f sum.awk
exit 0
