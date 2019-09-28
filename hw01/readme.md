Статический сайт на Docker.

Чтобы развернуть на локальной машине, нужно последовательно запустить следующие команды:
  - `docker-compose pull`
  - `docker-compose build`
  - `docker-compose up -d`

В случае с Linux/MaсOS при наличии установленной утилиты make можно развернуть сайт одной командой: `make init`.

Запуск контейнера: `docker-compose up -d` (`make up`)
Остановка контейнера: `docker-compose down --remove-orphans` (`make down`)