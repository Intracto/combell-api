.PHONY: all test lint phpunit debug phpstan
.RECIPEPREFIX = |

all: lint phpstan phpunit
| xdg-open tests/_reports/coverage/index.html

test: lint phpstan phpunit-nocoverage

lint:
| find src -type f -name '*.php' -print0 | xargs -0 -n1 -P4 php -l -n | (! grep -v "No syntax errors detected" )

phpunit:
| php -dzend_extension=xdebug ./vendor/bin/phpunit

phpunit-nocoverage:
| php ./vendor/bin/phpunit --no-coverage

debug:
| DEBUG_DUMPS=1 php -dzend_extension=xdebug ./vendor/bin/phpunit

phpstan:
| php -dmemory_limit=-1 ./vendor/bin/phpstan analyse --level=5 src

