#!/bin/bash
pg_dumpall -h localhost -w -p 5432 -U postgres -v --roles-only -f "roles.sql"