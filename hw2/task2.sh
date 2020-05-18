#!/bin/bash

FILE=$1

if [ ! -r "$FILE" ]; then
    echo "File \"$FILE\" does not exist or is not readable";
    exit 1;
fi

tail -n +2 "$FILE" | awk '{print $3}' | sort | uniq -ic | sort -nr | head -3
