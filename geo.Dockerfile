FROM php:7.4.3-apache
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install pdo_pgsql zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd
# Set working directory
WORKDIR /var/www
# Add user for laravel application
RUN groupadd -g 1000 geoffreylgv
RUN useradd -u 1000 -ms /bin/bash -g geoffreylgv geoffreylgv

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=geoffreylgv:geoffreylgv . /var/www

# Change current user to www
USER geoffreylgv