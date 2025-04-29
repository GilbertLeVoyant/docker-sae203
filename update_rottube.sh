#!/bin/bash

# Fonction pour afficher une animation de chargement
loading_animation() {
  local pid=$1
  local delay=0.1
  local spinstr='|/-\'
  echo -n " "
  while [ "$(ps a | awk '{print $1}' | grep $pid)" ]; do
    local temp=${spinstr#?}
    printf " [%c]  " "$spinstr"
    spinstr=$temp${spinstr%"$temp"}
    sleep $delay
    printf "\b\b\b\b\b\b"
  done
  echo "    "
}

echo "Arrêt du conteneur 'rottube' s'il est en cours d'exécution..."
docker stop rottube &> /dev/null &
loading_animation $!

echo "Suppression du conteneur 'rottube' s'il existe..."
docker rm rottube &> /dev/null &
loading_animation $!

echo "Mise à jour du code source depuis le dépôt Git..."
git pull &> /dev/null &
loading_animation $!

echo "Construction de la nouvelle image Docker 'rottube'..."
docker build -t rottube . &> /dev/null &
loading_animation $!

echo "Lancement du nouveau conteneur 'rottube'..."
docker run -d -p 54688:80 --name rottube rottube &> /dev/null &
loading_animation $!

echo "Le conteneur 'rottube' a été mis à jour et relancé avec succès."