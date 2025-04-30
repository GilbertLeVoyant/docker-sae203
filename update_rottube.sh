#!/bin/bash





# Arrêter le conteneur nommé "rottube" s'il est en cours d'exécution


docker stop rottube





# Supprimer le conteneur nommé "rottube" s'il existe


docker rm rottube





# Mettre à jour le code source depuis le dépôt Git


git pull





# Construire une nouvelle image Docker avec le tag "rottube"


docker build -t rottube .





# Lancer un nouveau conteneur avec le nom "rottube" et exposer le port 54688


docker run -d -p 54688:80 --name rottube rottube





echo "Le conteneur 'rottube' a été mis à jour et relancé avec succès."
