-include .env
export

.PHONY: install
install:
	@echo "Installing dependencies and development tools"
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		--entrypoint /bin/sh \
		finalgene/composer -c " \
			composer install && \
			composer bin codacy install && \
			composer bin phpunit install && \
			composer bin phpstan install && \
			composer bin squizlabs install \
	"

.PHONY: analysis
analysis:
	@echo "Analyse code"
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpstan --version
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpstan analyze src tests

.PHONY: style-check
check-style:
	@echo "Checking code style"
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpcs --version
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpcs -p

.PHONY: style-fix
fix-style:
	@echo "Fixing code style"
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpcbf --version
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpcbf -p

.PHONY: test
test:
	@echo "Running tests"
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpunit --version
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpunit

.PHONY: test-with-coverage
test-with-coverage:
	@echo "Running tests with code coverage"
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			vendor/bin/phpunit --version
	@docker run \
		--rm \
		--volume $(shell pwd):/app \
		finalgene/php-cli:7.2-xdebug php \
			-dzend_extension=xdebug.so vendor/bin/phpunit --coverage-text
