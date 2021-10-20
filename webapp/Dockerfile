# =====================================
# SERVER MONITORING SYSTEM - WEBAPP
# =====================================

FROM php:7.4-apache-buster


# Moving the site
# =====================================

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/

# Add extra apt commands and cleanup
# =====================================
RUN apt-get update && apt-get install -y \
    iputils-ping \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install sockets

# UNUSED // Adding extra packages for php
# =====================================
# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
# RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
#   install-php-extensions mysqli
