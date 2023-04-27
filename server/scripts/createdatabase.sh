#!/bin/bash

username='$1'
pwd='$2'
servername='$3'

#creation bdd

sql_command="CREATE DATEBASE $servername;"

resultat=$(sudo mysql -e "$sql_command")

#creation user

sql_command="CREATE USER '$username'@'localhost' IDENTIFIED
BY '$pwd’;"

resultat=$(sudo mysql -e "$sql_command")

#creation user

sql_command="GRANT ALL PRIVILEGES ON $servername.*
TO '$username'@'localhost';"

resultat=$(sudo mysql -e "$sql_command")