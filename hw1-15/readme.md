1. Создать и заполнить файл .env с настройками ребита
2. Выполнить команду docker-compose up -d --build
3. Выполнить команду docker exec -ti server bash
4. Отправить POST-запрос на адрес http://app.loc:8080/add с параметром "email"
5. Выполнить в консоли php index.php consumer
