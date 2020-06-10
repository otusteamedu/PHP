#!/bin/bash

awk '{ if(NR>1) print $3 }' cities.txt  | sort | uniq -c | sort -nr | awk '{print $1,$2}'| head -n 3 | awk '{ print $2 }'