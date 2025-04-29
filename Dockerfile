# Utiliser Debian comme image de base
FROM debian:latest

# Mettre à jour les paquets et installer Apache, Node.js, et Redis
RUN apt-get update && apt-get install -y \
	apache2 \
	curl \
	gnupg \
	build-essential \
	redis-server \
	&& curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
	&& apt-get install -y nodejs \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

# Activer les modules nécessaires pour Apache
RUN a2enmod rewrite

# Définir le répertoire de travail pour Node.js
WORKDIR /app

# Copier uniquement les fichiers nécessaires pour installer les dépendances Node.js
COPY backend/package*.json ./

# Installer les dépendances Node.js
RUN npm install

# Copier le reste des fichiers du backend
COPY backend /app

# Copier les fichiers HTML, CSS, vidéos et images dans le répertoire par défaut d'Apache
COPY html /var/www/html
COPY videos /var/www/html/videos
COPY images /var/www/html/images

# Exposer les ports nécessaires
EXPOSE 80 3000 6379

# Script de démarrage pour gérer Apache, Redis et Node.js
CMD ["sh", "-c", "service apache2 start && service redis-server start && sleep 5 && node server.js"]