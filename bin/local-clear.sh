#!/bin/sh

cd ..
git pull
rm -rf /usr/local/apache2/htdocs/* /usr/local/apache2/htdocs/.[^.]* /usr/local/apache2/htdocs/..?*
