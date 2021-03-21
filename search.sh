#!/bin/bash

tail -n +2 db | awk '{print $3}' | sort | uniq -c | sort -r | head -n3 | awk '{print $2}'
