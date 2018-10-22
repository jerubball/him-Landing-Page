#!/bin/bash

list="anacron apache2 apt boinc cron default-jdk default-mysql-client default-mysql-server dialog docker dpkg easy-rsa emacs exfat-fuse exfat-utils fdisk fuseiso gcc gimp git htop hwinfo mysql-client mysql-server mysql-workbench nano net-tools nodejs openjdk-11-jdk openjdk-8-jdk openssh-client openssh-server openssl openvpn php php-all-dev python python-pip python3 rsync screen ssh sudo telnet texlive texworks vim virtualbox virtualbox-qt vsftpd wget wine-stable wine32 wine64 winetricks yum"

if [[ $(id -u) -ne 0 ]]
then
    sudo ./install.sh
else
    apt update
    apt upgrade --fix-missing -y
    
    apt install -y $list
    
    apt update
    apt autoremove -y
    apt upgrade -y
fi

