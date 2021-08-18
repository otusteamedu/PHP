#!/bin/bash
# Выпуск самоподписанного сертификата.
# Основан на этой статье: https://habr.com/ru/post/352722/
dir=$(dirname $0)
# Первый параметр обязателен. Выведем небольшую инструкцию для пользователя.
if [ -z "$1" ]
then
  echo "Please supply a subdomain to create a certificate for";
  echo "e.g. mysite.localhost"
  exit;

# Создадим новый приватный ключ device.private.key, если он не существует или будем использовать существующий (тот же что и для других сайтов):
fi
if [ -f /var/www/cert/device.private.key ]; then
  KEY_OPT="-key"
else
  KEY_OPT="-keyout"
fi

# Запросим у пользователя название домена. Добавим возможность задания “общего имени” (оно используется при формировании сертификата):
DOMAIN=$1
COMMON_NAME=${2:-$1}

# В переменной SUBJECT перечислены все те же вопросы, который задавались при создании корневого сертификата (страна, город, компания и т.д).
# Все значение, кроме CN можно поменять на свое усмотрение.
SUBJECT="/C=RU/ST=None/L=NB/O=None/CN=$COMMON_NAME"
NUM_OF_DAYS=1024

# Сформируем csr файл (Certificate Signing Request) на основе ключа. Подробнее о файле запроса сертификата можно:
# https://www.sslshopper.com/what-is-a-csr-certificate-signing-request.html
openssl req -new -newkey rsa:2048 -sha256 -nodes $KEY_OPT /var/www/cert/device.private.key -subj "$SUBJECT" -out device.csr

# Формируем файл сертификата. Для этого нам понадобится вспомогательный файл с настройками. В этот файл мы запишем домены,
# для которых будет валиден сертификат и некоторые другие настройки. Назовем его v3.ext. Внимание!, это отдельный файл, а не часть bash скрипта.
# authorityKeyIdentifier=keyid,issuer
  #basicConstraints=CA:FALSE
  #keyUsage = digitalSignature, nonRepudiation, keyEncipherment, dataEncipherment
  #subjectAltName = @alt_names
  #
  #[alt_names]
  #DNS.1 = %%DOMAIN%%
  #DNS.2 = *.%%DOMAIN%%

# На основе вспомогательного файла v3.ext создаем временный файл с указанием нашего домена:
cat $dir/v3.ext | sed s/%%DOMAIN%%/$COMMON_NAME/g > /tmp/__v3.ext

# Выпускаем сертификат:
openssl x509 -req -in device.csr -CA /var/www/cert/rootCA.pem -CAkey /var/www/cert/rootCA.key -CAcreateserial -out device.crt -days $NUM_OF_DAYS -sha256 -extfile /tmp/__v3.ext

# Переименовываем сертификат и удаляем временный файл:
mv device.csr /var/www/cert/$DOMAIN.csr
cp device.crt /var/www/cert/$DOMAIN.crt

# remove temp file
rm -f device.crt;
rm -f /tmp/__v3.ext