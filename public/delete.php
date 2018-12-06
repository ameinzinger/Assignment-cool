<?php

if (isset ( $_GET ['id'] )) {
	
	try {
		
		require "../config.php";
		require "../common.php";
		
		$connection = new PDO ( $dsn);
		
		$sql = "DELETE FROM coverage WHERE id = :id";
		
		// $location = $_POST ['location'];
		$id = $_GET ['id'];
		
		$statement = $connection->prepare ( $sql );
		$statement->bindParam ( ':id', $id );
		$statement->execute ();
		
	} catch ( PDOException $error ) {
		echo $sql . "<br>" . $error->getMessage ();
	}
	
	echo "<br>Coverage Successfully Deleted!<br>";
	
	
}
?>
<br>
<a href="index.php">Back to home</a>