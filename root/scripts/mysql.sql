-- use with mysql < mysql.sql

create user 'ieee'@'%' identified BY 'ieee';
grant all on *.* to 'ieee'@'%';
flush privileges;
