#!/bin/bash

. ./project.sh

echo -e "\nПереданные переменные:
ENV=$ENV
DIR_CONFIG=$DIR_CONFIG
DIR_FRESH_DATA=$DIR_FRESH_DATA
"

SITE_CONF="$DIR_CONFIG/site_$ENV.php"
SITE_CONF_DEPLOY="$DIR_FRESH_DATA/application/config/site.php"

if [ ! -e "$SITE_CONF" ]; then
	echo -e "\nКопирование файла конфига ресурса в папку конфигов"
	cp      "$SITE_CONF_DEPLOY" "$SITE_CONF"
fi

echo -e "\nУдаление файла конфига ресурса в папке выгрузки  $SITE_CONF_DEPLOY"
rm      "$SITE_CONF_DEPLOY"

echo -e "\nСоздание ссылки на конфиг ресурса $SITE_CONF -> $SITE_CONF_DEPLOY"
ln   -s "$SITE_CONF" "$SITE_CONF_DEPLOY"

if [ -e "$DIR_FRESH_DATA/htdocs/minion" ]; then
	echo  -e "\nПроставляем права на $DIR_FRESH_DATA/htdocs/minion"
	chmod +x "$DIR_FRESH_DATA/htdocs/minion"
fi