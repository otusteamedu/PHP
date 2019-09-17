# Домашнее задание №1

Docker, виртуализация и облака
Цель: Учимся работать с инфраструктурой
1. Docker
1.1. Установить Docker себе на машину
1.2. С помощью Dockerfile настроить статический сайт (можно использовать nginx образ)

2. Выберите в качестве примера свою текущую компанию (или компанию, в которой хотите работать), коротко опишите ее (количество сотрудников, сфера, приоритеты)
Сравните целесообразность разворачивания своей инфраструктуры или аренды публичного облака (можно выбрать любого провайдера) 


##Что сделал?

### 1. Docker
1.1. Установил Docker Desktop для Windows https://hub.docker.com/?overlay=onboarding
1.2. Настроил статический сайт на основе nginx образа с помощью Dockerfile.

#### Последовательность действий по настройке сайта
 * В корне проекта создал index.html
 * В корне проекта создал Dockerfile
 * В Windows PowerShell в корне проекта выполнил команды:
    docker build -t nginx:latest .
    docker run -d -p 80:80 --name nginx-hw1 --hostname nginx-hw1 nginx
    ipconfig
 * IP-адрес выданный ipconfig в блоке "Адаптер Ethernet vEthernet (DockerNAT):" забил в браузер, убедился, что выдает мой index.html


### 2. Сравнение целесообразности своей и облачной инфраструктуры

https://docs.google.com/document/d/1S0amEywgZXtUFGNo7F6INTIy8Y7nCxAWULQXKRepYBo/edit?usp=sharing
