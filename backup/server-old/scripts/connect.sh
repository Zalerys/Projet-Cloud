#!/bin/bash

username="$1"
pwd="$2"

sshpass -p "$pwd" ssh -t "$username@74.234.19.87"
