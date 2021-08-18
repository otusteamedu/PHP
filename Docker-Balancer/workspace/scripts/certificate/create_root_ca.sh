#!/bin/bash
# Формирование Корневого сертификата:
# Основан на этой статье: https://habr.com/ru/post/352722/

# Запускается один раз для всех сайтов.
# Если запустить повторно, то rootCA будет перезаписан и корневой сертификат, который был выпущен для ранее созданных сайтов исчезнет.
# Сначала сформируем закрытый ключ:
openssl genrsa -out /var/www/cert/rootCA.key 2048

# В переменной SUBJECT перечислены все те же вопросы, который задавались при создании корневого сертификата (страна, город, компания и т.д).
# Все значение, кроме CN можно поменять на свое усмотрение.
SUBJECT="/C=RU/ST=RUSSIA/L=Moscow/O=HOME ltd/OU=Developers Room/CN=Vladimir/emailAddress=vladimir@email.ru"
        # C=RU                                 # Страна
        # ST=Ivanovskaya                       # Область
        # L=Gadukino                           # Город
        # O=Krutie parni                       # Название организации
        # OU=Sysopka                           # Название отделения
        # CN=Your personal certificate         # Имя для сертификата(персоны, получающей сертификат)
        # emailAddress=certificate@gaduk.ru    # Мыло организации
NUM_OF_DAYS=1024
# Затем сам сертификат:
# если хочется руками в командной строке >openssl req -x509 -new -nodes -key /var/www/cert/rootCA.key -sha256 -days 1024 -out /var/www/cert/rootCA.pem
# Нужно будет ввести страну, город, компанию и т.д.
openssl req -x509 -new -nodes -key /var/www/cert/rootCA.key -sha256 -days $NUM_OF_DAYS -subj "$SUBJECT" -out /var/www/cert/rootCA.pem
# В результате получаем два файла: rootCA.key и rootCA.pem
