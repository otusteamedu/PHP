#!/bin/bash


head  ./table.txt|tail -n+2  |  awk '{print $3}'| sort | uniq -c |  awk '{print $1,$2}'| sort -nr |  head -n3 | awk '{ print $2 }'






