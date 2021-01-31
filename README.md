# 1.3 Работа с менеджерами пакетов

## 1.3.1 Установка расширений

### Установка Redis через PECL

* `apt install php-pear`
* `pear config-set php_suffix 7.4` - так как у меня по умолчанию используется php 7.4, но при этом в системе присутствует php 8.0.
* `apt-get install php7.4-dev` - чтобы заработал `phpize` для моей текущей версии php 7.4.
* `pecl install redis`
* `pecl list` (см. `screen_pecl_list.png`)
* `nano /etc/php/7.4/cli/php.ini` - добавляем строку `extension=redis.so`
* `php -i | grep Redis` (см. `screen_pecl_php_ini.png`)

### Установка Redis через make

* `git clone https://github.com/phpredis/phpredis.git`
* `cd phpredis`
* `git checkout 5.3.2`
* `phpize`
* `./configure`
* `make > make_output.txt` (см. `make_output.txt`)
* `make install`
* `nano /etc/php/7.4/cli/php.ini` - добавляем строку `extension=redis.so`
* `php -i | grep Redis` (см. `screen_make_php_ini.png`)