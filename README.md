# Homework 1

## 1. Docker
#### 1.1. Установить Docker себе на машину

![Docker installed version](https://downloader.disk.yandex.ru/preview/c4bab7477b696311963c59105859ec625e7abedcf566d4d7e9dd05cfefdf4bdc/5f2ff151/ymRrTnZQno0H7w18UOdJCvWBo11GRHnm0tbw-bhY-Z462cN8zP77aocJx6QlKS6QOXwGxyMx826RRGMl0Fj4Qg==?uid=0&filename=docker_install.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&tknv=v2&owner_uid=195427551&size=2048x2048)

#### 1.2. С помощью Dockerfile настроить статический сайт (можно использовать nginx образ)

Dockerfile и настройка nginx server (hm1.otus-lessons.com.conf) добавлен в pull request.

![Docker static site](https://downloader.disk.yandex.ru/preview/98d33304b640bfe85176674051653b601352f558a422810d4f11e3c2180564c9/5f300b8f/kjp7Ar4Y51QeCAK8MO-WLs5sWU5uls7psHm4BDR6B8IowQ2_iaI0ZhtPjZZpKEp8cqPr-EvEVH5T4mEJday1EQ==?uid=0&filename=docker_static_site.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&tknv=v2&owner_uid=195427551&size=2048x2048)

---

## 2. Виртуальные машины.
#### Развернуть Homestead VM при помощи Vagrant и VirtualBox
Vagrant Box был получен следующей командой:
```sh 
vagrant init laravel/homestead
```
В Vagrantfile были раскомментированы следующие строки:
```vagrantfile
config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
config.vm.network "private_network", ip: "192.168.33.10"
```
После чего произведена установка командой 
```sh
vagrant up
```

Были настроены общие папки с помощью Гостевого окружения VBox.

![Общие папки](https://downloader.disk.yandex.ru/preview/2479c6957b6e8af183e2dead61764ec3f3f32c87e3ea64fc89a163cef5b89be3/5f2fee4a/k2nVKu2_tOvmSTnfhVPAOD40UVAeMOJrf8BBKsPIxdYcmm8X1iBMPTq3IJCYycLrTRHEBgsDGjCunF-1M8yVBg==?uid=0&filename=shared_folders.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&tknv=v2&owner_uid=195427551&size=2048x2048)

Была произведена настройка nginx, файл настройки *otus-lessons.com* добавлен в pull request.

##### Результат
Сайт доступен из основной ОС (после внесения изменений в файл hosts).
Редактирование сайта производится из основной ОС.

![Сайт](https://downloader.disk.yandex.ru/preview/dcffe66921b2d33c78a83f683ef25b24ecde7373e01286fe5f003a975667ea2c/5f2fefcc/9QOIvfOCgBwC9PdBdPQtxFxHw2sbQONvuipbtn1lx8QWjYGtqzjPggud7coCEmiVGoax5vah-84k4VVB9dLMkw==?uid=0&filename=site.png&disposition=inline&hash=&limit=0&content_type=image%2Fpng&tknv=v2&owner_uid=195427551&size=2048x2048)

## 3. Выберите компанию коротко опишите ее.
       
#### (Количество сотрудников, сфера, приоритеты). Сравните целесообразность разворачивания своей инфраструктуры или аренды публичного облака (можно выбрать любого провайдера)

Круизная компания. В IT отделе штат состоит из трех программистов и одного DevOps-специалиста.
Имеется две машины. На одной две виртуалки (база и nginx+php), которая используется как prod.
Вторая машина используется в качестве тестового сервера.
Помимо этого используется несколько хостингов для дочерних проектов.

Калькулятор в cloud.yandex.ru показал стоимость конфигурации нашего боевого сервера примерно в 20000 рублей в месяц. Возьмем сумму в 50000 руб/месяц чтобы 100% покрыть все технические требования.
Так как при переходе на облачное решение необходимость в полноценном DevOps в штате отпадет + будет возможность временно накинуть мощности (например под маркетинговые акции) я думаю, что переход на облачное решение целесообразен.