cat users.txt && echo  &&  cat users.txt | awk '(NR > 1) {printf $3"\n"}' | sort | uniq -c | sort -r
