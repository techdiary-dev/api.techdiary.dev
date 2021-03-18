FROM php:8.0.2-fpm-alpine

WORKDIR /var/www/api

ADD ./www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./php.ini /usr/local/etc/php/php.ini

RUN addgroup -g 1000 techdiary && adduser -G techdiary -g techdiary -s /bin/sh -D techdiary

# PHP extension
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -ex \
    && apk --no-cache add \
    postgresql-dev

RUN install-php-extensions pdo_pgsql bcmath @composer redis


RUN chown techdiary:techdiary /var/www/api

COPY . .

CMD [ "-c", "composer install" ]