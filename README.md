# Payroll Calculator

This is an app to calculate the dates for the payment processing date and payday for a given month.

It is built with:
- PHP 8.3
- Symfony 7.2
- Stimulus

A docker environment is provided to run the app that utilises the Symfony dev server,.

## Installation

Prerequisites: 
- PHP & Composer, see https://getcomposer.org/doc/00-intro.md#system-requirements
- Docker https://docs.docker.com/desktop/

- If you haven't already, clone this repository:
  - `git clone git@github.com:agent44/true9-payroll.git`
- Navigate to the root of the project:
  - `cd true9-payroll`
- Install dependencies:
  - `composer install`
- Build the docker image
  - `docker build -t chrisshennan/symfony-cli .`
- Start the docker container
  - `docker run -it -p 8000:8000 -v "$(pwd):/app" chrisshennan/symfony-cli local:server:start --dir=/app --port=8000 --no-tls --allow-all-ip`
- In a new terminal window run:
  - `docker ps`
- Copy the container ID and run the following to access a terminal on the docker container:
  - `docker exec -it <<id>> sh`
- You can now access the app at http://127.0.0.1:8000

## QA
All the following should be run from the root of the project.

- PHPStan
  - `vendor/bin/phpstan --memory-limit=256M`
- PHP CS Fixer (check only)
  - `vendor/bin/php-cs-fixer check`
- PHP CS Fixer (check and fix)
  - `vendor/bin/php-cs-fixer fix`
- Unit, API and Functional tests
  - `bin/phpunit`

