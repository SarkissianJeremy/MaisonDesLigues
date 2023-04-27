create database mdl;
use mdl;

create user 'mdl'@'localhost' identified by 'mdl';
grant ALL PRIVILEGES on mdl.* to 'mdl'@'localhost';