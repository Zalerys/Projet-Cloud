#!/bin/bash

cat /proc/meminfo | grep MemTotal | awk '{print "Total memory: " $2/1024 " MB"}'
