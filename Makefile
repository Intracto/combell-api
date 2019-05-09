.PHONY: all
.RECIPEPREFIX = |

all:
| php -dzend_extension=xdebug ./vendor/bin/phpunit 
| firefox tests/_reports/coverage/index.html

debug:
| DEBUG_DUMPS=1 php -dzend_extension=xdebug ./vendor/bin/phpunit
| firefox tests/_reports/coverage/index.html

phpstan:
| php -dmemory_limit=-1 ./vendor/bin/phpstan analyse src
