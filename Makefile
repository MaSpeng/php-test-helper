export

# VARIABLES
.DEFAULT_GOAL := help
MAKEFILE := $(firstword $(MAKEFILE_LIST))

.PHONY: help
help: ## Display help
	@printf "MaSpeng PHP-Test-Helper Makefile\n\n\033[33mUsage:\033[0m\n  make [target]\n\n\033[33mTargets:\033[0m\n"
	@awk 'BEGIN {FS = ":.*?## "} /^[0-9a-zA-Z_-]+:.*?## / {printf "  \033[32m%-21s\033[0m %s\n", $$1, $$2}' $(MAKEFILE)

.PHONY: install
install: ## Installing dependencies and development tools
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		composer:2 sh -c " \
			composer install && \
			composer bin all install \
	"

.PHONY: analyse-code
analyse-code: ## Analyse code
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/phpstan/vendor/bin/phpstan --version && \
			tools/phpstan/vendor/bin/phpstan analyze \
		"

.PHONY: fix-code
fix-code: ## Fix code style
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/php-cs-fixer/vendor/bin/php-cs-fixer --version && \
			tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --ansi \
		"

.PHONY: test
test: ## Run test suite
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/phpunit/vendor/bin/phpunit --version && \
			tools/phpunit/vendor/bin/phpunit \
		"

.PHONY: test-with-coverage
test-with-coverage: ## Run test suite + generate coverage report
	@docker run \
		--rm \
		--volume "${PWD}:/app" \
		--workdir /app \
		php:8.1-cli-alpine sh -c " \
			tools/phpunit/vendor/bin/phpunit --version && \
			tools/phpunit/vendor/bin/phpunit --coverage-text \
		"
