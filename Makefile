# See https://tech.davis-hansson.com/p/make/
MAKEFLAGS += --warn-undefined-variables
MAKEFLAGS += --no-builtin-rules

PHP_CS_FIXER_BIN = vendor/bin/php-cs-fixer
PHP_CS_FIXER = $(PHP_CS_FIXER_BIN) fix
PHPUNIT_BIN = vendor/bin/phpunit
PHPUNIT = $(PHPUNIT_BIN)

.DEFAULT_GOAL := all

.PHONY: help
help:
	@printf "\033[33mUsage:\033[0m\n  make TARGET\n\n\033[32m#\n# Commands\n#---------------------------------------------------------------------------\033[0m\n"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//' | awk 'BEGIN {FS = ":"}; {printf "\033[33m%s:\033[0m%s\n", $$1, $$2}'

.PHONY: all
all: validate_package cs phpunit

.PHONY: validate_package
validate_package:
	composer validate --strict

.PHONY: clean
clean:		## Clean temporary files
clean:
	rm -rf dist \
		vendor \
		|| true
	mkdir -p dist
	touch dist/.gitkeep

	@# Silently remove old files
	@rm -rf .php-cs-fixer.cache \
		.phpunit.result.cache \
		|| true

.PHONY: cs
cs:		## Runs CS fixers
cs: php_cs_fixer

.PHONY: cs_lint
cs_lint:	## Runs CS linters
cs_lint: composer_normalize_lint php_cs_fixer_lint

.PHONY: php_cs_fixer
php_cs_fixer: $(PHP_CS_FIXER_BIN)
	$(PHP_CS_FIXER)

.PHONY: php_cs_fixer_lint
php_cs_fixer_lint: $(PHP_CS_FIXER_BIN)
	$(PHP_CS_FIXER) --dry-run

.PHONY: composer_normalize
composer_normalize: vendor
	composer normalize

.PHONY: composer_normalize_lint
composer_normalize_lint: vendor
	composer normalize --dry-run

.PHONY: phpunit
phpunit:	## Runs PHPUnit
phpunit: $(PHPUNIT_BIN)
	$(PHPUNIT)

composer.lock: composer.json
	@echo composer.lock is not up to date.

vendor: composer.lock
	composer update
	touch -c $@

$(PHP_CS_FIXER_BIN): vendor
