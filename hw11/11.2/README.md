#### Первый запуск проекта

1. Запуск контейнеров:   

        docker-compose up -d

2. Заполнение данные Redis через php-скрипт:

        localhost/redis_init.php
     
#### Проверка

1. Добавление событий реализовано через GET параметр для удобства проверки:    

        localhost/redis.php?add_event=<{данные события}>     

add_event - принимает строку с описанием события,    
 можно вставить шаблон указанный ниже:         

    {
        "priority": 1000, 
        "conditions": {
            "param1": 1
        }, 
        "event": {
            "name": "Название события"
            }
    }

2. Удаление доступных событий:    

        localhost/redis.php?drop_events=true     
 
drop_events - для удаления должно быть указано true

3. Ответ на запрос пользователя подходящим событием:   

        localhost/redis.php?query=<{запрос}>     

query - принимает строку с параметрами,    
 можно вставить шаблон указанный ниже:     
 
    { 
        "params": {
            "param1": 1,
            "param1": 3,
            "param2": 2
        }
    }
    





    
    

    
    
    
    
    
add_event={
    "priority": 1000, 
    "conditions": {
        "param1": 1
    }, 
    "event": {
        "name": "Название события"
        }
}
    
query={ 
    "params": {
        "param1": 1,
        "param1": 3,
        "param2": 2
    }
}
