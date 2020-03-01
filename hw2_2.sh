#!/bin/bash
x=$(wc -l city.txt)

tail -$x | awk {'print $3'} | sort | uniq -c | sort -nr | head -3 | awk {'print $2'}