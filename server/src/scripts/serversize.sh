#!/bin/bash

server_name="$4"
username="$1"

du -sh /var/www/html/$username/$server_name
