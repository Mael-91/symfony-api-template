sy := php bin/console

.DEFAULT_GOAL := help
.PHONY: help install cache-clear migration migrate rollback seed test tw analyse

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: vendor/autoload.php

cache-clear: # Clear Symfony cache
	$(sy) cache:clear

migration: vendor/autoload.php ## Generates migration
	$(sy) make:migration

migrate: vendor/autoload.php ## Migrates the database
	$(sy) doctrine:migrations:migrate -q

rollback: vendor/autoload.php
	$(sy) doctrine:migration:migrate prev -q

seed: vendor/autoload.php ## Load fixtures into the database
	$(sy) doctrine:schema:validate -q
	$(sy) doctrine:fixtures:load -q

test: vendor/autoload.php ## Launches unit tests
	php bin/phpunit

tw: vendor/autoload.php ## Run the watcher for unit tests
	ln vendor/bin/simple-phpunit vendor/bin/phpunit
	./vendor/bin/phpunit-watcher watch

analyse: vendor/autoload.php ## Analyze the code
	./vendor/bin/phpstan analyse

vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php ## ???