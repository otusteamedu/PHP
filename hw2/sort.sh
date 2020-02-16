#!/bin/bash

awk 'NR > 1 { print $3 }' data.txt |sort|uniq -c|sort -rn|head -3


