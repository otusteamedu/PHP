# Домашнее задание №11 (задача №1)

## Описание структуры данных

Для хранения данных используется `mongodb`. Каналы youtube сохраняются в виде коллекции документов с типом:
```
{
    "name": "string",
    "url": "string",
    "subscribers": "int",
    "videos": "array"
}
```

при этом видео этих каналов хранятся в виде вложенного массива в документе канала и представлены следующим типом:

```
{
    "name": "string",
    "url": "string",
    "likes": "int",
    "dislikes": "int"
}
```

Для наглядности приведем пример таких данных:

```
{
    "name": "ПостНаука",
    "url": "https://www.youtube.com/user/postnauka/",
    "subscribers": 603000,
    "videos": [
        {
            "name": "Археи — Елизавета Бонч-Осмоловская / ПостНаука",
            "url": "https://www.youtube.com/watch?v=6nZ4kJ_JLbQ",
            "likes": 480,
            "dislikes": 4
        },
        {
            "name": "Основные ошибки инноваторов — Александр Чулок / ПостНаука",
            "url": "https://www.youtube.com/watch?v=EJzj875zak4",
            "likes": 257,
            "dislikes": 54
        }
    ]
}
```

## API для работы с приложением
Для инициаизации БД (заполнение данными) отправить `GET` запрос `http://localhost/task1.php?action=initdb`.

Добавить канал: `POST` на `http://localhost/task1.php` с переменными запроса:
```
action:addchannel
data:{"name": "Test channel name", "url": "https://www.youtube.com/user/test", "subscribers": 529}
```

Добавить видео: `POST` на `http://localhost/task1.php` с переменными запроса:
```
action:addvideo
data:{"channel_url": "https://www.youtube.com/user/postnauka" "name": "Test video name", "url": "http://test.ru", "likes": 5, "dislikes": 2}
```

Добавить канал вместе с видео: `POST` на `http://localhost/task1.php` с переменными запроса:
```
action:addchannel
data:{"name": "Test channel name", "url": "http://rara.ru", "subscribers": 529, "videos": [{"name": "Test video name", "url": "http://ra.ru", "likes": 5, "dislikes": 2}, {"name": "Test video name", "url": "http://ra.ru", "likes": 50, "dislikes": 20}]}
```

Удалить видео: `POST` на `http://localhost/task1.php` с переменными запроса:
```
action:deletevideo
data:{"url": "https://www.youtube.com/watch?v=qeYd-hdhH40&list=PL4p9eGkQRuo5LedqEzQDYnShDeUvdJkRj"}
```

Удалить канал вместе с его видео: `POST` на `http://localhost/task1.php` с переменными запроса:
```
action:deletechannel
data:{"url": "https://www.youtube.com/user/SeriousScience/"}
```

Для получения статистики по лайкам и дизлайкам: `GET` на `http://localhost/task1.php?action=getstatistics&data={"url": "https://www.youtube.com/user/SeriousScience/"}`, где `url` - это адрес канала.

Для получения ТОП (отранжированного списка каналов по отношению лайки / дизлайки): `GET` на `http://localhost/task1.php?action=gettop`.

В dev окружении (должны быть установлены `require-dev` пакеты) можно посмотреть все данные в БД: `GET` на `http://localhost/task1.php?action=showstatus`.