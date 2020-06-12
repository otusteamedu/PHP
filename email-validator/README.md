* Запуск 

`docker-compose up -d`

URL формы с проверкой:  http://localhost:10080/index.php?r=emailValidator/validate

* Пример проверки

| email | status |
|---|---|
| asd@as.aa | Invalid |
| test@gmail.com | Valid |
| zzz@a.fff | Invalid |
| test| Invalid |