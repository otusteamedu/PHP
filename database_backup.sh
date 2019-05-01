#!/usr/bin/env bash

BACKUP_DIR=~/theater_backup
DAYS_TO_KEEP=14
FILE_SUFFIX=_theater_backup.sql
DATABASE=crazydope
USER=crazydope
HOST=localhost
PORT=5432

FILE=`date +"%Y%m%d%H%M"`${FILE_SUFFIX}
OUTPUT_FILE=${BACKUP_DIR}/${FILE}

pg_dump -U ${USER} -h ${HOST} -p ${PORT} ${DATABASE} -F p -f ${OUTPUT_FILE}

gzip $OUTPUT_FILE
echo "${OUTPUT_FILE}.gz was created:"
ls -l ${OUTPUT_FILE}.gz

find $BACKUP_DIR -maxdepth 1 -mtime +$DAYS_TO_KEEP -name "*${FILE_SUFFIX}.gz" -exec rm -rf '{}' ';'