FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
      zlib1g-dev \
      g++ git libicu-dev zip \
      libzip-dev \
      zip \
      libcurl4-openssl-dev \
      pkg-config \
      libssl-dev \
    && docker-php-ext-install intl opcache pdo_mysql \
    && pecl install apcu xdebug \
    && docker-php-ext-enable apcu xdebug \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini

WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /app