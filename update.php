<?php
require "templates/header.php";

if (isset ($_POST ['submit'])) {
    try {

        require "config.php";
        require "common.php";

// 		$connection = new PDO ( $dsn, $username, $password, $options );
        $connection = new PDO ($dsn);
        $name = $_POST ['coverage_name'];
        $cost = $_POST ['cost'];
        $id = $_POST['id'];

        $sql = "SELECT * 
						FROM coverage
						WHERE coverage_name = :coverage_name AND cost = :cost AND id != :id";



        if(($name=="Auto" OR $name=="Property" OR $name=="Legal Expenses") AND $cost==intval($cost)AND strlen($cost)==strlen(intval($cost))) {
            $statement = $connection->prepare($sql);
            $statement->bindParam(':coverage_name', $name, PDO::PARAM_STR);
            $statement->bindParam(':cost', $cost, PDO::PARAM_STR);
            $statement->bindParam(':id',$id, PDO::PARAM_STR);
            $statement->execute();

            $result = $statement->fetchAll();

            if (!$result) {

                $sql = "UPDATE coverage SET coverage_name = :coverage_name,cost = :cost WHERE id = :id";

                $statement = $connection->prepare($sql);
                $statement->bindParam(':coverage_name', $name, PDO::PARAM_STR);
                $statement->bindParam(':cost', $cost, PDO::PARAM_STR);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();
// 		echo "</br></br>" .  $statement->debugDumpParams() . "</br></br>";
            }
        }
        else $result = false;

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
    if($result){
        ?> <blockquote><?php echo $_POST['coverage_name']." ".$_POST['cost'];?> already exists.</blockquote>
        <div id="customBox">
        <form method="post">
            <label for="coverage_name">Coverage Name</label>
            <select name="coverage_name" id="coverage_name">
                <option value="Auto" <?php  if($name=="Auto"){ echo "selected";}; ?>>Auto</option>
                <option value="Property" <?php  if($name=="Property"){ echo "selected";}; ?>>Property</option>
                <option value="Legal Expenses" <?php  if($name=="Legal Expenses"){ echo "selected";}; ?>>Legal Expense</option>
            </select>
            <label for="cost">Cost</label>
            <input type="number" name="cost" id="cost" value="<?php echo escape($cost); ?>">
            </br></br>
            <input type="hidden" name="id" id="id" value="<?php echo escape($id); ?>">
            <input type="submit" name="submit" value="Update">
            </br>
            </form>
            </div>
        </br>
        <a id="customBack"  href="index.php">&larr; Back to home</a>

   <?php
    }
    else if(isset ($statement)){
        $to = "coverages@fredcohen.com";
        $subject = "Coverage Updated";
        $txt = "Coverage ".$id." was updated to ".$name." with cost $".$cost." in the coverages database";
        $headers = "From: Sgollen0993@conestogac.on.ca";
        mail($to,$subject,$txt,$headers);
        echo "</br></br><h3>Coverage " . $name . " updated successfully!</h3>";
        echo '<script type="text/javascript">
    setTimeout(function () {
    window.location.href = "index.php"; //will redirect to your blog page (an ex: blog.html)
        }, 1000);
        </script>';
    }
    else {
        echo "</br></br><h3>Update not successful</h3>";
        ?> <blockquote><?php echo $_POST['coverage_name']." ".$_POST['cost'];?> already exists.</blockquote>
        <div id="customBox">
            <form method="post">
                <label for="coverage_name">Coverage Name</label>
                <select name="coverage_name" id="coverage_name">
                    <option value="Auto" <?php  if($name=="Auto"){ echo "selected";}; ?>>Auto</option>
                    <option value="Property" <?php  if($name=="Property"){ echo "selected";}; ?>>Property</option>
                    <option value="Legal Expenses" <?php  if($name=="Legal Expenses"){ echo "selected";}; ?>>Legal Expense</option>
                </select>
                <label for="cost">Cost</label>
                <input type="number" name="cost" id="cost" value="<?php echo escape($cost); ?>">
                </br></br>
                <input type="hidden" name="id" id="id" value="<?php echo escape($id); ?>">
                <input type="submit" name="submit" value="Update">
                </br>
            </form>
        </div>
        </br>
        <a id="customBack"  href="index.php">&larr; Back to home</a>

        <?php
        //echo "</br><a href=" . "update.php?id=".$id.">Back to update</a>";

    }
    exit();
}
// echo $_GET ['id'] . "<br/>";
if (isset ($_GET ['id'])) {
// Selects record for updating
    try {

        require "config.php";
        require "common.php";

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
<div id="customBox">
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
        <input type="number" name="cost" id="cost" value="<?php echo escape($row["cost"]); ?>">
        </br></br>
        <input type="hidden" name="id" id="id" value="<?php echo escape($row["id"]); ?>">
        <input type="submit" name="submit" value="Update">
        </br>
        </form>
</div>
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

   <a id="customBack"  href="index.php">&larr; Back to home</a>

<?php require "templates/footer.php"; ?>