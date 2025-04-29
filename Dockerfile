# Utiliser Debian comme image de base
FROM debian:latest

# Mettre à jour les paquets et installer Apache, Node.js, et Redis
RUN apt-get update && apt-get install -y apache2 && apt-get clean 

# Copier les fichiers HTML, CSS, vidéos et images dans le répertoire par défaut d'Apache
COPY html    /var/www/html
COPY videos  /var/www/html/videos
COPY images  /var/www/html/images
COPY package*.json ./
COPY musique /var/www/html/musique

# Installer les dépendances Node.js
RUN npm install

# Copier le backend Node.js
COPY backend /app

# Exposer les ports nécessaires
EXPOSE 80 

# Script de démarrage pour gérer Apache, Redis et Node.js

CMD ["apachectl", "-D", "FOREGROUND"]




