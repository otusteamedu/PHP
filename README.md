Простой статический сайт с Docker (ДЗ 2-2)
==========================================

## Пулл с докер хаба

```bash
docker pull petrovalexander/otus-hw2-2:latest
docker run -d -p 8000:80 -v $(pwd)/log:/var/log/nginx petrovalexander/otus-hw2-2:latest
```

## Локальный билд и запуск

```bash
docker build -t otus-petrov-aa-hw2-2 .
docker run -d -p 8000:80 -v $(pwd)/log:/var/log/nginx otus-petrov-aa-hw2-2
```

## Описание

В проекте 3 директории: `www`, `nginx`, `log`:

- `www` - содержит статические файлы будущего сайта
- `nginx` - содержит конфигурацию nginx
- log - логи nginx

Я решил дополнительно попробовать сделать возможным хранение логов вне контейнера
