#!/bin/sh

cd ..
git pull
cp -rfP ./root/* /var/www/html/
