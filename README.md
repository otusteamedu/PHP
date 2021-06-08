Инструкция по разворачиванию
-------------------
1) Заполнить файл .env по аналогии с .env.example
2) docker-compose up -d --build
3) docker exec -ti php bash
4) php index.php publisher
5) Отправить POST-запрос на адрес http://localhost:7777 с POST-параметром "email"
