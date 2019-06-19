create database if not exists website;

use website;

create table if not exists url (
  url  varchar(10)  primary key,
  redirect varchar(100),
  created datetime,
  visited integer
);

-- alter table url modify url varchar(10) primary key;
-- alter table url modify redirect varchar(100);
-- alter table url modify created datetime;
-- alter table url modify visited integer;
