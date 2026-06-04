FROM mcr.microsoft.com/devcontainers/php:3-8.4-bookworm

# Dépendances nécessaires pour les extensions PHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install intl zip