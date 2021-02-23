#!/bin/bash

awk -f cities.awk users.txt |
sort |
uniq -c |
sort -nr |
awk '{ print $2 }' |
head -3
