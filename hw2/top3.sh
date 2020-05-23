#!/bin/bash

awk -F " " '{print $3}' ./cities.txt | sort | uniq -c | sort -r | head -3