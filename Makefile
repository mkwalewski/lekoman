ifeq ($(OS),Windows_NT)
    # Windows stuff
    PHP = php
    COMPOSER = composer
else
    # Linux / OSX stuff
    PHP = ea-php81
    COMPOSER = composer
endif

info:
	$(PHP) artisan about

init:
	cp -u .env.example .env
	$(PHP) artisan key:generate --ansi

init-test:
	cp -u .env.testing.example .env.testing
	$(PHP) artisan key:generate --ansi --env=testing

install:
	$(COMPOSER) install

install-dev:
	$(COMPOSER) install --no-dev

build-db:
	$(PHP) artisan migrate
	$(PHP) artisan add:user admin admin@example.com test123
	$(PHP) artisan import:sql

build-db-test:
	$(PHP) artisan migrate --env=testing

migrate:
	$(PHP) artisan migrate

migrate-test:
	$(PHP) artisan migrate --env=testing

link:
	$(PHP) artisan storage:link

cache:
	$(PHP) artisan config:cache
	$(PHP) artisan route:cache
	$(PHP) artisan view:cache

clear:
	$(PHP) artisan cache:clear
	$(PHP) artisan config:clear
	$(PHP) artisan route:clear
	$(PHP) artisan view:clear

test:
	$(PHP) artisan test
