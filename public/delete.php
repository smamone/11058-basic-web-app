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

<section class="section">
<div class="container">

    <h2>DVDs in my collection</h2>
    
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
        <p class="id">
<!--                <h6 class="labelResult">ID:</h6>-->
        <?php echo $row["id"]; ?>
        </p>

        <h4 class="title">
<!--                <h6 class="labelResult">Title:</h6>-->
        <?php echo $row['title']; ?>
        </h4>

        <p class="image">
            <img src="uploads/<?php echo $row['image']; ?>">
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

        <!-- confirm user wants to delete -->
        <p>
            <a href='delete.php?id=<?php echo $row['id']; ?>' class="delBtn notification is-danger" onclick="return confirm('Are you sure you want to delete this record? This cannot be undone.');">Delete</a>
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

<?php include "templates/footer.php"; ?>