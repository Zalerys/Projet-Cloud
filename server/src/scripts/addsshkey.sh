#!bin/bash

ssh_key="$3"
username="$1"
echo $username

su username
sudo nano ~/.ssh/authorized_keys $ssh_ssh_key
exit

