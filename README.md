# Wonde CLI

A CLI frontend for interacting with Wonde services.

## Prerequisites

The only requirement is a working Docker installation. Docker Desktop will work
fine for Mac and Windows.

## Setup

1. Install dependencies.
   ```
   docker run --rm --interactive --tty \
     --volume $PWD:/app \
     --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
     composer install
   ```
2. Build the container image.
   ```
   docker build . -t wonde-cli
   ```

## Commands

### Listing classes with students

```
docker run --rm \
  -e WONDE_API_KEY="my-api-key" \
  -e WONDE_SCHOOL_ID="my-school-id" \
  -e WONDE_EMPLOYEE_ID="my-employee-id" \
  wonde-cli classes
```

## Developer help

### Interacting with Composer

The official Composer Docker image can be used for interacting with Composer.

```
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --volume ${COMPOSER_HOME:-$HOME/.composer}:/tmp \
  composer install
```

### Development Environment

For a more persistent dev shell for running artisan builder commands etc.

```
docker run -it --rm \
  -v $(pwd):/app \
  php:8-cli bash
```

