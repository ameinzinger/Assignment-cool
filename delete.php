<?php
require "templates/header.php";

if (isset ( $_GET ['id'] )) {
	
	try {
		
		require "config.php";
		require "common.php";
		
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

	echo '<blockquote>Record deleted.</blockquote><br>
<script type="text/javascript">
    setTimeout(function () {
    window.location.href = "index.php"; //will redirect to your blog page (an ex: blog.html)
        }, 1000);
        </script>';
	echo '<a id="customBack" href="index.php">&larr; Back to home</a>';
	
	
}
?>
