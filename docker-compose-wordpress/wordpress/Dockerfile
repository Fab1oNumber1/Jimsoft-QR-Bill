FROM wordpress:5.8-php7.4-apache
# Or perhaps different default versions: "wordpress:${WP_VERSION:-5.5.1}-php${PHP_VERSION:-7.4}-apache"

RUN apt-get update -y \
  && apt-get install -y \
      libxml2-dev \
      vim \
  && apt-get clean -y \
  && docker-php-ext-install soap  \
  && docker-php-ext-enable soap \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl \
  && docker-php-ext-enable intl \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug

COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d
