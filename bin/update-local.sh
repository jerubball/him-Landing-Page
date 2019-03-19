#!/bin/sh

cd ..
git pull
cp -rf ./root/* /usr/local/apache2/htdocs/
