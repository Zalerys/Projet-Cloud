#!bin/bash

ssh_key="$2"
username="$1"
echo $username

su username
sudo nano ~/.ssh/authorized_keys $ssh_key
exit

