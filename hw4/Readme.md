###### Написать два PHP скрипта, который запускаются на одной машине и обмениваются сообщениями через unix-сокеты

Создаем образ
    
    docker build -t hw4 .
    
Запускаем контейнер

    docker run -it --name hw4 hw4
    
Включаем сервер
        
    /app # php server.php &
    
Проверяем работу клиента    
    
    /app # php client.php 
    Hi! ; 2020-05-23 21:29:38
    /app # php client.php 
    Hi! ; 2020-05-23 21:29:39
    /app # php client.php 
    Hi! ; 2020-05-23 21:29:41
    /app # php client.php 
    Hi! ; 2020-05-23 21:29:42