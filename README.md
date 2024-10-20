# my-stage
Solution for the Bax Music Rick and Morty developer case

## Preparation

While reading the challenge I started thinking of features.

I wanted to build a page which shows a random character.
Above that there should be search bars for characters, episodes and dimensions.
Later I thought about combining this bars into a single one.
And it would be nice to add autosuggest.

The challenge requested the use of awesome techniques.

## Research

There are two API's I could choose from; REST and GraphQL. 

During the reseach I found out that the GraphQL API has a few 'crucks'.
One of them is that it will allways paginate the results. (Also for the REST.)
That gives me a problem for gathering all character names, which could be used in the autosuggestion.

## Proof of Concept

Tried some idea's in a basic html / php script.

## Planning

From a Product Owner view, I thougth it would be nice to create branches for each 'Sprint'.
That said, the following branches will be created;

1. Initial phase (Create project, PoC - files)
1. Developer framework (docker, plain Symfony, ~~graphQL package~~)
1. Create GraphQL client
1. Welcome page (show random character with info)
1. Overview (show grid and/or table)
1. Suggestion (search for and suggest)

## Development

Normally I would set up systems for (automatic) testing, but for now I decided to skip them. 
This is basicly because it is a time consuming task.


## During Development

First I've tried the Symfony way to use a docker `https://symfony.com/doc/current/setup/docker.html`, but somehow it failed.

Also a simple , found on Google, did not work.
`https://medium.com/@oumaymaneffati/the-easy-way-to-install-symfony-with-docker-b6fca3997d2c`

So I falled back on my knowledge of Alpine dockers, but ended up using `https://www.twilio.com/en-us/blog/get-started-docker-symfony` which also failed. The problem was that the Dockerfile tried to copy a file from the Symfony installer. This installer created an other directory, once I changed that, the container could be created.

Could not add the ./app directory to my repository. It seems there was a .git folder in the app
rm -r app/.git/

## Time registration
vr 4-6 uur research
za 2-3 uur writing readme and creating docker
za 1 uur trouble adding Symfony to repository
za 2 uur GraphQL Client
zo 1 uur GraphQL Client and test controller
zo 1 uur Welcome page with random image


## Helpfull commands
### Build Docker Container
docker compose build --no-cache
docker compose up --build

docker-compose exec php /bin/bash

docker run -rm -it my-stage-php /bin/bash

check http://localhost:8080/

symfony check:requirements
symfony new .