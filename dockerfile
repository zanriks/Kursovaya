FROM php:8.4-fpm-alpine

# Установка системных зависимостей и PHP-расширений (например, для MySQL)
RUN apk add --no-cache bash mysql-client
RUN docker-php-ext-install pdo pdo_mysql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
# RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]
