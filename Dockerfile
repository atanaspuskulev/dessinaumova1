#-------------------------- Initial Stage ----------------------
FROM php:8.4-fpm AS source

ENV DEBIAN_INTERACTIVE=noninteractive
ENV TZ=UTC

RUN apt-get -y update \
    && apt-get -y install libicu-dev \
        libzip-dev \
        libpng-dev \
        git \
        unzip \
        imagemagick \
    && docker-php-ext-install \
        pdo_mysql \
        intl \
        gd \
        zip \
        bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/html

COPY . .

#-------------------------------

FROM source AS runtime

ARG APP_UID=1000
ARG APP_GID=1000

RUN groupadd --gid ${APP_GID} app \
    && useradd --uid ${APP_UID} --gid ${APP_GID} \
    --create-home --shell /bin/bash app

WORKDIR /var/www/html

RUN chown -R app:app /var/www/html

COPY .dockerfiles/php-fpm.conf \
    /usr/local/etc/php-fpm.d/zz-app.conf

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

USER app

RUN /usr/local/bin/composer install --no-interaction --prefer-dist

EXPOSE 9000

#-----------------------------------
FROM nginx:stable-alpine-slim AS nginx

WORKDIR /var/www/html

COPY --from=source \
    /var/www/html/public \
    /var/www/html/public

COPY .dockerfiles/nginx.conf \
    /etc/nginx/conf.d/default.conf

EXPOSE 80


