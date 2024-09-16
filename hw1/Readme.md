# Домашняя работа 1 (виртуализация)


## 1 Статический сайт ##

Основной образ используется ```alpine:latest```

Каталог содержит файлы:

```
|--Dockerfile
|--config
|  --site.local.conf
|--files
|  --index.html
```
1. Dockerfile - файл, инструкция для docker'a
2. config - католог с конфигурационным файлом (site.local.conf) для nginx
3. files - каталог со статическим сайтом, файл index.html

Для работы со статическим сайтом, нужно добавить запись в hosts
```
127.0.0.1 site.local
```
Команды для работы с контейнером:
```
docker build -t mar4ehk0/alpine .                           // создание образа
docker run -d -p 8080:80 --name mar4ehk0 mar4ehk0/alpine    // запуск контейнера с "пробрасыванием портов".
docker stop mar4ehk0                                        // остановка контейнера
docker container rm mar4ehk0                                // удаление контейнера
docker image rm mar4ehk0/alpine:latest                      // удаление образа
```

Статический сайт доступен: ```site.local:8080```


## 2 Целесообразность аренды публичного облака ##
Я работаю в нидерландской компании, продаем электронный продукт, а именно доступ к сетям usenet. Продажа реализована на Drupal7/Ubercart.

Команда:

1 - Дизайнер/верстальщик

3 - Бэкэнд разработчика

1 - Проект менеджер / Владелец данного бизнеса

Итого: 4 человека

#### Текущее окружение ####

Production:
```
4 CPU Cores
16.384 MB RAM
300 GB SSD
```
Цена: USD 90 в месяц

Stage / Development - один сервер, на нем все крутится для разработки. 

```
4 CPU Cores
16.384 MB RAM
300 GB SSD
```
Цена: точную цену этого сервера не знаю, но могу предложить что такая же USD 90 в месяц.

##### Итого: USD 180 в месяц, данный web-сервера настраиваю я сам. Возможно системный администратор это и сделал бы быстрее. #####

Несколькот месяцев назад у заказчика была мысль о переходе в облако гугл, но дальше этой мысли у нас диалог не зашел. Сейчас как раз можно посчитать и понять есть в этом смысл или нет. Поэтому в качестве облака буду использовать (технологии гугла)[https://cloud.google.com/products/calculator#id=]. 

Выбрал:
* Instances = 2 (1 productrion, 1 - stage и developemnt)
* What are these instances for? = Web
* Operating System / Software = Operating System / Software: Free: Debian, CentOS, CoreOS, Ubuntu, or other User Provided OS
* Machine Class = Regular
* Machine Family = General purpose
* Series = N1
* Machine type = n1-standard-4 (vCPUs: 4, RAM: 15GB)
* Local SSD = Local SSD: 1x375 GB
* Datacenter location = Netherlands (europe-west4)
* Average hours per day each server is running = 24 - всегда должен быть активен. т.к. транзакции принимаем в любое время дня и ночи.
* Average days per week each server is running = 7
            
##### Итого: USD 279.60 в месяц + Средняя зарплата devops 2000USD в месяц, возможно следует нанять на разовую работу для настройки всей инфраструктуры и потом обращаться по мере необходимости.  #####

AWS: Решил посмореть сколько будет на AWS, AWS-калькулятор = 296.37 USD в месяц.


Yandex: Гарантированная доля vCPU 20%, и 4 ядра, 16 Гб итого 7999рублей в месяц. Яндекс выигрывает по стоимости, но зарплата devops - убирает всю экономию.


### Вывод: Облачные вычисления - это удобный и современный инструмент для больших проектов, на проекте с которым я работаю облако быдет избыточным. ###


