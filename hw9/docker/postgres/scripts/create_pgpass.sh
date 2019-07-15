#!/bin/bash
echo 'localhost:5432:cinema:postgres:'$POSTGRES_PASSWORD > ~/.pgpass
chmod 600 ~/.pgpass