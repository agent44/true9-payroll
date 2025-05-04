phpstan:
	vendor/bin/phpstan

phpcs_check:
	vendor/bin/php-cs-fixer check -vvv

phpcs_fix:
	vendor/bin/php-cs-fixer fix -vvv

test:
	bin/phpunit

qa: phpcs_check phpstan test
