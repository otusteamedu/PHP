## Важное

* В связи с ограничением квоты api много тестов сделать не получилось, поэтому пришлось делать простую логику парсинга
* В данной реализации получилось обойтись 1 индексом, который хранит в себе total_* значения, что при выборке из elastic
  позволяет не производить выборку соседних сущностей и сложения данных
* Для работы api надо вставить api ключ в `GOOGLE_API_KEY` в файле `.env`
## Роуты

* `/channels` - список каналов
* `/channels/search?q=*` - поиск
* `/channels/spider` - запуск паука и редирект на страницу каналов

## Elastic channel index mapping

```json
{
    "channels": {
        "mappings": {
            "properties": {
                "created_at": {
                    "type": "date"
                },
                "description": {
                    "type": "text",
                    "fields": {
                        "keyword": {
                            "type": "keyword",
                            "ignore_above": 256
                        }
                    }
                },
                "id": {
                    "type": "long"
                },
                "name": {
                    "type": "text",
                    "fields": {
                        "keyword": {
                            "type": "keyword",
                            "ignore_above": 256
                        }
                    }
                },
                "ratio": {
                    "type": "float"
                },
                "tags": {
                    "type": "text",
                    "fields": {
                        "keyword": {
                            "type": "keyword",
                            "ignore_above": 256
                        }
                    }
                },
                "total_dislikes": {
                    "type": "long"
                },
                "total_likes": {
                    "type": "long"
                },
                "total_views": {
                    "type": "long"
                },
                "updated_at": {
                    "type": "date"
                },
                "url": {
                    "type": "text",
                    "fields": {
                        "keyword": {
                            "type": "keyword",
                            "ignore_above": 256
                        }
                    }
                },
                "youtube_id": {
                    "type": "text",
                    "fields": {
                        "keyword": {
                            "type": "keyword",
                            "ignore_above": 256
                        }
                    }
                }
            }
        }
    }
}
```
