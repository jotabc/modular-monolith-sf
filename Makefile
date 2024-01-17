#!/bin/bash

UID = $(shell id -u)
DOCKER_BE = modular-monolith-example-app

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start: ## Start the containers
	docker network create modular-monolith-example-network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

build: ## Rebuilds all the containers
	docker network create modular-monolith-example-network || true
	cp -n docker-compose.yml.dist docker-compose.yml || true
	U_ID=${UID} docker-compose build

prepare: ## Runs backend commands
	$(MAKE) composer-install
	$(MAKE) migrations
	$(MAKE) migrations-test

run: ## starts the Symfony development server in detached mode
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} symfony serve -d

logs: ## Show Symfony logs in real time
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} symfony server:log

# Backend commands
composer-install: ## Installs composer dependencies
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} composer install --no-interaction

.PHONY: migrations migrations-test
migrations: ## run migrations for dev/prod environment
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:migrate -n
	# para migraciones una a una lo más recomendable para que nos genere en cada schema el archivo de doctrine_migrations que es donde están todas las migraciones de dicho schema.
	# U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:execute 'DoctrineMigrations\Version20240112155502' -n --em=customer_em

migrations-test: ## run migrations for test environment
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} bin/console doctrine:migrations:migrate -n --env=test

code-style: ## run code style
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} vendor/bin/php-cs-fixer fix src --rules=@Symfony
# End backend commands

ssh-be: ## bash into the be container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash
