# Utiliser Debian comme image de base
FROM debian:latest

# Mettre à jour les paquets et installer Apache
RUN apt-get update && apt-get install -y \
	apache2 \
	&& apt-get clean 



# Copier tout le contenu du dossier src dans le répertoire par défaut d'Apache
COPY src/ /var/www/html/


# Exposer le port 80 pour Apache
EXPOSE 80

# Script de démarrage pour Apache
CMD ["apachectl", "-D", "FOREGROUND"]