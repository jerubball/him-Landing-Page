#!/bin/bash



cd /var/www/
rm -rf html/*
wget -np -nH -r him-nyit.ddns.net/cluster/
mv -f cluster/* html/
rm -rf cluster
