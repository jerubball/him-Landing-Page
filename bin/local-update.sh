#!/bin/sh

cd ..
git pull
cp -rfP ./root/. /usr/local/apache2/htdocs/
