**Как запустить систему:**

1) Скопировать файл .env.example в .env в директории в app
2) запустить проект через команду docker-compose up -d
3) Отправить данные в JSON формате через POST запрос по хосту `http://localhost:8787`. Данный запрос создаст 
   и добавит отправленные данные в очередь. Название очереди в .env файле `RABBITMQ_BASIC_QUEUE`
4) Зайти в докер контейнер `php-fpm` через команду `docker-compose exec php-fpm bash`
5) Перейти в директорию `commands` и запустить скрипт `console.php` с аргументом **basic_start**: 
   `php console.php start_basic`, чтобы видеть сообщения. Для того чтобы запустить в фоновом режиме, использовать параметр
   **background_start**
6) С этого момента все Consumer-ы слушают очередь. Для того чтобы посмотреть сообщения, которые были обработаны в фоновом
   consumer-e(background_start), можно поставить true в `RABBITMQ_DEBUG_CONSUMERS` в .env файле