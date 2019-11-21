#!/bin/sh

cd ..
git pull
rm -rf /var/www/html/* /var/www/html/.[^.]* /var/www/html/..?*
