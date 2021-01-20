#!/bin/bash
awk '{print $3}' $1 | sort | uniq -c | sort -nr | head -3