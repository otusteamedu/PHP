init: docker-down-clear docker-pull docker-build docker-up
restart: docker-down docker-up

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v  --remove-orphans

composer:
	docker-compose run --rm mysite-php-cli composer some-command

run-consumer:
	docker-compose run --rm mysite-php-cli php app.php run-consumer 237712913 Bob 12.12.2021 '["+7-777-300","+7-777-301"]'