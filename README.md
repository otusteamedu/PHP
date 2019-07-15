Other HW 16

1. composer install
2. docker-compose up --build -d
3. host:8000

-----------------------------------

Структура базы Youtube

Коллекция Channels
{
    channelId string,
    channelTitle string,
    channelViews int,
    channelLikes int,
    channelDislikes int
}

Индексы для Channels

{'channelId' => 1}, {'unique' => true}
{'channelViews' => 1, 'channelLikes' => 1, 'channelDislikes' => 1}
                    
Коллекция Videos
{
    videoId string,
    channelId string, 
    videoTitle string, 
    videoViews int, 
    videoLikes int,
    videoDislikes int
}

Индексы для Videos

{ 'videoId' => 1}, {'unique' => true };
{ 'videoLikes' => 1, 'videoDislikes' => 1 }

