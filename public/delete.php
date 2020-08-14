<?php 

// include the config and common files
require "../config.php";
require "common.php";

// This code will only run if the delete button is clicked
if (isset($_GET["id"])) {

    // this is called a try/catch statement 
    try {

        // define database connection
        $connection = new PDO($dsn, $username, $password, $options);

        // set id variable
        $id = $_GET["id"];

        // Create the SQL 
        $sql = "DELETE FROM dvds WHERE id = :id"; // dvds table

        // Prepare the SQL
        $statement = $connection->prepare($sql);

        // bind the id to the PDO
        $statement->bindValue(':id', $id);

        // execute the statement
        $statement->execute();

        // Success message
        $success = "DVD successfully deleted.";

    } catch(PDOException $error) {
        // if there is an error, tell us what it is
        echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }
};

// This code runs on page load
try {
    $connection = new PDO($dsn, $username, $password, $options);

    // SECOND: Create the SQL 
    $sql = "SELECT * FROM dvds"; // dvds table

    // THIRD: Prepare the SQL
    $statement = $connection->prepare($sql);
    $statement->execute();

    // FOURTH: Put it into a $result object that we can access in the page
    $result = $statement->fetchAll();

} catch(PDOException $error) {
    echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
}

?>

<?php include "templates/header.php"; ?>

<h2>DVDs in my collection</h2>

<?php // This is a loop, which will loop through each result in the array
foreach($result as $row) {
?>

<p>
    ID:
    <?php echo $row["id"]; ?><br>

    Title:
    <?php echo $row['title']; ?><br>

    Image:
    <?php echo $row['image']; ?><br>

    Director:
    <?php echo $row['director']; ?><br>

    Starring:
    <?php echo $row['starring']; ?><br>

    Genre:
    <?php echo $row['genre']; ?><br>

    TV Series:
    <?php echo $row['tv']; ?><br>

    Season:
    <?php echo $row['season']; ?><br>

    Release date:
    <?php echo $row['releasedate']; ?><br>

    <!-- confirm user wants to delete -->
    <a href='delete.php?id=<?php echo $row['id']; ?>' onclick="return confirm('Are you sure you want to delete this record? This cannot be undone.');">Delete</a>

</p>

<?php   // this will output all the data from the array
        // echo '<pre>'; var_dump($row); 
?>

<hr>
<?php
}; // close the foreach
?>

<?php include "templates/footer.php"; ?>