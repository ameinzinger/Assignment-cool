<?php
require "templates/header.php";
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
if (isset($statement)) {
    $to = "coverages@fredcohen.com";
    $subject = "Coverage Deleted";
    $txt = "Coverage " . $id . " was deleted from the coverages database";
    $headers = "From: Sgollen0993@conestogac.on.ca";
    mail($to, $subject, $txt, $headers);
    echo "<br>Coverage Successfully Deleted!<br>";
}
	
}
?>
<br>
<a href="index.php">Back to home</a>