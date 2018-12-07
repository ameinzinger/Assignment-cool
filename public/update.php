<?php
require "templates/header.php";

if (isset ($_POST ['submit'])) {
    try {

        require "../config.php";
        require "../common.php";

// 		$connection = new PDO ( $dsn, $username, $password, $options );
        $connection = new PDO ($dsn);
        $name = $_POST ['coverage_name'];
        $cost = $_POST ['cost'];
        $id = $_POST['id'];

// 		echo var_dump($_POST);
        if (($name="Auto" OR $name="Property" OR $name="Legal Expenses")AND is_int(intval($cost,10))) {

        $sql = "UPDATE coverage SET coverage_name = :coverage_name,cost = :cost WHERE id = :id";
// 		echo $sql;

        $statement = $connection->prepare($sql);
        $statement->bindParam(':coverage_name', $name, PDO::PARAM_STR);
        $statement->bindParam(':cost', $cost, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
// 		echo "</br></br>" .  $statement->debugDumpParams() . "</br></br>";
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
    if(isset ($statement)){
        $to = "coverages@fredcohen.com";
        $subject = "Coverage Updated";
        $txt = "Coverage ".$id." was updated to ".$name." with cost $".$cost." in the coverages database";
        $headers = "From: Sgollen0993@conestogac.on.ca";
        mail($to,$subject,$txt,$headers);
        echo "</br></br><h3>Coverage " . $name . " updated successfully!</h3>";
        echo "</br><a href='index.php'>Back to home</a>";
    }
    else {
        echo "</br></br><h3>Update not successful</h3>";
        echo "</br><a href=" . "update.php?id=".$id.">Back to update</a>";

    }
    exit();
}
// echo $_GET ['id'] . "<br/>";
if (isset ($_GET ['id'])) {

    try {

        require "../config.php";
        require "../common.php";

        $connection = new PDO ($dsn);

        $sql = "SELECT * FROM coverage WHERE id = :id";

        // $location = $_POST ['location'];
        $id = $_GET ['id'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php
// if (isset ( $_POST ['submit'] )) {
if ($result) {
    ?>

    <form method="post">
    <?php
    foreach ($result as $row) {
        ?>
        <label for="coverage_name">Coverage Name</label>
        <select name="coverage_name" id="coverage_name">
            <option value="Auto" <?php  if($row["coverage_name"]=="Auto"){ echo "selected";}; ?>>Auto</option>
            <option value="Property" <?php  if($row["coverage_name"]=="Property"){ echo "selected";}; ?>>Property</option>
            <option value="Legal Expenses" <?php  if($row["coverage_name"]=="Legal Expenses"){ echo "selected";}; ?>>Legal Expense</option>
        </select>
        <label for="cost">Cost</label>
        <input type="number" name="cost" id="cost" value="<?php echo escape(intval($row["cost"]),10); ?>">
        </br></br>
        <input type="hidden" name="id" id="id" value="<?php echo escape($row["id"]); ?>">
        <input type="submit" name="submit" value="Update">
        </br>
        </form>
        <?php
    }
    ?>
    <?php
} else {
    ?>
    <blockquote>No results found for <?php echo escape($_GET['id']); ?>.</blockquote>
    <?php
}
// }
?>
    </br>

    <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>