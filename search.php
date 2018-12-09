<?php

/**
 * Function to query information based on 
 * a parameter: in this case, Coverage name.
 *
 */

	try 
	{
		
		require "config.php";
		require "common.php";
        $q = $_GET['q'];
// 		$connection = new PDO($dsn, $username, $password, $options);
		$connection = new PDO ( $dsn );
		$sql = "SELECT * 
						FROM coverage
						WHERE coverage_name = :coverage_name";


		$statement = $connection->prepare($sql);
		$statement->bindParam(':coverage_name', $q, PDO::PARAM_STR);
		$statement->execute();
		$result = $statement->fetchAll();
	}	
	catch(PDOException $error) 
	{
		echo $sql . "<br>" . $error->getMessage();
	}
?>

   <div class="table-responsive">
    <table id="customers" class=".table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Coverage Name</th>
            <th>Cost</th>
            <th colspan="2">Modify Coverage Records</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $className = "'confirmation'";
        foreach ( $result as $row ) {
            ?>
            <tr>
                <td><?php echo escape($row["id"]); ?></td>
                <td><?php echo escape($row["coverage_name"]); ?></td>
                <td><?php echo escape($row["cost"]); ?></td>
                <td><?php echo "<a href=" . "update.php?id=" . $row["id"] . ">" . "Update</a>" ?> </td>
                <td><?php echo "<a href=" . "delete.php?id=" . $row["id"] . " class=" . $className . "> Delete </a>" ?> </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>


<a id="customBack1" href="index.php">&larr; Back to home</a>

<?php require "templates/footer.php"; ?>