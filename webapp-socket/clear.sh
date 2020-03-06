#!/bin/bash

sudo docker stop socket-php
sudo docker stop socket-nginx

sudo docker rm socket-php
sudo docker rm socket-nginx
