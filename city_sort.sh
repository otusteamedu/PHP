#!/bin/bash

f=$1

awk 'FNR>1 {print $3}' $f | sort | uniq -ci | sort -r | head -n3