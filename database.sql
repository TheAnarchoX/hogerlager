DROP SCHEMA IF EXISTS hogerlager  ;
CREATE SCHEMA hogerlager;
USE hogerlager;
DROP TABLE IF EXISTS results;
create table results
(
  id int auto_increment
    primary key,
  name varchar(191) null,
  tries int null
)
;
