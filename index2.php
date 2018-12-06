<?php
require "public/templates/header.php";


try {

    require "config.php";
    require "common.php";

    // $connection = new PDO ( $dsn, $username, $password, $options );
    $connection = new PDO ( $dsn );

    $sql = "SELECT * FROM coverage";

    $statement = $connection->prepare ( $sql );
    $statement->execute ();

    $result = $statement->fetchAll (PDO::FETCH_ASSOC);
} catch ( PDOException $error ) {
    echo $sql . "<br>" . $error->getMessage ();
}

?>




<h2>Results</h2>
<h2>Results</h2> /* chnaged this*/

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Coverage Name</th>
        <th>Cost</th>
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
<?php
// }

?>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?><!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Simple Database App</title>

<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<h1>Simple Database App</h1>
	<a href="install.php">Install Database</a></br>
	<a href="public/index.php">Home</a>
</body>