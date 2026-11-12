# FlexStage

> Historical / Academic Project — not recently verified

FlexStage is a 2022 Symfony application for managing geographic and user records,
including regions, provinces, cities, districts, roles, and privileges. The source
is preserved as an example of an earlier full-stack PHP project.

## Technology

- PHP 8.1 or newer
- Symfony 6.1 and Twig
- Doctrine ORM and migrations
- Bootstrap-based frontend assets

## Local setup

The original project expects a local database and environment configuration.
Review `.env`, create a local override rather than committing credentials, then
install dependencies with `composer install` and run the Doctrine migrations.

This setup has not been revalidated against current dependency or database
versions. The tracked `.env` contains template/local values only; do not replace
them with real credentials in version control.

## Status and licensing

This repository is maintained for historical reference, not presented as a
current production service. `composer.json` declares the project proprietary;
no separate open-source license is granted.
