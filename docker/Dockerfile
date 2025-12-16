FROM php:8.3-fpm

# ARGs
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# System packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    supervisor \
    cron \
    vim \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    linux-headers-amd64 \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    mbstring \
    zip \
    xml

# Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Redis
RUN pecl install redis \
    && docker-php-ext-enable redis


# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# UID / GID
RUN groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Workdir
WORKDIR /var/www/html

# Supervisor config (for worker)
COPY docker/supervisor.conf /etc/supervisor/supervisord.conf

# Xdebug config
COPY docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Permissions
RUN chown -R www-data:www-data /var/www/html

USER www-data

ENTRYPOINT ["/entrypoint.sh"]
