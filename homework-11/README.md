# Приложение для анализа каналов на Youtube

## Структура хранения информации о канале
```shell script
PUT /channels
```
```json
{
    "mappings": {
        "properties": {
            "id": {"type": "keyword"},
            "title": {"type": "text"},
            "description": {"type": "text"},
            "like_count": {"type": "integer"},
            "dislike_count": {"type": "integer"},
            "ratio": {"type": "float"}
        }
    }
}
```
Структура намеренно максимально упрощена. Хранятся только используемые данные.

## Методы работы с системой

### Методы работы с каналом
1. Добавление канала:
    ```shell script
    POST /channels
    ```
    ```json
    {
        "id": "UC-8VqDi5WCGXjCBIpz-IJvw"
    }
    ```
2. Просмотр канала и его суммарного количества лайков и дизлайков по всем его видео:
    ```shell script
    GET /channels/{id}
    ```
3. Удаление канала
    ```shell script
    DELETE /channels
    ```
    ```json
    {
        "id": "UC-8VqDi5WCGXjCBIpz-IJvw"
    }
    ```
4. Получение лучших каналов по соотношению количества лайков и дизлайков
    ```shell script
    GET /statistics?limit=5
    ```
