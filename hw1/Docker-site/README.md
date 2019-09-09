# Статический сайт компании в Docker контейнере

## Структура:
**README.md** - Описание проекта
**/www** - Директория с файлами статического сайта
**Dockerfile** - Рецепт для сборки Docker контейнера
**nginx-virtual-host.conf** - Конфигурация для виртуального хоста nginx, заменяет конфигурацию nginx по умолчанию


## Запуск:
Собираем образ:
`docker build -t nginx-with-static-site .`

Запускаем контейнер:
`docker run -d -p 80:80 --name company-web-site nginx-with-static-site`
