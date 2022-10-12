# See https://tech.davis-hansson.com/p/make/
MAKEFLAGS += --warn-undefined-variables
MAKEFLAGS += --no-builtin-rules

PHP_CS_FIXER_BIN = vendor/bin/php-cs-fixer
PHP_CS_FIXER = $(PHP_CS_FIXER_BIN) fix
PHPUNIT_BIN = vendor/bin/phpunit
PHPUNIT = $(PHPUNIT_BIN)

.DEFAULT_GOAL := all

.PHONY: all
all: validate_package cs phpunit

.PHONY: validate_package
validate_package: vendor
	composer validate --strict

.PHONY: cs
cs: $(PHP_CS_FIXER_BIN)
	$(PHP_CS_FIXER)

.PHONY: phpunit
phpunit: $(PHPUNIT_BIN)
	$(PHPUNIT)

composer.lock: composer.json
	@echo composer.lock is not up to date.

vendor: composer.lock
	composer update
	touch -c $@

$(PHP_CS_FIXER_BIN): vendor
