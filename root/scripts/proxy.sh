#!/bin/bash

proxy_env="
HTTP_PROXY=http://proxy3.nyit.edu:80/
http_proxy=http://proxy3.nyit.edu:80/
HTTPS_PROXY=http://proxy4.nyit.edu:80/
https_proxy=http://proxy4.nyit.edu:80/
FTP_PROXY=http://proxy5.nyit.edu:80/
ftp_proxy=http://proxy5.nyit.edu:80/
SOCKS_PROXY=http://proxy5.nyit.edu:80/
socks_proxy=http://proxy5.nyit.edu:80/
NO_PROXY=\"localhost,127.0.0.1,nyit.edu\"
no_proxy=\"localhost,127.0.0.1,nyit.edu\"
"
proxy_apt="
Acquire::http::proxy \"http://proxy3.nyit.edu:80/\";
Acquire::https::proxy \"http://proxy4.nyit.edu:80/\";
Acquire::ftp::proxy \"http://proxy5.nyit.edu:80/\";
"

if [[ $(id -u) -ne 0 ]]
then
    sudo ./$0
else
    echo "$proxy_env" >> /etc/environment
    echo "$proxy_apt" >> /etc/apt/apt.conf.d/95proxies
fi

