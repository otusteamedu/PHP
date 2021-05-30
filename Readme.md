# Запуск проекта

#### 1. Клонировать репозиторий и перейти в каталог
`git clone https://github.com/otusteamedu/PHP/tree/ATimofeev/hw12-rabbit <path> && cd <path>`

#### 2. Создать docker контейнеры, установить зависимости
`bash init.sh`

#### 3. Запустить приложение
`bash start.sh`

Запущен 1 обработчик очереди. Для добавления обработчика/ов, в новом окне консоли набрать

docker-compose exec app php bin/console messenger:start

#### 4. Открыть в браузере
http://localhost

http://localhost:1080/







