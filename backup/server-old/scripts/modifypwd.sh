#!/bin/bash

#Récupération des paramètres
username="$1"
newpwd="$2"

#Changement de mot de passe
sudo echo "$username:$newpwd" | sudo chpasswd










