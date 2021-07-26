apt-get update && apt-get install -y \
    curl \
    net-tools \
    iputils-ping \
    wget \
    git \
    grep \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    && pecl install mcrypt \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
apt-get install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis
apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
apt install git-all
git clone git@bitbucket.org:aivanov-otus/otus.hw31-project.git
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
composer install
mv .env.example .env
php artisan key:generate
php artisan migrate
php artisan queue:work
