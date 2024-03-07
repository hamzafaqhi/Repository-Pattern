FROM php:8.1.0-fpm

# Install necessary packages
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        zip \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring exif pcntl bcmath gd zip \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application code
COPY . /var/www/html

# Change ownership of the application directory
RUN chown -R www-data:www-data /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Expose the port
EXPOSE 9000

# Start the PHP development server
CMD ["php" "artisan" "serve --port=9000"]