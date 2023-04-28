#!/bin/bash

df -h --output=size,used,avail -t ext4 | head -n 2 | tail -n 1

