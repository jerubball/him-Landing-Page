#!/bin/sh

cd ..
git pull
cp -rf ./root/* /var/www/html/
