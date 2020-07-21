#!/bin/bash

. ./project.sh

HELP="deploy.sh -mdh\n
Аргументы скрипта:\n
 окружение для деплоя: \n
    -m  - production [по умолчанию]\n
    -d  - develop
    -t  - test
    -i  - issue collector
    -v  - verbose mode
"
MODE='-q'
ISSUE_COLLECTOR=0

while getopts ":hmdtvi" Option
do
  case $Option in
    m ) ENV='production';  GIT_BRANCH='master';;
    d ) ENV='development'; GIT_BRANCH='develop';;
    t ) ENV='testing';     GIT_BRANCH='test';;
    v ) MODE='';;
    i ) ISSUE_COLLECTOR=1;;
    h ) echo -e $HELP; exit 1;;
    * ) ENV='production'; GIT_BRANCH='master';;
  esac
done
shift $(($OPTIND - 1))

if [ ! $ENV ]; then
	ENV='production'
	GIT_BRANCH='master'
fi

echo -e "Деплой $ENV окружения...\n"

DIR_FILES="$LINK_DIRS/files_$ENV"
DIR_LOGS="$LINK_DIRS/logs_$ENV"
DIR_MEDIA="$LINK_DIRS/media_$ENV"
IC_JS="$DIR_CONFIG/ic.js"

LN_SITE="$DIR_ROOT/$ENV"

DIR_GIT="$DIR_ROOT/_$GIT_BRANCH"
DB_CONF="$DIR_CONFIG/database_$ENV.php"


CURRENT_DIR=$DIR_ROOT
cd $CURRENT_DIR

if [ -d "$DIR_GIT" ]; then
	rm -rf $DIR_GIT
fi

echo -e "\nКлонирование репозитория $GIT_REPO во временную папку исходных кодов проекта $DIR_GIT."
git clone $MODE $GIT_REPO $DIR_GIT
cd  $DIR_GIT

if [ "$ENV" = "production" ]; then
	VERSION="$(git describe --abbrev=0 --tags)"
	DIR_FRESH_DATA="$APP_DIR/$VERSION"

	git checkout $MODE $VERSION
else
	VERSION="$(git rev-parse --short HEAD)"
	DIR_FRESH_DATA="$APP_DIR/$GIT_BRANCH"
	git checkout $MODE $GIT_BRANCH
fi

echo -e "\nОбновление сабмодулей"
git submodule $MODE update --init --recursive

echo -e "\nВозврат в директорию скрипта $CURRENT_DIR"
cd $CURRENT_DIR

if [ ! -d "$APP_DIR" ]; then
	echo  -e "\nСоздание папки $APP_DIR"
	mkdir -p "$APP_DIR"
fi


if [ -d "$DIR_FRESH_DATA" ]; then
	echo  -e "\nУдаление имеющейся папки папки приложения $DIR_FRESH_DATA и создание новой"
	rm   -rf "$DIR_FRESH_DATA"
fi

echo -e "\nСоздание файла версии"
echo "<?php return array('version' => '$VERSION');" > "$DIR_GIT/application/config/version.php"


echo -e "\nКопирование файлов из временной папки исходных кодов проекта"

mv $DIR_GIT $DIR_FRESH_DATA

echo -e "\nУдаление папки файлов из папки приложения"
rm  -rf "$DIR_FRESH_DATA/application/files"
echo -e "\nУдаление папки логов из папки приложения"
rm  -rf "$DIR_FRESH_DATA/application/logs"
echo -e "\nУдаление папки media из папки приложения"
rm  -rf "$DIR_FRESH_DATA/htdocs/media"
echo -e "\nУдаление папки .git из приложения"
find $DIR_FRESH_DATA -name .git -exec echo {} \;

if [  -e "$DIR_FRESH_DATA/application/config/database.php" ]; then
	echo -e "\nУдаление файла конфига БД из папки приложения"
	rm      "$DIR_FRESH_DATA/application/config/database.php"
fi
if [ ! -d "$DIR_CONFIG" ]; then
	echo  -e "\nСозданиепапки конфигов $DIR_CONFIG"
	mkdir -p "$DIR_CONFIG"
fi

if [ ! -e "$DB_CONF" ]; then
	echo -e "\nКопирование файла $ENV конфига БД в папку конфигов"
	cp   -p "${DIR_FRESH_DATA}/modules/database/config/database.php" "$DB_CONF"
fi
if [ ! -d "$DIR_FILES" ]; then
	echo  -e "\nСоздание папки файлов $DIR_FILES"
	mkdir -p "$DIR_FILES"
fi
if [ ! -d "$DIR_LOGS" ]; then
	echo  -e "\nСоздание папки логов $DIR_LOGS"
	mkdir -p "$DIR_LOGS"
fi

if [ ! -d "$DIR_MEDIA" ]; then
	echo  -e "\nСоздание папки media-файлов $DIR_MEDIA"
	mkdir -p "$DIR_MEDIA"
fi

echo -e "\nСоздание ссылки на $DB_CONF"
ln  -sf "$DB_CONF"     "$DIR_FRESH_DATA/application/config/database.php"
echo -e "\nСоздание ссылки на $DIR_FILES"
ln   -s  "$DIR_FILES"  "$DIR_FRESH_DATA/application/files"
echo -e "\nСоздание ссылки на $DIR_LOGS"
ln   -s  "$DIR_LOGS"   "$DIR_FRESH_DATA/application/logs"
echo -e "\nСоздание ссылки на $DIR_MEDIA"
ln   -s  "$DIR_MEDIA"  "$DIR_FRESH_DATA/htdocs/media"
echo -e "\nСброс статики в папке $DIR_MEDIA"
rm  -rf "$DIR_MEDIA/cache"
rm  -rf "$DIR_MEDIA/static"

if [ "$ISSUE_COLLECTOR" = "1" ]; then
    echo -e "\nАктивация ISSUE COLLECTOR"
    rm      "$DIR_FRESH_DATA/htdocs/js/issue_collector.js" 
    ln   -s "$IC_JS" "$DIR_FRESH_DATA/htdocs/js/issue_collector.js"
fi

echo      -e "\nРасстановка прав на папки cache и media"
chmod -R g+w "$DIR_FRESH_DATA/application/cache"
chmod -R g+w "$DIR_FRESH_DATA/application/logs"
chmod -R g+w "$DIR_FRESH_DATA/htdocs/media"


if [ -e "$LN_SITE" ]; then
	echo -e "\nУдаление символьной ссылки $LN_SITE"
	rm  -rf "$LN_SITE"
fi

if [ -e $DIR_CONFIG/extra_commands.sh ]; then
	export DIR_CONFIG
	export DIR_FRESH_DATA
	export ENV
	
	echo -e "\nЗапуск доп команд для проекта"
	cd $DIR_CONFIG
	$DIR_CONFIG/extra_commands.sh
fi

echo -e "\nСоздание символьной ссылки $LN_SITE на $DIR_FRESH_DATA"
ln -sf $DIR_FRESH_DATA $LN_SITE

echo -e "\nУдаление временной директории $DIR_GIT"
rm -rf "$LN_SITE/htdocs/media/cache"