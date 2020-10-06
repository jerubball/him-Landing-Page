#!/bin/bash


if [[ $(id -u) -ne 0 ]]
then
	sudo ./$0
	exit
else
	cd /
	fallocate -l 2G /swapfile
	chmod 600 /swapfile
	mkswap /swapfile
	swapon /swapfile
	echo "/swapfile swap swap defaults 0 0" >> /etc/fstab
	exit
fi
