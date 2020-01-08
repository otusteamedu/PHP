#### Запуск проекта

    docker-compose up

#### Проверка скрипта 

Запустите следующие команды:    

    1. docker-compose exec postgresql-hw9-t1 bash
    2. su postgres
    3. psql
    4. Для теста первой view: select * from service_dates;    
    5. Для теста второй view: select * from marketing_data;    
