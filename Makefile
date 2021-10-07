build:
	docker-compose build

server_up:
	docker-compose up

migrate:
	docker exec -it webapp php artisan migrate
