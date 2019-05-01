#!/usr/bin/env bash

if [ "$1" == "" ]; then
    echo 'error: Укажите путь к рабочей директории' >&2
    exit 1
fi

if [ -d "$1" ]; then rm -Rf $1; fi

mkdir -pv "$1"
psql -c "CREATE TABLESPACE tsFastIndex LOCATION '$1';"
psql -c "ALTER INDEX ALL IN TABLESPACE pg_default SET TABLESPACE tsFastIndex;"