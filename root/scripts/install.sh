#!/bin/sh

list="apache2 default-jdk default-mysql-client default-mysql-server docker emacs exfat-fuse exfat-utils fdisk fuseiso gcc gimp git htop hwinfo mysql-client mysql-server mysql-workbench nano net-tools nodejs openjdk-11-jdk openjdk-8-jdk openssh-client openssh-server openssl openvpn php php-all-dev python python3 rsync screen ssh telnet texlive texworks vim vsftpd wine-stable"

sudo -s

apt update
apt upgrade

apt install -y $list

apt update
apt upgrade
