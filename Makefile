setup:
	composer install
	yarn
serve:
	cp .env.example .env
	sudo chmod o+w ./storage/ -R
	sudo chown www-data:www-data -R ./storage
	sudo docker-compose up
	yarn
