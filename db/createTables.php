<?php

$config = require __DIR__ . '/../db/config.php';
$pdo = new \PDO($config['dsn'], $config['user'], $config['pass']);
$pdo->query(
"
CREATE TABLE IF NOT EXISTS tasks(
uuid varchar(255) not null,
name varchar(255) not null,
priority enum('0', '1', '2') not null default '2',
status enum('0', '1') not null default '1',
primary key (uuid)
)
engine = innodb
CHARACTER SET utf8
COLLATE utf8_general_ci;
"
);
$pdo->query(
"
CREATE TABLE IF NOT EXISTS tasks_tags(
uuid varchar(255) not null,
tag varchar(50) not null,
foreign key (uuid) REFERENCES tasks (uuid) ON DELETE CASCADE
)
engine = innodb
CHARACTER SET utf8
COLLATE utf8_general_ci;
"
);
