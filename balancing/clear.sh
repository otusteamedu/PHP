#!/bin/bash

echo "\nОчистка всех workers и network...\n"

sudo docker stop balancer

sudo docker stop php_1
sudo docker stop php_2
sudo docker stop php_3

sudo docker stop worker_1
sudo docker stop worker_2
sudo docker stop worker_3

sudo docker rm balancer

sudo docker rm php_1
sudo docker rm php_2
sudo docker rm php_3

sudo docker rm worker_1
sudo docker rm worker_2
sudo docker rm worker_3

sudo docker network rm workers_workernet