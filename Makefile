-include .env
export

.PHONY: install
install:
	@echo "Installing dependencies and development tools"
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		composer:2 sh -c " \
			composer install && \
			composer bin all install \
	"

.PHONY: analysis
analysis:
	@echo "Analyse code"
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/phpstan/vendor/bin/phpstan --version && \
			tools/phpstan/vendor/bin/phpstan analyze \
		"

.PHONY: style-fix
style-fix:
	@echo "Fixing code style"
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/php-cs-fixer/vendor/bin/php-cs-fixer --version && \
			tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --ansi \
		"

.PHONY: test
test:
	@echo "Running tests"
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/phpunit/vendor/bin/phpunit --version && \
			tools/phpunit/vendor/bin/phpunit \
		"

.PHONY: test-with-coverage
test-with-coverage:
	@echo "Running tests with code coverage"
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/phpunit/vendor/bin/phpunit --version && \
			tools/phpunit/vendor/bin/phpunit --coverage-text \
		"
