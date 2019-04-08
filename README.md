### [Всем] Калькулятор по шаблону. Strategy. Покрыть его PHPUnit тестами.


```
$ docker build -t php_calc:latest .

$ docker run -d --name calc -u${UID} -v `pwd`:/app php_calc:latest

$ docker exec -it calc ./calculator.php 2*2

$ docker stop calc

$ docker rm calc
```