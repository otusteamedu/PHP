uid := $(shell id -u)
gid := $(shell id -g)

init: docker-down docker-build docker-up composer-install set-socket-permissions
up: docker-up
build: docker-build
down: docker-down

docker-down:
	export uid=$(uid) gid=$(gid); \
	docker-compose down --remove-orphans

docker-build:
	export uid=$(uid) gid=$(gid); \
	docker-compose build

docker-up:
	export uid=$(uid) gid=$(gid); \
	docker-compose up -d

composer-install:
	export uid=$(uid) gid=$(gid); \
	docker-compose exec server composer install

set-socket-permissions:
	export uid=$(uid) gid=$(gid); \
	docker-compose exec --user root server chmod a+w /socket
