#!/bin/bash

#Récupération des paramètres
username="$1"
pwd="$2"

sudo useradd -m -p $pwd $username

sudo chown -R $username:$username /home/$username

sudo mkdir /var/www/html/$username
