#из образа debian
FROM debian
#обновляем списки пакетов
RUN apt-get update
#устанавливаем nginx
RUN apt-get install -y nginx
#ставим временную зону Москву
ENV TZ=Europe/Moscow
#создаем ссылку на файл, а потом выводим сообщение
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
#указываем рабочую дерикторию
WORKDIR /var/www
#копируем файл с хост машины в контейнер
COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

COPY ./files/index.html /var/www/mysite.local/index.html

#открываем 80 порт
EXPOSE 80

#выполняем команды
CMD ["nginx", "-g", "daemon off;"]
