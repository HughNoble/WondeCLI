FROM php:8-cli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
ENTRYPOINT [ "php", "artisan" ]
