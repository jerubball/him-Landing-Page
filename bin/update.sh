#!/bin/sh

cd ..
git pull
cp -rfP ./root/. /var/www/html/

sudo chgrp -R www-data /var/www/html/
sudo chgrp -R www-data ./root/test/
sudo chgrp -R www-data ./root/.test/
