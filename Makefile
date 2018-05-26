# Duplicate local settings files
init-settings:
	cp .env.dist .env
	cp phpunit.xml.dist phpunit.xml
	$(info *******************************************************************************)
	$(info * Please edit your .env and phpunit.xml.dist to set your database credentials *)
	$(info *******************************************************************************)

# Install project
install:
	composer install
	yarn
	php bin/console d:d:c
	php bin/console d:s:c
	php bin/console h:f:l

# Start local server
server:
	php bin/console s:start

## Launch tests
test:
	php bin/phpunit
