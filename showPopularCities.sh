#!/bin/bash
echo "Три наиболее популярных города:"
awk '3 != "city" {print $3}' users.tbl | sort | uniq -c | sort -r | head -3 | awk '{print "Popular city: " $2}'
exit 0
