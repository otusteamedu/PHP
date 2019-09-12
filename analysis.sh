#!/bin/bash
head ./table.txt  |  awk 'NR==1, NR==5 {print $4, $3}' |sort -r  |uniq   | head -n4  | tail -3|awk '{print $2}'








