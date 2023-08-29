FROM php:8.0-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/mayflower

COPY ./composer.json composer.json
COPY ./composer.lock composer.lock
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

COPY . .
RUN composer dump-autoload

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "vndemin.dev@gmail.com"
RUN git config --global user.name  "vndemin"
RUN git config --global --add safe.directory /var/www/mayflower

RUN mkdir var/cache && mkdir var/log && chown -R www-data:www-data ./var/cache && chown -R www-data:www-data ./var/log
