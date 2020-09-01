
-- drop database if exists Website;

create database if not exists Website;

use Website;

-- drop table if exists authentication

create table if not exists authentication (
    email  varchar(255)  primary key,
    username  varchar(50),
    ip  varchar(45),
    token  varchar(50),
    expires  datetime,
    suspended  datetime,
    attempts  int
);
