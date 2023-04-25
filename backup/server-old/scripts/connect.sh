#!/bin/bash

username="$1"
pwd="$2"

sshpass -p "$pwd" ssh -t "$username@40.66.44.15"