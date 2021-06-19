#/bin/bash
files=(`find -P /var/www/demo -maxdepth 1 -type d | sort -r`)
currentFound=N
target=$(readlink /var/www/demo/current)
for file in "${files[@]}"
do
        [[ "$file" == "$(pwd)" ]] && continue;
        [[ "$currentFound" == "Y" ]] && unlink /var/www/demo/current && ln -s "$file" /var/www/demo/current && break;
        [[ "$file" == "$target" ]] && currentFound=Y;
done


sudo cp deploy/nginx.conf /etc/nginx/conf.d/demo.conf -f
sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/demo.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/demo.conf
sudo service nginx restart
sudo service php7.4-fpm restart
sudo service supervisor restart
