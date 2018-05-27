# Duplicate local settings files
setup:
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
	yarn run watch

# Export products list on .csv format
export:
	php bin/console app:export-products

# Launch tests
test:
	php bin/phpunit
