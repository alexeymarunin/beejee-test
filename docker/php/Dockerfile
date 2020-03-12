FROM php:fpm-alpine
RUN apk --update --no-cache add sqlite-dev \
  && docker-php-ext-install pdo_sqlite
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD composer install ; php-fpm
EXPOSE 9000
