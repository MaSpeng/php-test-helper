# syntax=docker/dockerfile:1

FROM php:8.1.26-cli-alpine3.19 as dev

WORKDIR /workspace

COPY --from=composer/composer:2.6.6 --link /usr/bin/composer /usr/local/bin/

# hadolint ignore=SC2086
RUN set -eux; \
    apk add --no-cache --upgrade --virtual .build-deps \
        ${PHPIZE_DEPS} \
        libzip-dev \
        linux-headers \
        zlib-dev; \
    pecl install \
        pcov \
        xdebug; \
    docker-php-ext-install "-j$(nproc)" \
        zip; \
    docker-php-ext-enable \
        pcov \
        xdebug \
        zip; \
    runDeps="$( \
        scanelf --needed --nobanner --recursive /usr/local \
            | awk '{ gsub(/,/, "\nso:", $2); print "so:" $2 }' \
            | sort -u \
            | xargs -r apk info --installed \
            | sort -u \
        )"; \
    apk add --no-cache --upgrade \
        ${runDeps} \
        7zip \
        bash \
        git \
        openssh \
        unzip \
        zip; \
    apk del .build-deps; \
    rm -R /tmp/pear
