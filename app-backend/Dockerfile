# Use PHP image
FROM php:8.1-fpm

# Set working directory in the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    nano \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath xml

# Copy your Laravel files into the container
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.json composer.json

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN set -ex ; \
    apt-get update ; \
    apt-get install -y git zip ; \
    composer -n validate --strict ; \
    composer -n install --no-scripts --ignore-platform-reqs --no-dev

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

CMD php artisan db:wipe --force

CMD php artisan config:clear
CMD php artisan route:clear
CMD php artisan event:clear
CMD php artisan view:clear

CMD php artisan migrate

CMD php artisan db:seed --class=UsersTableSeeder --force
CMD php artisan db:seed --class=CurrenciesTableSeeder --force

CMD php artisan serve --host=0.0.0.0
