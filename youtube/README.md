# Домашнее задание. К уроку 11

## Создать приложение для анализа каналов на Youtube

### Запуск
`docker-compose up -b`

### Задачи

#### 1. Создать структуру/структуры хранения информации о канале и видео канала
> в ElasticSearch, описать в виде JSON с указанием типов полей. Описать какие индексы понадобятся в данной структуре?

Структура индекса Channel:
```json
{
    "index": "channel",
    "body": {
        "mappings": {
            "properties": {
                "id": {
                    "type": "keyword"
                },
                "title": {
                    "type": "keyword"
                },
                "description": {
                    "type": "text"
                }
            }
        }
    }
}
```
Структура индекса Video:
```json
{
    "index": "video",
    "body": {
        "mappings": {
            "properties": {
                "id": {
                    "type": "keyword"
                },
                "channelId": {
                    "type": "keyword"
                },
                "title": {
                    "type": "keyword"
                },
                "likeCount": {
                    "type": "integer"
                },
                "dislikeCount": {
                    "type": "integer"
                }
            }
        }
    }
}
```

#### 2. Создать необходимые модели для добавления и удаления данных из коллекций
Использование моделей:
  - Анализ канала, добавление видео `php console youtube/analyze [channelId[,channelId...]]`
    
Пример:
```shell
bash-5.0# php console youtube/analyze UCy57NiiCwk17_KMkKfQMbuA
Array
(
  [0] => UCy57NiiCwk17_KMkKfQMbuA = 112
)
```
  - Удаление канала и все его видео `php console youtube/deleteChannel [channelId]`
    
Пример:
```shell
bash-5.0# php console youtube/deleteChannel UCy57NiiCwk17_KMkKfQMbuA
Array
(
    [result] => Array
        (
            ...
            [result] => deleted
            ...
)
```
  - Удаление видео `php console youtube/deleteVideo [videoId]`
    
Пример:
```shell
bash-5.0# php console youtube/deleteVideo Vz4HNORjw_M

Array
(
    [result] => Array
        (
            ...
            [result] => deleted
            ...
```
#### 3. Реализовать класс статистики
> Который может возвращать:
>   1. Суммарное кол-во лайков и дизлайков для канала по всем его видео
>   2. Топ N каналов с лучшим соотношением кол-во лайков/кол-во дизлайков

1. `php console youtube/statistics [channelId]`

Пример:
```shell
bash-5.0# php console youtube/statistics UCy57NiiCwk17_KMkKfQMbuA
Array
(
    ...
    [aggregations] => Array
        (
            [likes_total] => Array
                (
                    [value] => 139327
                )
        )
)
```
2. `php console youtube/top [number]`

Пример:
```shell
bash-5.0# php console youtube/top 3
Array
(
    [0] => Array
        (
            [channelId] => UCy57NiiCwk17_KMkKfQMbuA
            [title] => Pyataykins
            [ratio] => 43.18877867328
        )
    [1] => Array
        (
            [channelId] => UCcflkwK_x06dRihzLiPXCrA
            [title] => ОМАГАД ШОУ
            [ratio] => 31.217465753425
        )
    [2] => Array
        (
            [channelId] => UCO3xjDILQxw1Pw0f3Ib4kAA
            [title] => Jasmine Ryakhovskaya
            [ratio] => 17.848899266177
        )
)

```
