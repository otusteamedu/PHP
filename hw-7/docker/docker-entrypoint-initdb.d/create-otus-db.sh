#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE USER otus;
    CREATE DATABASE otus;
    ALTER USER otus WITH PASSWORD 'otus';
    GRANT ALL PRIVILEGES ON DATABASE otus TO otus;
EOSQL
