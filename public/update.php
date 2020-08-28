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

<section class="section">
<div class="container">
    
    <div id="heading">
        <h2>DVDs in my collection</h2>
    </div>
    
    <div class="submenu">
        <div class="total">
            <?php
            // display number of DVDs
            printf("<span>Total DVDs:</span> %d\n",$statement->rowCount());
            ?>
        </div>

        <div class="dropdown">
            <label for="sort"><span>Sort by</span></label>
            <select name="sort" id="sort">
                <option value="default">ID (default)</option>
                <option value="title">Title</option>
                <option value="year">Year</option>
            </select>
        </div>
    </div>

<?php // This is a loop, which will loop through each result in the array
foreach($result as $row) {
?>

    <div class="dvdRecord">
<!--
        <p class="id">
        <?php echo $row["id"]; ?>
        </p>
-->

        <h4 class="title">
        <?php echo $row['title']; ?>
        </h4>

        <p class="image">
            <?php
            if( $row["image"] !== NULL && $row["image"] !== "" ){
                echo "<img src='uploads/" . $row["image"] . "' alt='" . $row['title'] .", season " . $row['season'] . "'>";
            }
            else
            {
                echo "<p class='noImage'>No image available.</p>";
            }
            ?>
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

        <p class="right">
            <a href='update-work.php?id=<?php echo $row['id']; ?>' class="editBtn button is-link">Edit</a>
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

</section>

<!--
<form method="post">
    <input type="submit" name="submit" value="View all DVDs">
</form>
-->

<?php include "templates/footer.php"; ?>