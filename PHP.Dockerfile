FROM php:8.2-fpm
# RUN docker-php-ext-install  pdo pdo_mysql mbstring zip exif pcntl
# Install system dependencies
# Arguments defined in docker-compose.yml

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    lsb-release \
    ffmpeg \
    wget \
    librdkafka-dev \
    libzip-dev \
    vim
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# For Laravel


USER $user
RUN pecl install rdkafka
RUN echo "extension=rdkafka.so" >> /usr/local/etc/php/conf.d/rdkafka.ini

# RUN apt-get update && apt-get install -y lsb-release && apt-get install -y wget && apt-get install ffmpeg && apt-get install -y gnupg2 && apt-get clean all

# RUN echo "deb https://packages.gitlab.com/runner/gitlab-ci-multi-runner/ubuntu/ `lsb_release -cs` main" > /etc/apt/sources.list.d/runner_gitlab-ci-multi-runner.list && \
#     wget -q -O - https://packages.gitlab.com/gpg.key | apt-key add - && \
#     apt-get update -y && \
#     apt-get install -y gitlab-ci-multi-runner && \
#     wget -q https://github.com/docker/machine/releases/download/v0.7.0/docker-machine-Linux-x86_64 -O /usr/bin/docker-machine && \
#     chmod +x /usr/bin/docker-machine && \
#     apt-get clean && \
#     mkdir -p /etc/gitlab-runner/certs && \
#     chmod -R 700 /etc/gitlab-runner && \
#     rm -rf /var/lib/apt/lists/*