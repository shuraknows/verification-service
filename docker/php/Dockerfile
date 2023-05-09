FROM php:8.2-fpm-alpine

RUN  apk update && apk add --no-cache  \
     bash libssh-dev curl wget git  \
     mysql-client mariadb-connector-c

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && install-php-extensions amqp pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Add php ini
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

RUN chown -R www-data:www-data /var/www

# Install dependencies
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --prefer-dist --no-scripts --no-dev --no-interaction && rm -rf ./.composer/cache /home/www-data/.composer/cache
RUN rm -rf vendor/**/.git

USER www-data

# Copy codebase
COPY --chown=www-data:www-data . /var/www/

ENTRYPOINT ["docker/php/entrypoint.sh"]
CMD ["php-fpm"]
