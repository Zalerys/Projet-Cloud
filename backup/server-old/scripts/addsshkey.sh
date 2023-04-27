#!bin/bash

ssh_key="$2"
username="$1"
echo $username

su username
echo "$ssh_key" >> /home/$username/.ssh/authorized_keys
exit

