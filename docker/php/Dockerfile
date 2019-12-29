FROM php:7.3-fpm

RUN apt-get update

RUN apt-get install -y nano curl zip unzip git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y librdkafka-dev

RUN pecl install rdkafka

RUN rm -rf /tmp/pear

RUN echo "extension=rdkafka.so" > /usr/local/etc/php/conf.d/rdkafka.ini

RUN mkdir /app

WORKDIR /app

CMD [ "php-fpm" ]