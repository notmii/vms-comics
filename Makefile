build:
	docker-compose build

up:
	docker-compose up

down:
	docker-compose up

migrate:
	docker exec -it vms-comics-webapp php artisan migrate
