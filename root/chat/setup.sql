
-- drop database if exists Website;

create database if not exists Website;

use Website;

-- drop table if exists chat_metadata;

create table if not exists chat_metadata (
  id  varchar(10)  primary key,
  save  enum('mysql', 'json', 'text')  not null,
  enabled  boolean  not null  default true,
  created  datetime,
  expires  datetime
);

-- drop table if exists chat;

create table if not exists chat (
  id  varchar(10)  not null,
  stamp  timestamp  not null,
  ip  varchar(45),
  username  varchar(50)  not null,
  entry  varchar(100)  not null,
  constraint chat_primary  primary key (id, stamp, username),
  constraint chat_id  foreign key (id) references chat_metadata(id)  on update cascade on delete cascade
);
