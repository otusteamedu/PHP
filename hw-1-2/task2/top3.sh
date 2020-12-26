#!/bin/bash

awk 'NR!=1 { print $3 } ' ./table.txt | sort |  uniq -c | sort -r | awk '{ print $2 }' | head -3
