sudo cp deploy/mysite.conf /etc/nginx/conf.d/mysite.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/mysite.conf
sudo service nginx restart
sudo -u www-data composer install -q
sudo service php7.4-fpm restart
