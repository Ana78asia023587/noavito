FROM ubuntu:20.04

WORKDIR /var/www/html

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php -y && \
    apt-get update

RUN apt-get update && apt-get install -y \
    php8.1 \
    php8.1-ctype \
    php8.1-curl \
    php8.1-dom \
    php8.1-fpm \
    php8.1-gd \
    php8.1-intl \
    php8.1-mbstring \
    php8.1-pgsql \
    php8.1-mysql \
    php8.1-sqlite \
    php8.1-opcache \
    php8.1-phar \
    php8.1-xml \
    php8.1-xmlreader \
    php8.1-zip \
    mysql-client \
    supervisor \
    nginx \
    iputils-ping \
    unzip \
    wget \
    curl \
    redis-tools \
    vim \
    git

RUN wget https://getcomposer.org/download/latest-stable/composer.phar && \
    chmod +x ./composer.phar && \
    mv ./composer.phar /usr/bin/composer

RUN useradd -m web

COPY docker/config/nginx.conf /etc/nginx/nginx.conf
COPY docker/config/fpm-pool.conf /etc/php/8.1/fpm/pool.d/www.conf
COPY docker/config/php.ini /etc/php/8.1/fpm/conf.d/custom.ini
COPY docker/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chown -R web:web /var/www/html /run /var/lib/nginx /var/log/nginx
RUN chown -R web:web /entrypoint.sh && chmod u+x /entrypoint.sh

USER web

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
