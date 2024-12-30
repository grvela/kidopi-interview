FROM php:8.3-apache

ARG APP_ENV
ENV ENVIRONMENT=${APP_ENV}

RUN a2enmod rewrite

COPY ./default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get update && apt-get install -y \
    curl \   
    git \
    unzip \        
    zip \
    libyaml-dev \
    && pecl install \
        yaml \
    && docker-php-ext-install \
        pdo_mysql \
    && docker-php-ext-enable \
        yaml \
    && apt-get clean && rm -rf /var/lib/apt/lists/* 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN if [ "$ENVIRONMENT" = "local" ]; then \
    echo "Installing and setting up Xdebug..."; \
    pecl install \
        xdebug \
    && docker-php-ext-enable \
        xdebug \
    && cat xdebug.conf >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;\
    fi