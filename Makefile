.PHONY: up down build restart logs shell migrate seed fresh

up:
	docker compose up -d


down:
	docker compose down

build:
	docker compose build --no-cache

restart:
	docker compose restart

logs:
	docker compose logs -f app

logs-all:
	docker compose logs -f

shell:
	docker compose exec app sh

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

fresh:
	docker compose exec app php artisan migrate:fresh --seed

tinker:
	docker compose exec app php artisan tinker

test:
	docker compose exec app php artisan test
