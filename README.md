# Projet-Cloud

## Processus d'installation du backend
```shell
docker compose up -d --build # compile et monte notre projet en instance docker
docker ps # liste les instances docker en cours d'exécution
docker exec -it projet-cloud-backend-1 /bin/bash

# root@408691c52231:/var/www/html# 
# Signifie que vous avez attaché votre terminal à celui de l'instant docker
composer i # installer les dépendences présente dans le fichier `composer .json` 
exit # déconnecter son terminal à l'instant docker
```
