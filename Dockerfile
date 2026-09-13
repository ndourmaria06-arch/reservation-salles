FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y libzip-dev unzip git curl \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && { \
        echo '<Directory /var/www/html/public>'; \
        echo '    AllowOverride All'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/app.conf \
    && a2enconf app \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80