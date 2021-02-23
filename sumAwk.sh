#!/bin/bash

echo $_ |
awk 'BEGIN { REGEX_NUMBER="^-?[0-9]*[.]?[0-9]+$"; \
  if ('$1' !~ REGEX_NUMBER) print "The first parameter is not a number"; \
  if ('$2' !~ REGEX_NUMBER) print "The second parameter is not a number"; \
  sum = '$1' + '$2'; print "'$1' + '$2' = "sum; \
}'
exit 0
