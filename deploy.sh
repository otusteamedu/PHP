sudo -u www-data composer install -q
sudo cp /etc/nginx/conf.d/nginx.conf /etc/nginx/conf.d/nginx-previous.conf -f
sudo cp deploy/nginx.conf /etc/nginx/conf.d -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/nginx.conf
sudo service nginx restart
sudo service php7.2-fpm restart
