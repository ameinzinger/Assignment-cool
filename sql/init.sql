CREATE DATABASE coverage;

use coverage;

CREATE TABLE `coverage` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`coverage_name`	TEXT NOT NULL,
	`cost`	INTEGER NOT NULL
);

