#!/bin/bash

cat /proc/stat | grep '^cpu[0-9]' | awk '{print "CPU " NR ": " ($2+$3+$4)/($2+$3+$4+$5+$6+$7)*100 "%"}'
