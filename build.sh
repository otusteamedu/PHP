docker-compose build
composer install -d ./receiver/
composer install -d ./sender/
if [ ! -f ".env" ]; then
  cp .env.example .env
fi
