#!/bin/bash

userid=$(id -u)
if [ $? -ne 0 ]
then
    echo "Unable to identify user"
    exit 1
fi

if [ $userid -eq 0 ]
then
    echo "Cannot update password of root"
    exit 1
fi

sudo -k
echo "Authenticating user with sudo..."
sudo echo "Success"

if [ $? -ne 0 ]
then
    echo "Authentication failed"
    exit 1
fi
    
echo "Reading for new password..."
passhash=$(openssl passwd -6)
echo "New Password: "
#passhash=$(python -c "from crypt import crypt; print(crypt(input(),'\$6\$$(openssl rand -base64 12)\$'))")

if [ $? -ne 0 ]
then
    echo "Password not registered"
    exit 1
fi

sudo sqlite3 /data/freenas-v1.db "update account_bsdusers set bsdusr_unixhash = '$passhash' where bsdusr_uid = $userid"

if [ $? -ne 0 ]
then
    echo "Database update failed"
    exit 1
fi

echo "Password updated"
echo "Please request system restart"
exit 0
