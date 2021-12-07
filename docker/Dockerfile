FROM php:8.0-cli

RUN apt-get update -y && apt-get install -y \
    git \
    unzip

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN install-php-extensions \
        zip \
        intl \
        opcache \
        curl \
        pdo_mysql


RUN useradd --create-home --shell /bin/bash application
USER application
WORKDIR /app

CMD bash -c "exec symfony server:start --port=3160"
