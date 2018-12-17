-- use with mysql < mysqlsetup.sql

create user 'ieee'@'%' identified by 'ieee';
grant all on *.* to 'ieee'@'%' with grant option;
create user 'test'@'%' identified by 'test';
flush privileges;
