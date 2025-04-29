# Utiliser Debian comme image de base
FROM debian:latest

# Installer Apache et PHP
RUN apt-get update && apt-get install -y apache2 && apt-get clean

# Copier les fichiers dans le répertoire par défaut d'Apache
COPY src/ /var/www/html/src
COPY html/ /var/www/html/
COPY styles /var/www/html/styles



# Exposer le port 80
EXPOSE 80

# Script de démarrage pour Apache
CMD ["apachectl", "-D", "FOREGROUND"]