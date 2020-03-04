#!/bin/bash

echo "\nОчистка всех workers и network...\n"

sudo docker stop webapp
sudo docker stop php

sudo docker rm webapp
sudo docker rm php

sudo docker network rm webapp_workernet