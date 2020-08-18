<?php 
	
// include the config file
require "../config.php"; 

// this is called a try/catch statement 
try {
    // FIRST: Connect to the database
    $connection = new PDO($dsn, $username, $password, $options);

    // SECOND: Create the SQL 
    $sql = "SELECT * FROM dvds"; // dvds table

    // THIRD: Prepare the SQL
    $statement = $connection->prepare($sql);
    $statement->execute();

    // FOURTH: Put it into a $result object that we can access in the page
    $result = $statement->fetchAll();

} catch(PDOException $error) {
    
    // if there is an error, tell us what it is
    echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
}

?>

<?php include "templates/header.php"; ?>

<div class="container">

    <h2>DVDs in my collection</h2>

    <div class="records">

<?php // This is a loop, which will loop through each result in the array
foreach($result as $row) {
?>

    <div class="dvdRecord">
        <p class="id">
<!--                <h6 class="labelResult">ID:</h6>-->
        <?php echo $row["id"]; ?>
        </p>

        <h4 class="title">
<!--                <h6 class="labelResult">Title:</h6>-->
        <?php echo $row['title']; ?>
        </h4>

        <p class="image is-3by4">
<!--                <h6 class="labelResult">Image:</h6>-->
        <?php echo $row['image']; ?>
        </p>

        <p class="director">
            <h6 class="labelResult">Director:</h6>
        <?php echo $row['director']; ?>
        </p>

        <p class="starring">
            <h6 class="labelResult">Starring:</h6>
        <?php echo $row['starring']; ?>
        </p>

        <p class="genre">
            <h6 class="labelResult">Genre:</h6>
        <?php echo $row['genre']; ?>
        </p>

        <p class="tv">
            <h6 class="labelResult">TV Series:</h6>
        <?php echo $row['tv']; ?>
        </p>

        <p class="season">
            <h6 class="labelResult">Season:</h6>
        <?php echo $row['season']; ?>
        </p>

        <p class="release">
            <h6 class="labelResult">Release date:</h6>
        <?php echo $row['releasedate']; ?>
        </p>

        <p>
            <a href='update-work.php?id=<?php echo $row['id']; ?>' class="editBtn">Edit</a>
        </p>
    </div>

<?php   // this will output all the data from the array
        // echo '<pre>'; var_dump($row); 
?>

<!--<hr>-->
<?php
}; // close the foreach
?>

</div>

</div>

<!--
<form method="post">
    <input type="submit" name="submit" value="View all DVDs">
</form>
-->

<?php include "templates/footer.php"; ?>