Инструкция по разворачиванию
-------------------

1) docker-compose up -d --build
2) docker exec -ti php bash
3) php src\Publisher.php
4) Отправить POST-запрос на адрес http://localhost:7777 с POST-параметром "email"
