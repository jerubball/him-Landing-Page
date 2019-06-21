
-- drop database if exists Website;

create database if not exists Website;

use Website;

-- drop table if exists url;

create table if not exists url (
  url  varchar(10)  primary key,
  redirect  varchar(100)  not null,
  created  datetime,
  expires  datetime,
  visited  integer  not null  default 0,
  enabled  boolean  not null  default true,
  reserved  boolean  not null  default false
);

-- alter table url modify url varchar(10) primary key;
-- alter table url modify redirect varchar(100) not null;
-- alter table url modify created datetime;
-- alter table url modify expires datetime;
-- alter table url modify visited integer not null default 0;
-- alter table url modify enabled bool not null default true;
-- alter table url modify reserved bool not null default false;
