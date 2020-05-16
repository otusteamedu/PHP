#!/usr/bin/env bash
cat table.txt | tail -n +2 | awk -F\  '{ cnt[$3]++ } END { for (i in cnt) print cnt[i], i }' | sort -nr | head -3