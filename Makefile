info:
	php artisan about

init:
	cp -u .env.example .env
	php artisan key:generate --ansi

init-test:
	cp -u .env.testing.example .env.testing
	php artisan key:generate --ansi --env=testing

build-db:
	php artisan migrate
	php artisan add:user admin admin@example.com test123
	php artisan import:sql

build-db-test:
	php artisan migrate --env=testing

clear:
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear

test:
	php artisan test
