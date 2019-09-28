## Решение ДЗ № 5.2 (базовая установка Laravel в Docker)

Чтобы развернуть приложение, выполните следующие команды:
- `docker-compose up -d --build`
- `docker-compose exec php-fpm composer install`
- `docker-compose exec php-fpm composer run post-root-package-install`
- `docker-compose exec php-fpm composer run post-create-project-cmd`
