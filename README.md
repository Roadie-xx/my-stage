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
6. Suggestion (search for and suggest random)

## Development

As requested for the Backend Developer I used PHP8+ and Symfony for this project.

I also created the docker, not only because it was mentioned in the bonus point system, but also because it helps to make development easier.

### Automatic testing

Normally I would set up systems for (automatic) testing, but for now I decided to skip them. 
This is basically because it is a time-consuming task.

But with the use of a prefab docker container I was able to run some tests for codestyling and code analyses.

### During Development

First I've tried the Symfony way to use a docker `https://symfony.com/doc/current/setup/docker.html`, but somehow it failed.

Also, this simple solution, found on Google, did not work;
`https://medium.com/@oumaymaneffati/the-easy-way-to-install-symfony-with-docker-b6fca3997d2c`

So I fell back on my knowledge of Alpine dockers, but ended up using `https://www.twilio.com/en-us/blog/get-started-docker-symfony` which also failed. 
The problem was that the Dockerfile tried to copy a file from the Symfony installer. 
This installer created another directory, once I changed that, the container could be created.

Could not add the ./app directory to my repository. It seems there was a .git folder in the app
rm -r app/.git/

### AutoSuggest

Since I would create an AutoSuggest system but the API always uses pagination, I decided to cheat.
Normally I would use the API to respond with suggestions, but now I gathered the data and stored it in JSON-files.

The AutoSuggest filters characters, episodes and locations by name.
It is possible to enable or disable each result type (characters, episodes and locations).

As an extra, I've added for each type an random button. 

## Frontend Developer Items

### JavaScript

This solution contains some javascript, based on ES6. 
It handles the switching between a grid and a table style view.

Also the AutoSuggest is basically build in JS. 
This is working code, but with more time I probably would refactor that into a javascript class.
In a perfect world I would also add some tests.

I'm confident I could also deliver this project in a javascript way, which will be clear if you take a look in the Proof of Concept directory.

### Stimulus

Never heard of this, but Google was helpfull.
I think I would be able to work with it, but using Stimulus in this project would be too time consumig.

### Webpack

I only used Webpack once (long ago), but when I read the documentation on Symfony, it said that there is a successor named AssetMapper. 
So I decided to skip this.

### CSS framework like Tailwind

Since I never used the Tailwind framework, I used the Bootstrap framework. 
To my knowlegde there are a lot similarities between them. 
I think is you understand one of them, you should be able to use the other. 
But since I did not know all the selector names of Tailwind, I stick with Bootstrap.

## Bonus: Integrate 1 or more additional API's in a creative way

I've been thinking about this, but could not think of a creative way to implement an API.
Possibilities were a weather api, a random joke api and a random quote.
I almost included a lyrics API, to show what music the characters were listening to. 
But during testing this API it seemed this API was offline.

## Nice to have improvements
- ~~Extract css and js from template to files~~

### Logging pagerequests

It would be a nice to have to log the page visits. 
This could be done by using Monolog and require setting up a database connection.

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
| thursday  |                 1 | Implement Autosuggestion                      |
|  friday   |                 3 | Add interaction (click)                       |
| saturday  |                 1 | Updated readme                                |


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