#!/bin/bash

cat auth.log | grep "sshd.*Failed" | awk '/sshd.*Failed/ {print $1, $2, $3, $11, $9}' /var/log/auth.log
