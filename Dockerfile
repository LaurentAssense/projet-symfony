# --- CHANGEMENT ICI : On aligne sur votre version Windows (8.3) ---
FROM php:8.3-cli

# installation de composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Mise à jour des dépôts
RUN apt update -y

# Installation des dépendances (zip, git, et outils de compilation pour pecl)
RUN apt install -y zip git libicu-dev autoconf build-essential

# Installation des extensions PHP natives
RUN docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-install -j$(nproc) pcntl \
    && docker-php-ext-install -j$(nproc) pdo_mysql

# Installation via PECL
# (Fonctionnera car PHP 8.3 est supporté par Xdebug, contrairement à la 8.5)
RUN pecl install redis \
    && pecl install xdebug \
    && docker-php-ext-enable redis xdebug

# Configuration utilisateur et Symfony CLI
RUN groupadd -g 1000 symfony
RUN useradd -u 1000 --system -m -g 1000 symfony
RUN php -r "copy('https://get.symfony.com/cli/installer', '/tmp/installer.sh');";
RUN bash /tmp/installer.sh
RUN cp /root/.symfony5/bin/symfony /usr/local/bin/symfony

USER symfony
RUN git config --global user.email "laurentassense.pro@gmail.com"
RUN git config --global user.name "LaurentAssense"

ENV COMPOSER_HOME=/tmp
ENV APP_ENV=dev
WORKDIR /opt/projet