# Utiliser l'image PHP avec Apache
FROM php:apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier les fichiers de votre application dans le conteneur
COPY . /var/www/html

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html
