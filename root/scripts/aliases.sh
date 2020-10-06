#!/bin/bash

cd ~
wget https://hasol.co/scripts/aliases.txt
cat aliases.txt > .bash_aliases
rm aliases.txt
sudo rm /root/.bash_aliases
sudo -E ln -s ~/.bash_aliases /root/.bash_aliases

