# Use the official PHP image as the base image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    cron

# Set the working directory
WORKDIR /app

# Copy existing application directory contents
COPY . /app

# Copy .env.example to .env if .env does not exist
RUN cp /app/.env.example /app/.env

# Install PHP extensions and Composer in a single step
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd sockets && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install application dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Copy the crontab file
COPY crontab /etc/cron.d/laravel-cron

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/laravel-cron

# Apply cron job
RUN crontab /etc/cron.d/laravel-cron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000

# Run the command on container startup
CMD ["sh", "-c", "cron && php-fpm"]
