# Домашнее задание №3
# Установка php-расширений xdebug и redis через make

apk add git

echo ""
echo "====== BEGIN: установка xdebug ======"
echo ""
git clone https://github.com/xdebug/xdebug.git
cd xdebug
apk add php7-dev gcc g++ make
phpize
./configure --enable-xdebug
make > make_output_xdebug.txt
make install
docker-php-ext-enable xdebug
cd ..
echo ""
echo "====== END: установка xdebug ======"
echo ""

echo ""
echo "====== BEGIN: установка redis ======"
echo ""
git clone https://github.com/phpredis/phpredis.git
cd phpredis
phpize
./configure --enable-redis
make > make_output_redis.txt
make install
docker-php-ext-enable redis
cd ..
echo ""
echo "====== END: установка redis ======"
echo ""

php -i | grep -E '(redis|xdebug)'