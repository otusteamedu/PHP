#!/bin/bash

file=$1

awk '$3 != "city" { print $3 }' $file | sort | uniq --count | sort --key 1nr --key 2 | awk '{ print $2 }' | head --lines 3