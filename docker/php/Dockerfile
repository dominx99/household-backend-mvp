FROM php:8.1.6-fpm-alpine
WORKDIR /application

COPY --from=composer:2.3.7 /usr/bin/composer /usr/bin/composer

RUN wget https://github.com/FriendsOfPHP/pickle/releases/download/v0.7.9/pickle.phar \
    && mv pickle.phar /usr/local/bin/pickle \
    && chmod +x /usr/local/bin/pickle

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ bash icu-dev libzip-dev rabbitmq-c rabbitmq-c-dev \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        intl \
        zip \
        pdo_mysql

RUN pickle install apcu@5.1.21

ADD etc/infrastructure/php/extensions/xdebug.sh /root/install-xdebug.sh
RUN apk add git
RUN sh /root/install-xdebug.sh

RUN docker-php-ext-enable \
        apcu

COPY etc/infrastructure/php/ /usr/local/etc/php/
