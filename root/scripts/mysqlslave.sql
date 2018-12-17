-- use with mysql < mysqlslave.sql

create database if not exists ieee;
CHANGE MASTER TO MASTER_HOST='EGGC-603-14',MASTER_USER='ieee', MASTER_PASSWORD='ieee', MASTER_LOG_FILE='mysql-bin.000001', MASTER_LOG_POS=0;
start slave;
