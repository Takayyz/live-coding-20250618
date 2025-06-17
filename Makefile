.PHONY: up down restart logs shell migrate seed test clean db-connect

up:
	@./setup.sh

down:
	@echo "Stopping Docker containers..."
	@docker compose down

restart:
	@echo "Restarting Docker containers..."
	@docker compose restart

logs:
	@echo "Showing Docker logs..."
	@docker compose logs -f

shell:
	@echo "Opening shell in app container..."
	@docker compose exec app bash

migrate:
	@echo "Running database migrations..."
	@docker compose exec app php artisan migrate

seed:
	@echo "Running database seeders..."
	@docker compose exec app php artisan db:seed

test:
	@echo "Running tests..."
	@docker compose exec app php artisan test

clean:
	@echo "Cleaning up Docker resources..."
	@docker compose down -v
	@docker system prune -f
	@echo "Removing vendor directory..."
	@rm -rf src/vendor

db-connect:
	@echo "Connecting to MySQL database..."
	@docker compose exec db mysql -ularavel -p laravel
