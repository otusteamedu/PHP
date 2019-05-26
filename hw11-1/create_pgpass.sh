#!/usr/bin/bash

touch ~/.pgpass
chmod 600 ~/.pgpass
echo "127.0.0.1:5432:*:timofey:timofey123" > ~/.pgpass
echo "127.0.0.1:5432:*:readonly:123" >> ~/.pgpass