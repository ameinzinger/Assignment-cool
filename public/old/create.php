<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */
if (isset ( $_POST ['submit'] )) {
	
	require "../config.php";
	require "../common.php";
	
	try {
		// $connection = new PDO ( $dsn, $username, $password, $options );
		$connection = new PDO ( $dsn );
		$connection->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		echo $dsn;
		
		$name = $_POST ['coverage_name'];
		$cost = $_POST ['cost'];
		
		$sql = "INSERT INTO coverage (coverage_name, cost) VALUES (:coverage_name,:cost)";
// 		echo "<h3>SQL:" . $sql . "</h3>";
		$statement = $connection->prepare ( $sql );
		$statement->bindParam ( ':coverage_name', $name);
		$statement->bindParam ( ':cost', $cost);
		// $statement->execute ( $new_user );
		$statement->execute ();
	} catch ( PDOException $error ) {
		echo "<h1>Error Creating Coverage: </br></h1>";
		echo $sql . "<br>" . $error->getMessage ();
		exit ();
	}
}
?>

<?php require "templates/header.php"; ?>

<?php
if (isset ( $_POST ['submit'] ) && $statement) {
    $to = "coverages@fredcohen.com";
    $subject = "New Coverage Added";
    $txt = "Coverage ".$name." with cost $".$cost." was added to the coverages database";
    $headers = "From: Sgollen0993@conestogac.on.ca";
    mail($to,$subject,$txt,$headers);?>
<blockquote><?php echo $_POST['coverage_name']; ?> successfully added.</blockquote>
<?php
}
?>

<h2>Add coverage</h2>

<form method="post">
	<label for="coverage_name">Coverage Name</label>
    <select name="coverage_name" id="coverage_name">
        <option value="Auto">Auto</option>
        <option value="Property">Property</option>
        <option value="Legal Expenses">Legal Expense</option>
    </select>
    <label for="cost">Cost</label>
    <input type="number" name="cost" id="cost">
    </br></br>
    <input type="submit" name="submit" value="Submit">
    </br>
</form>
</br>

<?php
/*
    SENDING MESSAGING WHEN WE LOAD THE PAGE */

?>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>