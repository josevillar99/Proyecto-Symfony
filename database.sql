create database if not exists symfony_master;
use symfony_master;

create table if not exists users(
id      int(255) auto_increment not null,
rol     varchar(50),
name    varchar(150),
surname varchar(150),
email   varchar(150),
password varchar(300),
created_at datetime,
constraint pk_users primary key (id) 
)engine=innodb;

INSERT into users values (null, 'ROLE_USER', 'Victor', 'Robles', 'email@email.com', 'pwd123', CURTIME());
INSERT into users values (null, 'ROLE_USER', 'Paco', 'Fernandez', 'email@email.com', 'pwd123', CURTIME());
INSERT into users values (null, 'ROLE_USER', 'Manolo', 'Rodriguez', 'email@email.com', 'pwd123', CURTIME());

create table if not exists tasks(
id          int(255) auto_increment not null,
user_id     int(100),
title       varchar(250),
content     text,
priority    varchar(20),
hours       int(100),
created_at  datetime,
constraint pk_tasks primary key (id),
constraint fk_task_user foreign key (user_id) references users(id)
)engine=innodb

INSERT into tasks values (null, 1, 'Tarea 1', 'Hacer la compra', 'High', 1, CURTIME());
INSERT into tasks values (null, 2, 'Tarea 2', 'Recoger la habitacion', 'Low', 2, CURTIME());
INSERT into tasks values (null, 1, 'Tarea 3', 'Limpiar el jardin', 'Medium', 3, CURTIME());