DOCKER_PHP = docker-compose run --user www-data php
DOCKER_NODE = docker-compose run --rm --user node node

#-include .env

.PHONY: artisan vendor

# Run application
run: up

# Update vendor
vendor:
	$(DOCKER_PHP) composer update

# Enter into PHP
php:
	$(DOCKER_PHP) bash

# Enter into Node
node:
	$(DOCKER_NODE) bash

# Webpack run
webpack:
	$(DOCKER_NODE) npm run start

# Run composer
composer:
	$(DOCKER_PHP) composer ${cmd}

# Composer Dump Autoload
autoload:
	$(DOCKER_PHP) composer dumpautoload

# Run artisan
artisan:
	$(DOCKER_PHP) php artisan ${cmd}

# Run migrate
migrate:
	$(DOCKER_PHP) php artisan migrate

# Run migrate with refresh
refresh:
	$(DOCKER_PHP) php artisan migrate:refresh --seed

# Lint
lint:
	$(DOCKER_PHP) phpcs -sp --standard=./sniffer.xml --report-width=150

# Lint fix
lintfix:
	$(DOCKER_PHP) phpcbf --standard=./sniffer.xml

# Configure environment
install:
	cp ./hooks/* ./.git/hooks
	if [ ! -f ".env" ]; then cp ./.env.example ./.env; fi
	if [ -z "`docker network ls | grep pet_city_network`" ]; then docker network create pet_city_network; fi
	$(MAKE) up
	$(DOCKER_PHP) composer install
	$(DOCKER_PHP) php artisan key:generate
	$(DOCKER_PHP) php artisan storage:link
	$(DOCKER_NODE) npm install

# Start docker
up: down
	docker-compose up --build -d

# Stop docker
down:
	docker-compose down

# Show docker processes
ps:
	docker-compose ps

