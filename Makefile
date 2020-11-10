.PHONY:

bootstrap: build set-config install-backend-dependencies generate-app-key install-frontend-dependencies start

build:
	@docker-compose build

start:
	@docker-compose up --force-recreate -d

stop:
	@docker-compose stop

set-permissions:
	@docker-compose run --rm php chmod -R 777 ./storage ./bootstrap/cache

set-config: set-permissions
	@([ -f ./.env ] || (echo [?] Using default .env file... && cp ./.env.example ./.env))

install-frontend-dependencies:
	@docker-compose run --rm nodejs npm i

build-frontend-assets:
	@docker-compose run --rm nodejs npm run prod

install-backend-dependencies:
	@docker-compose run --rm php composer install

generate-app-key:
	@docker-compose run --rm php ./artisan key:generate

run-backend-tests:
	@docker-compose exec php ./artisan test

run-backend-migrations:
	@docker-compose exec php ./artisan migrate

run-backend-seed:
	@docker-compose exec php ./artisan db:seed --class=EmployeeSeeder