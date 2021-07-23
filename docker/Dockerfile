FROM php:7.4.2-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    default-mysql-client \
    git \
    jpegoptim optipng pngquant gifsicle \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libmemcached-dev \
    libonig-dev \
    libpng-dev \
    librabbitmq-dev \
    libsodium-dev \
    libsqlite3-dev \
    libssh-dev \
    libzip-dev \
    locales \
    unzip \
    uuid-dev \
    vim \
    zip

RUN pecl install amqp \
 && pecl install memcached-3.1.5 \
 && pecl install mongodb \
 && pecl install redis-5.1.1 \
 && pecl install uuid \
 && pecl install xdebug-2.8.1

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install exif gd intl mbstring pcntl pdo_mysql pdo_sqlite zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-enable amqp memcached mongodb pdo_sqlite redis sodium uuid xdebug

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
