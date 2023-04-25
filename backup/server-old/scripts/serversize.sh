#!/bin/bash
set -e

username="$1"
server_name="$2"

datasize="du -sh /var/www/html/$username/$server_name"

echo "$datasize"


