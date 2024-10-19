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
1. Developer framework (docker, plain Symfony, graphQL package)
1. Welcome page (show random character with info)
1. Overview (show grid and/or table)
1. Suggestion (search for and suggest)

## Development

Normally I would set up systems for (automatic) testing, but for now I decided to skip them. 
This is basicly because it is a time consuming task.
