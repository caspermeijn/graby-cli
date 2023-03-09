FROM php:7.4-cli

# Install OS dependencies
RUN apt-get update && apt-get install -y \
        libtidy-dev \
        libzip-dev \
        zlib1g-dev

RUN docker-php-ext-install -j$(nproc) tidy zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy sources
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

# Install PHP dependencies
RUN composer install

# Run script
CMD [ "php", "graby-cli.php" ]