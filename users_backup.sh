#!/usr/bin/env bash

BACKUP_DIR=~/theater_backup
DAYS_TO_KEEP=14
FILE_SUFFIX=roles.sql
HOST=localhost
PORT=5432
USER=crazydope
FILE=`date "+%Y%m%d_%H%M%S_"`${FILE_SUFFIX}
OUTPUT_FILE=${BACKUP_DIR}/${FILE}

pg_dumpall -U ${USER} -h ${HOST} -p ${PORT} -r -f ${BACKUP_DIR}/${FILE}

gzip $OUTPUT_FILE
echo "${OUTPUT_FILE}.gz was created:"
ls -l ${OUTPUT_FILE}.gz

find $BACKUP_DIR -maxdepth 1 -mtime +$DAYS_TO_KEEP -name "*${FILE_SUFFIX}.gz" -exec rm -rf '{}' ';'