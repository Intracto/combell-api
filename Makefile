.PHONY: all
.RECIPEPREFIX = |

all:
| php -dzend_extension=xdebug ./vendor/bin/phpunit 
| firefox tests/_reports/coverage/index.html

debug:
| DEBUG_DUMPS=1 php -dzend_extension=xdebug ./vendor/bin/phpunit
| firefox tests/_reports/coverage/index.html

