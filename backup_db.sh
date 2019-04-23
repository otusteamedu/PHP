#!/usr/bin/env bash

RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

if [[ -z $1 ]]; then
    echo -e "${GREEN}$ echo localhost:5432:*:<user>:<password> > .pgpass"
    echo -e "$ chmod 0600 .pgpass${NC}"
    echo -e "${RED}Usage: PGUSER=<user> $0 <database>${NC}"
    exit 1
fi

export PGDATABASE=$1
export PGUSER=${PGUSER:-`whoami`}
export PGPORT=${PGPORT:-5432}
export PGHOST=${PGHOST:-localhost}

if [[ -f ./.pgpass ]]; then
    export PGPASSFILE="`pwd`/.pgpass"
else
    export PGPASSFILE="~/.pgpass"
fi

DATE=`date +%Y%m%d_%H%M`
BACKUP=${DATE}_backup.sql.gz
ROLES=${DATE}_roles.sql

echo -e Use auth from ${BLUE}${PGPASSFILE}${NC} for ${BLUE}${PGUSER}${NC}

echo -e Backup ${BLUE}${PGDATABASE}${NC} to ${BLUE}${BACKUP}${NC}
pg_dump | gzip > ${BACKUP}

echo -e Dump roles to ${BLUE}${ROLES}${NC}
pg_dumpall -r -f ${ROLES}

echo -e ${GREEN}Done.${NC}
