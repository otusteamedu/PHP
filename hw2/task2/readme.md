Команда:
```bash
awk '/[0-9]+/ {print $3}' in.txt | sort |  uniq -c -i | sort -r -n | head -n 3
```
