.PHONY: all
.RECIPEPREFIX = |

all:
| php-7.2-latest -dzend_extension=xdebug ~/Tools/phpunit-8.1.3.phar 
| firefox tests/_reports/coverage/index.html

