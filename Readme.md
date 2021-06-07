# Запуск проекта

#### 1. Клонировать репозиторий и перейти в каталог
`git clone https://github.com/otusteamedu/PHP/tree/ATimofeev/hw13-api <path> && cd <path>`

#### 2. Создать docker контейнеры, установить зависимости
`bash init.sh`

#### 3. Запустить приложение
`bash start.sh`

Запущен 1 обработчик очереди. Для добавления обработчика/ов, в новом окне консоли набрать

docker-compose exec app php src/bin/console messenger:start

#### 4. Документация
http://localhost/api/doc

Тестовые пользователи

user1@mail.com:user1

user2@mail.com:user2








