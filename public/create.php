<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

if (isset($_POST['submit'])) 
{
	
	try 
	{
		
		require "../config.php";
		require "../common.php";

// 		$connection = new PDO($dsn, $username, $password, $options);
		$connection = new PDO ( $dsn );

		$sql = "SELECT * 
						FROM coverage
						WHERE coverage_name = :coverage_name AND cost = :cost";

		$name = $_POST['coverage_name'];
        $cost = $_POST ['cost'];

		$statement = $connection->prepare($sql);
		$statement->bindParam(':coverage_name', $name, PDO::PARAM_STR);
        $statement->bindParam(':cost', $cost, PDO::PARAM_STR);
		$statement->execute();

		$result = $statement->fetchAll();

		if(!$result) {
            $sql = "INSERT INTO coverage (coverage_name, cost) VALUES (:coverage_name,:cost)";
// 		echo "<h3>SQL:" . $sql . "</h3>";
            $statement = $connection->prepare($sql);
            $statement->bindParam(':coverage_name', $name);
            $statement->bindParam(':cost', $cost);
            // $statement->execute ( $new_user );
            $statement->execute();
        }
	}
	
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>
<?php require "templates/header.php"; ?>
		
<?php  
if (isset($_POST['submit'])) 
{
	if ($result) 
    { ?> <blockquote><?php echo $_POST['coverage_name']." ".$_POST['cost'];?> already exists.</blockquote>
    <?php
	}
    else if (isset ($statement)) {
        $to = "coverages@fredcohen.com";
        $subject = "New Coverage Added";
        $txt = "Coverage ".$name." with cost $".$cost." was added to the coverages database";
        $headers = "From: Sgollen0993@conestogac.on.ca";
        mail($to,$subject,$txt,$headers);?>
        <blockquote><?php echo $_POST['coverage_name']; ?> successfully added.</blockquote>
        <?php
    }
	else 
	{ ?>
		<blockquote>No results found for <?php echo escape($_POST['coverage_name']); ?>.</blockquote>
	<?php
	} 
}?> 

<h2>Create new coverage</h2>

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
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>