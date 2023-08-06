up:
	docker-compose up -d
	docker-compose exec front sh -c "cd jhm-2023-front && npm run dev"

upApi:
	docker-compose up -d

init:
	docker-compose up --build -d
	docker compose exec api composer create-project --prefer-dist laravel/laravel . "10.*"
	docker-compose exec api composer install
	docker-compose exec api cp .env.example .env
	docker-compose exec api php artisan key:generate
	docker-compose exec api php artisan migrate:refresh --seed
	docker-compose exec front npx nuxi@latest init jhm-2023-front
	docker-compose exec front sh -c "cd jhm-2023-front && npm i"
	docker-compose down

down:
	docker-compose down

dbfresh:
	docker-compose exec api php artisan migrate:fresh --seed

mvapi:
	docker-compose exec api sh

mvfront:
	docker-compose exec front sh

mvweb:
	docker-compose exec web sh

mvdb:
	docker-compose exec db sh

f:
	docker-compose exec front sh -c "cd jhm-2023-front && npm run format"
	docker-compose exec api ./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php -v --diff ./app

test:
	docker-compose exec api php artisan config:clear
	docker-compose exec api php artisan test
	docker-compose exec api php artisan test tests/Feature/Authenticate/loginAppUser.php