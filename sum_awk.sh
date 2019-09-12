 #!/bin/bash

echo "$1|$2" | awk -F'|' '{sum = $1 + $2} END {print sum}'
