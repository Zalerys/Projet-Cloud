#!/bin/bash

cat auth.log | grep "sshd.*Accepted" | awk '/sshd.*Accepted/ {print $1, $2, $3, $11, $9}' /var/log/auth.log
