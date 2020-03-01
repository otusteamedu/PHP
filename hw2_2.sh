#!/bin/bash
x=$(wc -l city.txt)

tail -$x | awk {'print $3'} | sort -r | uniq -d | head -3