#!/bin/bash

#Récupération des paramètres

servername="$1"
username="$2"

#Creation Repertoire du Serveur
sudo  mkdir /home/$username/$servername

#Création du fichier config


nginx_config="/etc/nginx/sites-enabled/$servername"

sudo touch $nginx_config

echo $servername
echo $nginx_config

sudo cat > "$nginx_config" << EOF
server {
        listen 80;
        listen [::]:80;

        server_name www.$servername.fr;

        root /home/$username/$servername;
        index index.html index.php;

        location / {
                try_files $uri $uri/ =404;
        }
        error_page 404 /404.htm;
        error_page 403 /403.htm;
        error_page 500 /500.htm;
        access_log /var/log/nginx/$servername.log;
        error_log /var/log/nginx/$servername-error.log;
                location ~* ^.+\.(xml|ogg|ogv|svg|svgz|eot|otf|woff)$ {
                return 404;
        }
}
EOF

sudo systemctl reload nginx
#ecrire dans le nouveau fichier
#echo "$template" | sudo nano /etc/nginx/sites-enabled/$server_name

