## Как проверить

Запустить
```sh
$ docker-compose up -d --build
```


### Собрать и сохранить данные с Ютуба
по 25 последних видео с каждого канала:
```sh
$ curl POST "http://localhost/parserV3.php" -d"apikey=AIzaSyBXNafqdrsfOaD1JaXK8nsKJrtbC_8vfbM&channel=UCMCgOm8GZkHp8zJ6l7_hIuA&limit=25"
$ curl POST "http://localhost/parserV3.php" -d"apikey=AIzaSyBXNafqdrsfOaD1JaXK8nsKJrtbC_8vfbM&channel=UCNRYbltJXhf6DepS26-uSbQ&limit=25"
$ curl POST "http://localhost/parserV3.php" -d"apikey=AIzaSyBXNafqdrsfOaD1JaXK8nsKJrtbC_8vfbM&channel=UCvQXaJTjA3jRucTKN4CGiwg&limit=25"
$ curl POST "http://localhost/parserV3.php" -d"apikey=AIzaSyBXNafqdrsfOaD1JaXK8nsKJrtbC_8vfbM&channel=UCp2J7GRxQ36QLqW4ReLLt5g&limit=25"
$ curl POST "http://localhost/parserV3.php" -d"apikey=AIzaSyBXNafqdrsfOaD1JaXK8nsKJrtbC_8vfbM&channel=UCsKiNBoIWLpIxU6vsAv3v3w&limit=25"
```
- `apikey` -- Ключ API Гугла с доступом к YouTube Data API v3
- `channel` -- ИД канала который парсим
- `limit` -- ограничить количество видео, чтобы не израсходовать всю квоту ключа. 

### Взглянуть на статистику
```sh
$ curl "http://localhost/metrika.php"
```

### Удалить 1 видео
```sh
$ curl POST "http://localhost/remove.php" -d"videoid=7JrIAY5G7jE"
```

### Удалить канал и все его видео
```sh
$ curl POST "http://localhost/remove.php" -d"channel=UCMCgOm8GZkHp8zJ6l7_hIuA"
```



Схема канала
```js
{
"title":  String,
"description":  String,
"subscriberCount": Number,
"videoCount": Number,
"viewCount": Number
}
```

Схема видео
```js
{
"channelId": String,
"channelTitle": String,
"publishedAt": Date,
"title": String,
"description": String,
"tags": [String]
"duration": String,
"viewCount": Number,
"likeCount": Number,
"dislikeCount": Number,
"commentCount": Number
}
```
понадобятся индексы на поле `channelId`
и, наверно, на `likeCount` `dislikeCount`, чтобы быстрее и дешевле считать статистику