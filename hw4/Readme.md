###### Написать два PHP скрипта, который запускаются на одной машине и обмениваются сообщениями через unix-сокеты

Создаем образ
    
    docker build -t hw4 .
    
Запускаем контейнер

    docker run -it --name hw4 hw4
    
Включаем сервер
        
    /app # php server.php &
    
Проверяем работу клиента    
    
    /app # php client.php    
    > PING
    PONG
    > Another message
    You wrote: Another message