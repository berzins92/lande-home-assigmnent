# Base image with PHP 8.3 and FPM
FROM php:8.3-fpm

# Set environment variables
ENV DEBIAN_FRONTEND=noninteractive

# Update and install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    git \
    unzip \
    nano \
    libxrender1 \
    libxext6 \
    libvpx-dev \
    libonig-dev \
    default-mysql-client && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install gd pdo pdo_mysql zip bcmath && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-enable bcmath

#Xdebug
# Install Xdebug if not already installed
RUN if ! pecl list | grep -q "xdebug"; then \
        pecl install xdebug; \
    else \
        echo "Xdebug already installed"; \
    fi \
    && docker-php-ext-enable xdebug


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set permissions for Laravel storage and cache folders
RUN mkdir -p /var/www/laravel/storage /var/www/laravel/bootstrap/cache && \
    chmod -R 775 /var/www/laravel/storage /var/www/laravel/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html

# Switch to www-data user
USER www-data

# Set working directory
WORKDIR /var/www/html

# Expose port for PHP-FPM
EXPOSE 9000

# Default command to keep the container running
CMD ["php-fpm"]
