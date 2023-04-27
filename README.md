# Installation du projet

## Commandes Docker

```bash
docker compose up -d --build # compile et monte notre projet en instance docker
docker compose down # demonte l'instance docker
```

## Installation du back-end

```bash
docker ps # liste les instances docker en cours d'exécution
docker exec -it projet-cloud-backend-1 /bin/bash

# root@408691c52231:/var/www/html#
# Signifie que vous avez attaché votre terminal à celui de l'instant docker
cd html
composer i # installer les dépendences présente dans le fichier `composer.json`
exit # déconnecter son terminal à l'instant docker
```

## Installation du front-end

```bash
docker ps # liste les instances docker en cours d'exécution
docker exec -it projet-cloud-frontend-1 /bin/bash

# root@408691c52231:/var/www/html#
# Signifie que vous avez attaché votre terminal à celui de l'instant docker
npm i # installer les dépendences présente dans le fichier `packages.json`
exit # déconnecter son terminal à l'instant docker
```
