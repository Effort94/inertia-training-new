FROM php:8.2-apache AS web-base
EXPOSE 9002

ARG WITH_XDEBUG

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libmagickwand-dev awscli \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo pdo_mysql bcmath pcntl posix \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# PHP configurations
ENV UPLOAD_MAX_FILESIZE=50M
ENV POST_MAX_SIZE=50M
ENV MEMORY_LIMIT=2048M

RUN echo "upload_max_filesize = $UPLOAD_MAX_FILESIZE" >> /usr/local/etc/php/php.ini \
    && echo "post_max_size = $POST_MAX_SIZE" >> /usr/local/etc/php/php.ini \
    && echo "memory_limit = $MEMORY_LIMIT" >> /usr/local/etc/php/php.ini

# Xdebug installation and configuration
RUN if [ "$WITH_XDEBUG" = "true" ] ; then \
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.start_with_request=no" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi;

# Create reports directory and set permissions
RUN mkdir -p /var/www/html/reports && chmod -R 777 /var/www/html/reports

# Production stage
FROM web-base as web-prod
COPY ./ /var/www/html/

# Health check
HEALTHCHECK CMD curl --fail http://localhost/ || exit 1
