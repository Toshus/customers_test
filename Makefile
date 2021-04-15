SHELL := /bin/bash

SET_TEST_ENV = export APP_ENV=test
INIT_TEST_DATABASE = $(SET_TEST_ENV) && ./bin/console doctrine:database:drop --force || true && ./bin/console doctrine:database:create && ./bin/console doctrine:migrations:migrate -n && ./bin/console doctrine:fixtures:load -n

.PHONY: tests unit functional

tests:
	$(INIT_TEST_DATABASE)
	./bin/phpunit -c phpunit.xml.dist

unit:
	./bin/phpunit -c phpunit.xml.dist --testsuite Unit

functional:
	$(INIT_TEST_DATABASE)
	./bin/phpunit -c phpunit.xml.dist --testsuite Functional
