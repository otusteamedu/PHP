#!/bin/bash

eval "awk 'NR>1 {print \$3}' table.txt | sort | uniq -c -i | sort -r | head -n3"