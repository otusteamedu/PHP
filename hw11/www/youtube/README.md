### скопировать .env.example в .env
### И добавить ключ youtube в env перенеменную YOUTUBE_API_KEY
## Паук
   http://youtube.test/spider GET 


## удалить все каналы

   http://youtube.test/channels DELETE 

## Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков

   http://youtube.test/get-top-channels GET 
   
```
params


count: 4
```

## Суммарное кол-во лайков и дизлайков для канала по всем его видео
 http://youtube.test/statistics-channel-videos GET 