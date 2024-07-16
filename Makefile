setup:
	composer install
	yarn
	cp .env.example .env
	sudo chmod o+w ./storage/ -R
	sudo chown www-data:www-data -R ./storage
	php artisan key:generate
	php artisan storage:link
serve:
	sudo docker-compose up
clear-cache:
	php artisan route:clear
	php artisan config:clear
	php artisan cache:clear
lint:
	./vendor/bin/duster lint
lint-fix:
	./vendor/bin/duster fix
test:
	php artisan test --env=testing
ci-test:
	docker compose -f docker-compose.yml up -d db
	sleep 3
	docker compose -f docker-compose.yml run app make test
generate-key:
	php artisan key:generate