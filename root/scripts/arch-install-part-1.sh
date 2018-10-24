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

fdisk --wipe auto /dev/sda <<EOF
o
n
p



a
w
EOF
mkfs.ext4 /dev/sda1

mkdir /mnt
mount /dev/sda1 /mnt

pacstrap /mnt base base-devel

genfstab -U /mnt >> /mnt/etc/fstab

cp arch-install-part-1.sh /mnt/root/arch-install-part-1.sh
cp arch-install-part-2.sh /mnt/root/arch-install-part-2.sh
cp arch-install-part-3.sh /mnt/root/arch-install-part-3.sh

arch-chroot /mnt 

echo "Returning"
read

umount /mnt
reboot
