#! /bin/bash

awk '{print $3}' ./users.txt | sort | uniq -c | sort -r | head -3
