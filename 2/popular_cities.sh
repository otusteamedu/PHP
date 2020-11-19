#!/bin/bash

awk '{print $3}' cities.txt | tail +2 | sort | uniq -c | head -3 | awk '{print $2}'

