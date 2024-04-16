FROM php:7.4-fpm

ARG UID
ARG GID
ARG XDEBUG_VERSION="xdebug-2.9.0"

# Set up working dir
WORKDIR /var/www

# Install system dependencies
RUN apt-get clean && apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    nano \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Composer set up
RUN rm -rf /usr/local/bin/composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --version=1.10.13 --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
ENV COMPOSER_VERSION=1.10.13
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

ENV XDEBUG_MODE=on
RUN yes | pecl install ${XDEBUG_VERSION} && \
    docker-php-ext-enable xdebug
COPY ../php.ini /usr/local/etc/php

RUN groupadd -g $GID group_tvv && \
    useradd --no-log-init -m -s /bin/bash -N -u $UID -g $GID tvv

USER root
