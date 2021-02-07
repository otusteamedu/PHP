#!/bin/bash
echo "Самые популярные города у пользователей:"
awk -F" " 'NR > 1 {print $3}' users.txt | sort | uniq -c | sort -rn | awk -F " " '{print $2}' | head -3