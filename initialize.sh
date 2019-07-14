#!/bin/sh

set -e

_psql="$( which psql )" || {
    echo Please install postgresql-client >&2
    exit 2
}

_psql()
{
    $_psql "--set=ON_ERROR_STOP=1" --quiet --echo-errors "--host=localhost" "$@"
}

cd /var/lib/postgresql

_psql "--username=postgres" "--no-password" < db-init.sql

_psql "--username=user1" cinema < hw16-cinema.sql
_psql "--username=user1" cinema < hw16-most-profitable-show.sql
