#!/bin/bash

username="$1"
dbname="$2"

du -sh /var/www/html/$username/$dbname
