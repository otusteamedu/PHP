#!/bin/sh

echo "Starting startup.sh.."
echo "*       *       *       *       *       /usr/local/bin/php  /usr/src/mysite.local/app/sockets/caller.php 2>&1 > /usr/src/mysite.local/app/sockets/log.txt" >> /etc/crontabs/root
crontab -l