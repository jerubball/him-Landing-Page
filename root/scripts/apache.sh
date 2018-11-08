#!/bin/bash


if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0 $@
else
    chmod -R 775 /etc/apache2
    chgrp -R adm /etc/apache2

    chmod -R 775 /var/www
    chgrp -R adm /var/www

    chmod -R 775 /usr/lib/apache2
    chgrp -R adm /usr/lib/apache2

    chmod -R 775 /var/lib/apache2
    chgrp -R adm /var/lib/apache2

    chmod -R 775 /usr/share/apache2
    chgrp -R adm /usr/share/apache2
fi
