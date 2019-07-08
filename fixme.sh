#!/usr/bin/env bash

#need to run via source or '. ' to execute this script in the same shell to have access to user's history
last_command=$(fc -l -n -1)
php fixme.php "$last_command"