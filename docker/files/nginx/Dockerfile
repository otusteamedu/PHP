# откуда будет создаваться образ
# я взял за основу ubuntu 20.1
# можно поставить например FROM debian
# это не значит что там будет установлена debian или ubuntu
# это означает, чтобудет эмуляция ubuntu 
# и что можно будет выполнять команды из этих операционок
FROM ubuntu:20.10

# Мета данные
LABEL version="1.0"
LABEL description="Nginx container"
LABEL maintainer = "Vladimir Valyakin"

# запуск комманды apt update (обновляем библиотеку пакетного менеджера)
RUN apt update

# запуск установки nginx
RUN apt install -y nginx

# переменные окружения
# если их несколько, значит можно прописать несколько ENV = SOMETHING
# или все в одну строчку ENV A1="1" A2="2" COUNT="21"
ENV TZ=Europe/Moscow
ENV ADMIN="Vladimir"			

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# рабочая папка где будет исполняться следующая комманда
# и место куда попадаем заходя в контейнер 
WORKDIR /var/www/html

# VOLUME ./code:/var/www/html

# копирование файлов внутрь контейнера
COPY ./conf/nginx/hosts/otus.loc.conf /etc/nginx/sites-enabled/otus.loc.conf

COPY ./files/index.php /var/www/html/otus.loc/index.php

# Открытие порта для слушания
EXPOSE 80

# Запускаем nginx когда стартует контейнер
CMD ["nginx", "-g", "daemon off;"]
