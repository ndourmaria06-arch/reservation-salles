# Étape 1 : installer les dépendances Composer (sans les outils de dev)
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader --ignore-platform-reqs

# Étape 2 : l'image finale avec PHP + Apache
FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite \
    && { \
        echo '<Directory /var/www/html/public>'; \
        echo '    AllowOverride All'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/app.conf \
    && a2enconf app \
    && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

COPY . /var/www/html
COPY --from=vendor /app/vendor /var/www/html/vendor

WORKDIR /var/www/html
EXPOSE 80