# Slots App Symfony Boilerplate

This repository is based on PHP 8 and Symfony 5

## Installation

The project is dockerized and configured to work with docker-compose

- to run the container, use `docker-compose up -d`
- run database migrations - `docker-compose run --rm recruitment-app bin/console doctrine:migrations:migrate`
- after a while, the app should be accessible on `http://localhost:3160`

## Diary

### First milestone - API contract

The first major milestone is designing the API. Given the existing repository (tech stack = Symfony + PHP) and the time
constraints (I would like to finish the recrutiment soon™) my recommendation would be JSON-based REST API. The next
logical step would be to agree on the schema, which is why I went with OpenAPI. Alternatives that I considered are GRPC,
Avro and GraphQL.

This milestone is related to two of the "most beneficial" points from the assignment:
cursor-based pagination might have a dramatic impact on API performance and using it from the beginning will prevent
costly refactorings down the road. I would talk with the team about this major decision which does come with its
drawbacks. It's also related to testing and API discoverability.


## General Notes

### API response structure

I could dedicate more time to research established standards for cursor-based pagination response structure. There's
json+hal, json-ld, etc. Some of them are available off-the-shelf in API-Platform "framework", but I don't have enough
experience with it to risk a PoC with it when I only have up to 12 hours for the whole project. I wanted to use cursor
pagination because of performance benefits, here are links from my Google history when I was working on the OpenAPI
specification:

* https://slack.engineering/evolving-api-pagination-at-slack/
* https://github.com/blongden/vnd.error

### The `date_to` filter

This is to some extent a business decision that would be consulted with the team. For the purpose of this task I am
assuming this filter is meant to be used ie. by a mobile app in this manner: "I'm looking for an appointment with a
dermatologist. All visits take 30 minutes. The user only sees visit start date & time, so when they select visits with
date_to=10AM, the one starting at 10 should be visible too. This avoids users having to input 10:01AM to see it"
