# Utiliser Debian comme image de base
FROM debian:latest

# Mettre à jour les paquets et installer Nginx
RUN apt-get update && apt-get install -y nginx && apt-get clean

# Copier les fichiers HTML et CSS dans le répertoire par défaut de Nginx
COPY html /var/www/html
COPY videos /var/www/html/videos
COPY images /var/www/html/images

# Exposer le port 80
EXPOSE 80

# Commande pour démarrer Nginx
CMD ["nginx", "-g", "daemon off;"]