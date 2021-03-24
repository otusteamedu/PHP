#### Первый шаг
```
docker-compose up
```
#### Второй шаг
######Добавить строку 
```
127.0.0.1 validate.local
```
 - Для Linux, MacOS - /etc/hosts, 
 - Для Windows C:\Windows\System32\drivers\etc, файл hosts 
#### Третий шаг
Перейти в директорию ***code*** и выполнить команды:
```
composer install
cp .env.example .env
```
#### Четвертый шаг
###### Зайти на страницу   `validate.local/` в браузере 


