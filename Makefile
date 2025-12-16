APP=app

up:
	docker compose up -d --build

down:
	docker compose down

restart:
	docker compose down
	docker compose up -d

logs:
	docker compose logs -f

bash:
	docker compose exec $(APP) bash

artisan:
	docker compose exec $(APP) php artisan $(cmd)

migrate:
	docker compose exec $(APP) php artisan migrate

seed:
	docker compose exec $(APP) php artisan db:seed

queue:
	docker compose exec worker php artisan queue:work

test:
	docker compose exec $(APP) php artisan test
