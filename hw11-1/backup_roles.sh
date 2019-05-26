#!/usr/bin/bash

# config
backup_dir='/root/backup/'
backup_name='backup_roles_'
days_to_keep=10
datetime=`date +%Y-%m-%d`
file=$backup_dir$backup_name$datetime

# dump
pg_dumpall -U timofey -r -h 127.0.0.1 > $file

# clear old
find $backup_dir -mtime +$days_to_keep -type f -delete