# my-stage
Solution for the Bax Music Rick and Morty developer case

## Preparation

While reading the challenge I started thinking of features.

I wanted to build a page which shows a random character.
Above that there should be search bars for characters, episodes and dimensions.
Later I thought about combining this bars into a single one.
And it would be nice to add an autosuggestion system.

The challenge requested the use of awesome techniques.

## Research

There are two APIs I could choose from; REST and GraphQL. 

During the research I found out that the GraphQL API has a few 'challenges'.
One of them is that it will always paginate the results. (Also for the REST.)
That gives me a problem for gathering all character names, which could be used in the autosuggestion.

## Proof of Concept

Tried some idea's in a basic html / php script.

## Planning

From a Product Owner view, it might be nice to create branches for each 'Sprint'.
That said, the following branches will be created;

1. Initial phase (Create project, PoC - files)
2. Developer framework (docker, plain Symfony, ~~graphQL package~~)
3. Create GraphQL client
4. Welcome page (show random character with info)
5. Overview (show grid and/or table)
6. Suggestion (search for and suggest)

## Development

Normally I would set up systems for (automatic) testing, but for now I decided to skip them. 
This is basically because it is a time-consuming task.


## During Development

First I've tried the Symfony way to use a docker `https://symfony.com/doc/current/setup/docker.html`, but somehow it failed.

Also, this simple solution, found on Google, did not work;
`https://medium.com/@oumaymaneffati/the-easy-way-to-install-symfony-with-docker-b6fca3997d2c`

So I fell back on my knowledge of Alpine dockers, but ended up using `https://www.twilio.com/en-us/blog/get-started-docker-symfony` which also failed. 
The problem was that the Dockerfile tried to copy a file from the Symfony installer. 
This installer created another directory, once I changed that, the container could be created.

Could not add the ./app directory to my repository. It seems there was a .git folder in the app
rm -r app/.git/

## Time registration
How long did it take me to develop this project. Hopefully this transparency doesn't work against me.

|    Day    | Duration in hours | Description                                   |
|:---------:|------------------:|:----------------------------------------------|
|  friday   |               4-6 | research                                      |
| saturday  |               2-3 | writing readme and creating docker            |
| saturday  |                 1 | trouble adding Symfony to repository          |
| saturday  |                 2 | GraphQL Client                                |
|  sunday   |                 1 | GraphQL Client and test controller            |
|  sunday   |                 1 | Welcome page with random image                |
|  sunday   |                 1 | Overview page with switchable grid            |
|  tuesday  |              0,25 | Card template                                 |
|  tuesday  |                 1 | Added overview page                           |
|  tuesday  |                 1 | Added different overview types / Added status |
|  tuesday  |                 1 | Autosuggestion                                |
| wednesday |               1,5 | Extract business logic from controller        |
| wednesday |               2,5 | Autosuggestion                                |
| thursday  |               1,5 | Typo's, table in markdown, clean up code      |
| thursday  |               1,5 | Prepare character info card                   |



## Nice to have improvements
- Extract css and js from template to files


## Helpful commands
### Build Docker Container
```shell
docker compose build --no-cache
docker compose up --build

docker-compose exec php /bin/bash

docker run --rm -it my-stage-php /bin/bash

check http://localhost:8080/

symfony check:requirements
symfony new .
```
### Install packages
```shell
docker run --rm -it -v ${pwd}:/var/www/app my-stage-php /bin/bash
    cd /var/www/app/app
    composer install
```
### Run tests
```shell
docker run -ti -v ${pwd}:/var/www/composer ghcr.io/devgine/composer-php:v2-php8.2-alpine sh

# Available tests in this docker (@see https://github.com/devgine/composer-php) 
    # PHP Copy Past Detector
    phpcpd ./app/src

    # PHP Coding Standards Fixer
    php-cs-fixer check -v ./app/src
    php-cs-fixer check -v --diff ./app/src

    php-cs-fixer fix -v ./app/src

    # PHPStan
    phpstan analyze --autoload-file=./app/vendor/autoload.php --level=1 ./app/src
    phpstan analyze --autoload-file=./app/vendor/autoload.php --level=9 ./app/src

    # PHP Unit
    simple-phpunit --bootstrap=vendor/autoload.php ./tests
    simple-phpunit --coverage-text --whitelist=./src  --bootstrap=vendor/autoload.php ./tests

    # Rector
    rector #first run will create rector.php in root as config file
    ## To see preview of suggested changed
    rector process --dry-run
    ## To make changes happen
    rector process
```