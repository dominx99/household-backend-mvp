compose_file := "docker-compose.yml"
household-php-service := "php_household"
current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
household-bin-location := "./bin"
household-console-location := "./bin/console"
env-file := "./.env.local"

.PHONY: prod
prod: CMD=--env-file $(env-file) -f docker-compose.prod.yml up --build -d

# 🐳 Docker Compose
.PHONY: up
up: CMD=--env-file $(env-file) up --build -d

.PHONY: stop
stop: CMD=stop

.PHONY: down
destroy: CMD=down

.PHONY: build
build: deps up

.PHONY: deps
deps: composer-install

.PHONY: composer
composer dump composer-install composer-update composer-require composer-require-module: composer-env-file
	@docker run --rm $(INTERACTIVE) --volume $(current-dir):/app --user $(id -u):$(id -g) \
		composer:2 $(CMD) \
			--no-ansi

.PHONY: dump
dump: CMD=dump-autoload

.PHONY: composer-install
composer-install: CMD=install

.PHONY: composer-update
composer-update: CMD=update

.PHONY: composer-require
composer-require: CMD=require
composer-require: INTERACTIVE=-ti --interactive

.PHONY: composer-require-module
composer-require-module: CMD=require $(module)
composer-require-module: INTERACTIVE=-ti --interactive

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
.PHONY: doco
doco up prod stop destroy: composer-env-file
	@docker-compose $(CMD)

.PHONY: rebuild
rebuild: composer-env-file
	docker-compose build --pull --force-rm --no-cache
	make deps
	make up

# 🐘 Composer
composer-env-file:
	@if [ ! -f .env.local ]; then echo '' > .env.local; fi

.PHONY: fix
fix:
	@docker-compose exec $(household-php-service) php vendor/bin/php-cs-fixer fix src --allow-risky=yes
	@docker-compose exec $(household-php-service) php vendor/bin/php-cs-fixer fix tests --allow-risky=yes

clear:
	@docker-compose exec $(household-php-service) php $(household-console-location) cache:clear
	@docker-compose exec $(household-php-service) php $(household-console-location) doctrine:cache:clear-metadata
	@docker-compose exec $(household-php-service) php $(household-console-location) doctrine:cache:clear-query
	@docker-compose exec $(household-php-service) php $(household-console-location) doctrine:cache:clear-result

.PHONY: test
test: composer-env-file
	docker-compose exec $(household-php-service) php $(household-bin-location)/phpunit

test-household th: composer-env-file
	docker-compose exec $(household-php-service) php $(household-bin-location)/phpunit --testsuite household

test-shared ts: composer-env-file
	docker-compose exec $(household-php-service) php $(household-bin-location)/phpunit --testsuite shared

.PHONY: run-tests
run-tests: composer-env-file
	mkdir -p build/test_results/phpunit
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite household
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite shared

test-coverage tc:
	@docker-compose -f $(compose_file) exec $(household-php-service) $(household-bin-location)/phpunit --coverage-html .coverage $(CMD)
	@brave ".coverage/index.html"

migrate:
	@docker-compose exec $(household-php-service) php $(household-console-location) doctrine:migrations:migrate

diff:
	@docker-compose exec $(household-php-service) php $(household-console-location) doctrine:migrations:diff

.PHONY: static-analysis
static-analysis st: composer-env-file
	docker-compose exec $(household-php-service) ./vendor/bin/psalm $(CMD)

.PHONY: console
console:
	docker-compose exec $(household-php-service) $(household-console-location) $(CMD)

.PHONY: bash
	docker-compose exec $(household-php-service) $(household-console-location) bash
