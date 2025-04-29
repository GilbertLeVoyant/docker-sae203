# Utiliser Debian comme image de base
FROM debian:latest

# Mettre à jour les paquets et installer Apache (httpd)
RUN apt-get update && apt-get install -y apache2 && apt-get clean

# Copier les fichiers HTML, CSS, vidéos et images dans le répertoire par défaut d'Apache
COPY html /var/www/html
COPY videos /var/www/html/videos
COPY images /var/www/html/images
COPY java var/www/java

# Exposer le port 80
EXPOSE 80

# Commande pour démarrer Apache
CMD ["apachectl", "-D", "FOREGROUND"]