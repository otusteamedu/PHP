# Домашнее задание №3
# Установка php-расширений xdebug и redis через pecl

apk add php7-dev gcc g++ make

echo ""
echo "====== BEGIN: установка xdebug ======"
echo ""
pecl install -of xdebug
docker-php-ext-enable xdebug
echo ""
echo "====== END: установка xdebug ======"
echo ""

echo ""
echo "====== BEGIN: установка redis ======"
echo ""
pecl install -o -f redis
docker-php-ext-enable redis
echo ""
echo "====== END: установка redis ======"
echo ""

php -i | grep -E '(redis|xdebug)'