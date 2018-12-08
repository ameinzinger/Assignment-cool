<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */
require "templates/header.php";
require "config.php";

try 
{
// 	$connection = new PDO($baseDSN, $username, $password, $options);
	$connection = new PDO($dsn);
	$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = file_get_contents("sql/init-sqlite.sql");
	$connection->exec($sql);
	
	echo "<p>Database and table users created successfully.</p>";
	echo '<br><a id="customBack" href="index.php">&larr; Back to home</a>';
	
}

catch(PDOException $error)
{
	echo $sql . "<br>" . $error->getMessage();
    echo '<br><a id="customBack" href="index.php">&larr; Back to home</a>';
}

