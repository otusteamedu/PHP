#!/bin/bash

head ./table.txt|tail -n+2   |  awk '{print $4,$3}' |  awk '{print $1,$2}' | sort -n -r |awk '{print $2}'|head -n3







