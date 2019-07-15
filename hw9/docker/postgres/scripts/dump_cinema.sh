#!/bin/bash
pg_dump -h localhost -p 5432 -U postgres -F p -w cinema > cinema.sql