# Файл test.txt - исходный файл с таблицей
cat test.txt | awk 'NR>1{print $3}' | sort | uniq -c | sort -r | head -n3 | awk {'print $2'}