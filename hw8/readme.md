Запуск контейнера

    docker-compose up -d

Воход в контейнер

    docker exec -it hw8-postgres bash

Запуск psql

    psql -U dev

Самый прибыльный фильм

    SELECT name FROM films WHERE id IN (SELECT s.film_id FROM clients c, sessions s WHERE c.session_id=s.id GROUP BY s.film_id ORDER BY sum(s.price) DESC LIMIT 1);
