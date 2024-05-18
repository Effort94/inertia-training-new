FROM php:8.1-apache AS web-base
EXPOSE 9002

ARG ECS_AWS_ACCESS_KEY
ARG ECS_AWS_SECRET_ACCESS_KEY
ARG WITH_XDEBUG

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get install -y \
    libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pcntl posix

# install and configure aws cli
RUN apt-get install -y awscli

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pcntl posix

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN echo "upload_max_filesize = 50M" >> /usr/local/etc/php/php.ini;
RUN echo "post_max_size = 50M" >> /usr/local/etc/php/php.ini;
RUN echo "memory_limit = 2048M" >> /usr/local/etc/php/php.ini;


RUN if [ $WITH_XDEBUG = "true" ] ; then \
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#        echo "xdebug.client_host=accounting.cygnusmusic.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi ;


# Install code coverage driver
RUN pecl install pcov && docker-php-ext-enable pcov

FROM web-base as web-prod
COPY ./ /var/www/html/
