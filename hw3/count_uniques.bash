awk -F ' ' 'NR>1{arr[$3]++}END{for (a in arr) print a, arr[a]}' sample.txt | sort -k2 -rn | head -3
