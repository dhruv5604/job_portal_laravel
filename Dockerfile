# Use an official PHP image with FPM
FROM php:8.2-fpm

# Arguments (optional)
ARG user=www
ARG uid=1000

# Install system deps
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    gnupg2 \
    ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath intl xml

# Install gd with jpeg support (optional)
RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libwebp-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd \
    && rm -rf /var/lib/apt/lists/*

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create system user to run the app
RUN groupadd -g ${uid} ${user} || true \
    && useradd -u ${uid} -ms /bin/bash -g ${user} ${user}

WORKDIR /var/www/html

# Copy only composer files first for better caching
COPY composer.json composer.lock ./

# Copy rest of the app
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader

# Ensure storage and bootstrap/cache are writable
RUN chown -R ${user}:${user} /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose sockets/port if needed
EXPOSE 9000

# Switch to non-root user
USER ${user}

# Default cmd (php-fpm)
CMD ["php-fpm"]
