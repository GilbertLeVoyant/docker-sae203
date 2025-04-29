#!/bin/bash

# Fonction pour afficher une animation de chargement en bas
loading_animation() {
  local pid=$1
  local delay=0.1
  local spinstr='|/-\'
  tput civis # Masquer le curseur
  while [ "$(ps a | awk '{print $1}' | grep $pid)" ]; do
    local temp=${spinstr#?}
    printf "\r\033[1;32m[Chargement] [%c]\033[0m" "$spinstr"
    spinstr=$temp${spinstr%"$temp"}
    sleep $delay
  done
  printf "\r\033[1;32m[Chargement terminé] [✔]\033[0m\n"
  tput cnorm # Réafficher le curseur
}

# Fonction pour exécuter une commande et afficher les logs au-dessus de la barre de chargement
run_with_loading() {
  local cmd="$1"
  echo -e "\033[1;34m[Exécution] $cmd\033[0m"
  bash -c "$cmd" &> >(tee -a logs.txt) &
  loading_animation $!
}

# Script principal
echo -e "\033[1;33mMise à jour de RotTube...\033[0m"

echo "Arrêt du conteneur 'rottube' s'il est en cours d'exécution..."
run_with_loading "docker stop rottube || true"

echo "Suppression du conteneur 'rottube' s'il existe..."
run_with_loading "docker rm rottube || true"

echo "Mise à jour du code source depuis le dépôt Git..."
run_with_loading "git pull"

echo "Construction de la nouvelle image Docker 'rottube'..."
run_with_loading "docker build -t rottube ."

echo "Lancement du nouveau conteneur 'rottube'..."
run_with_loading "docker run -d -p 54688:80 --name rottube rottube"

echo -e "\033[1;32mLe conteneur 'rottube' a été mis à jour et relancé avec succès.\033[0m"