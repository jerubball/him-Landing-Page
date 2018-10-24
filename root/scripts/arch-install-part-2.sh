#!/bin/sh
#/run/archiso/bootmnt/

export HTTP_PROXY=http://proxy3.nyit.edu:80/
export http_proxy=http://proxy3.nyit.edu:80/
export HTTPS_PROXY=http://proxy4.nyit.edu:80/
export https_proxy=http://proxy4.nyit.edu:80/
export FTP_PROXY=http://proxy5.nyit.edu:80/
export ftp_proxy=http://proxy5.nyit.edu:80/
export NO_PROXY=\"localhost,127.0.0.1,nyit.edu\"
export no_proxy=\"localhost,127.0.0.1,nyit.edu\"


locale-gen
echo "en_US.UTF-8 UTF-8" >> /etc/locale.gen
echo LANG=en_US.UTF-8 >> /etc/locale.conf
export LANG=en_US.UTF-8

ln -sf /usr/share/zoneinfo/America/New_York /etc/localtime
hwclock --systohc --utc

echo "EGGC-603-22" >> /etc/hostname
echo "127.0.0.1        localhost" >> /etc/hosts
echo "::1              localhost" >> /etc/hosts


systemctl enable dhcpcd@eth0.service 

passwd <<EOF
ieee
ieee
EOF

pacman -S grub-bios
grub-install --target=i386-pc --recheck /dev/sda
cp /usr/share/locale/en\@quot/LC_MESSAGES/grub.mo /boot/grub/locale/en.mo
grub-mkconfig -o /boot/grub/grub.cfg

pacman -S sudo
pacman -S apt

exit
