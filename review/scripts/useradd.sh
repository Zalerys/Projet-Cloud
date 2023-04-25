#!/bin/bash

# Vérification du nombre de paramètres
if [ $# -ne 2 ]; then
  echo "Erreur, il faut 2 paramètres : le nom d'utilisateur et le nom de domaine."
  exit 1
  fi

# Vérification de l'existence de l'utilisateur
if cat /etc/passwd | cut -d\; -f1 | grep $1 > /dev/null; then
  echo "L'utilisateur $1 existe déjà."
  exit 1
  fi

# Création utilisateur
useradd -m $1
# Génération du mot de passe
echo "$1:$1" | sudo chpasswd
# Génération du fichier de configuration nginx
sed -e "s/MYUSERNAME/$1" -e "s/MYDOMAIN/$2" /etc/nginx/templateSite > /etc/nginx/sites-enabled/$2

# Partie MySQL
# Création de la base de données
mysql -e "CREATE DATABASE $2;"
# Création de l'utilisateur
mysql -e "CREATE USER '$1'@'localhost' IDENTIFIED BY '$1';"
# Droits sur la base de données
mysql -e "GRANT ALL PRIVILEGES ON $2.* TO '$1'@'localhost';"
# Rechargement de la configuration
#service nginx restart
