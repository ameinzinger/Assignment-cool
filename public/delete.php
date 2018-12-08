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

    $to = "coverages@fredcohen.com";
    $subject = "Coverage Deleted";
    $txt = "Coverage ".$id." was deleted from the coverages database";
    $headers = "From: Sgollen0993@conestogac.on.ca";
    mail($to,$subject,$txt,$headers);

	echo '<script type="text/javascript">
        window.location.href="index.php";
        </script>';
	
	
}
?>
<br>
<a href="index.php">Back to home</a>