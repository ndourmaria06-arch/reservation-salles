FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y libzip-dev unzip git curl \
    && docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

COPY . /var/www/html

EXPOSE 8080
CMD php -S 0.0.0.0:${PORT:-8080} -t public