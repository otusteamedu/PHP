#!/bin/bash

_file="${1:-"$( dirname "$( readlink -e "$0" )" )/users.txt"}"

cut -sf 3 < "$_file" | sed "1d" | sort | uniq -ic | sort -nr | head -3
