-- use with mysql < mysql.sql

create user 'ieee'@'%' identified by 'ieee';
grant all on *.* to 'ieee'@'%' with grant option;
flush privileges;
