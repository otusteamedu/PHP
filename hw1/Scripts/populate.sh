#! /bin/bash

fileName=$1

cat $fileName | tail -n +2 | awk -F " " '{print $3}' | sort | uniq -c | head -n 3 | sort
