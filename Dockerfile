FROM composer:2.0 AS build
WORKDIR /app
COPY . /app
RUN composer install

FROM php:8.1-fpm
EXPOSE 80
COPY --from=build /app /app
COPY nginx.conf /etc/nginx/nginx.conf
RUN apt-get update && apt-get install -y libjpeg-dev libpng-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && chown -R www-data:www-data /app

CMD ["php-fpm"]