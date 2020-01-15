#### Первый запуск проекта

Запуск контейнеров и восстановление бэкапа mongodb:   

    docker-compose up -d && make mongo_restore

Также данные можно создать через php-скрипт:

    localhost/index_init.php
 
#### Модели данных

1. Каналы     
   
        channels
        {
            name "string" 
            url "string" 
            subscribers "int" 
            all_views: "int" 
            registation_date: "timestamp"
        }    
    
2. Видео    

        videos
        {
            name "string" 
            url "string" 
            channel_url "string"
            create_date "timestamp"
            likes "int" 
            dislikes "int"
            views "int"
            description "string"
        }
    
#### Индексы

Для имеющихся в задании запросов созданы индексы по url,    
 т.к. они будут использоваться для поиска каналов и видео
   
    db.channels.createIndex({ url: 1 })
    db.videos.createIndex({ channel_url: 1 })   
    
#### Проверка

1. Проверка запросы "Суммарное кол-во лайков и дизлайков для канала по всем его видео":    

        localhost/sum_likes.php?channel_url=<url_катала>     

channel_url - url канала,    
если не указать то будут возвращены данные для канала "channel_1_url"

2. Проверка запроса "Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков":    

        localhost/top_rate_channels.php?limit=<5>
        
limit - количество выводимых Топ каналов,    
если не указать то будут возвращены данные для Топ 5 каналов     





    
    
