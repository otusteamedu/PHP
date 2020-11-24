# NoSQL, работа с хранилищем

## Урок 11. Работа с Youtube API и ElasticSearch

Для работы с Youtube используется официальный клиент `"google/apiclient": "~2.0"`, а для ElasticSearch `"elasticsearch/elasticsearch": "^7.10"`.
В каталоге [leason11](leason11) - простое приложение, которое берет всю информацию о катале [OTUS](https://www.youtube.com/channel/UCetgtvy93o3i3CvyGXKFU3g) и сохраняет ее в Elastic. При этом сохраняется вся информация о видео этого канала. Если доступно, то и кол-во лайков/дизлайков для каждого видео.

## Урок 12. Работа с Redis

В каталоге [leason12/app](leason12/app) находится приложение демонстрирующее работу с хранилищем Redis.

## Урок14. 

В каталоге [leason14](leason14/sources) пример реализации паттерна Row Data Gateway.

---
### Полезные ссылки:

- [Паттерны архитектуры источников PoEAA](https://bool.dev/blog/detail/patterny-arkhitektury-istochnikov-dannykh-poeaa)
- [Доступ к данным или как научились не замечать БД](https://gist.github.com/fesor/d84451fc6cf00ea62ca5)