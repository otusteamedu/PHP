sudo -u www-data composer install -q  # Устанавливаем пакеты из композера
sudo cp deploy/nginx.conf /etc/nginx/conf.d -f  # Копируем конфиг nginx
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/nginx.conf # Заменяем в конфиге nginx %SERVER_NAME% на первый переданный скрипту параметр
sudo service nginx restart # Перезагружаем nginx и php
sudo service php7.4-fpm restart
sudo git clone https://github.com/alextravin/dummyConfigs.git

# тут можно накатить миграции, прогреть кэш, перезапустить воркеры
php artisan migrate --force  # например, форс миграция в laravel
php artisan cache:clear # очищаем кэш laravel