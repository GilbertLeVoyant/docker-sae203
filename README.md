
# SAE 2.03 Equipe 1
## Présentation 
Lors de cette SAE, nous avons appris les bases fondamentales de **Docker** qui nous permet d'héberger notre application. Nous avons choisis de créer un site web s'inspirant de Youtube qui permet de visionner des vidéos qui se nomme **RotHub** (qu'on appellera rottube dans les commandes)  

## Répartition des tâches dans le groupe
Liam **GIRARD--FOURNEAUX** : Gestion du README.md  + HTML / CSS
Axel  **LETELLIER** :  HTML / CSS + Gestion du README.md 
Alex **HAZET** : HTML / CSS + Dockerfile + Test de nouvelles fonctionnalités 
Emilien **FOYER** : Dockerfile + HTML / CSS + gestion du repository 

## Dockerfile


Exemple de dockerfile + github pour lancer un serveur web basé sur l'image httpd


### Instructions pour lancer l'application

Pour vérifier si docker est installé il faut faire la commande :

   `docker --version`


**Cloner le référentiel**

Pour cloner le référentiel on fait la commande :

`git clone git@github.com:GilbertLeVoyant/docker-sae203.git`


**Aller au référentiel** 

Pour se rendre dans le dossier *docker-sae203.git* on fait :

`cd docker-sae203.git`


**Construire l'image**

Pour construire l'image décrite dans dockerfile on fait la commande :

`docker build -t rottube .`


**Lancement du serveur web**

Pour lancer le serveur web il faut faire :

`docker run -d -p 54688:80 --name rottube rottube`

Pour vérifier que l'application est en cours d'execution, il faut ouvrir un navigateur et écrire :

`di-docker:54688`

** Vérification de l'activité du conteneur associer**

Pour vérifier son activité on fait la commande : 

`docker ps`

Cela devrait nous affichés une réponse ressemblant à cela :

*CONTAINER ID   IMAGE          COMMAND              CREATED          STATUS          PORTS                                   NAMES*

Avec en dessous des informations sur les autres conteneurs actifs.


**Arrêter le conteneur**

Pour arrêter le conteneur il faut faire : 

`docker stop rottube`


** Supprimer le conteneur**

Pour supprimer le conteneur il faut faire :

`docker rm rottube`


 Si nous devons redémarrer le conteneur, il faut suivre cette enchainement de commandes pour éviter tout erreur : 
1. `docker stop rottube`
2. `docker rm rottube`
3. `git pull` (pour récupérer qui a été mis à jour)
4. `docker build -t rottube .`
5. `docker run -d -p 54688:80 --name rottube rottube`
Nous avons créer un petit script qui permet d'éviter de répéter tous le temps ces 5 commandes. 
