<?php
	
// include the config file that we created before
require "../config.php";

// to escape the search term
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
        // update confirmation
//        $success = echo "<p class='alert'>DVD successfully deleted.</p>";


    } catch(PDOException $error) {
        // if there is an error, tell us what it is
        echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }
};

// This code runs on page load
// this is called a try/catch statement
try {
    // FIRST: Connect to the database
    $connection = new PDO($dsn, $username, $password, $options);

    // SECOND: Create the SQL
    if(isset($_POST['search'])){ // search through results
        $query = escape($_POST['query']);

        // select any results that match any part of the title, director, starring, genre or releasedate fields
        $sql = "SELECT DISTINCT * FROM dvds WHERE 
        title LIKE '%" . $query . "%'
            OR 
        director LIKE '%" . $query . "%'
            OR
        starring LIKE '%" . $query . "%'
            OR
        genre LIKE '%" . $query . "%'
            OR
        releasedate LIKE '%" . $query . "%'
            ";
    }else{
        // otherwise show all results
        $sql = "SELECT * FROM dvds";
    }

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
            <ul>
                <li class="col total">
                    <?php

                    // display total number of DVDs showing
                    printf("<span>Total DVDs in collection:</span> %d\n",$statement->rowCount());
                    ?>
                </li>

                <li class="col query">
                    <form method="post">
                        <input type="search" id="search" name="query" placeholder="Search for a DVD">
                        <input type="submit" class="goBtn" name="search" value="Go">
    <!--                    <i class='fas fa-search'></i>-->
                        <p>OR</p>
                        <input class="clearBtn" type="submit" name="submit" value="View all">
                    </form>
                </li>            
            </ul>
        </div>

        <?php // This is a loop, which will loop through each result in the array
        foreach($result as $row) {
        ?>

        <div class="dvdRecord">
            <p class="id">
                <?php echo $row["id"]; ?>
            </p>

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

            <!-- confirm user wants to delete -->
            <p class="right">
                <a href='delete.php?id=<?php echo $row['id']; ?>' class="delBtn notification is-danger" onclick="return confirm('Are you sure you want to delete this record? This cannot be undone.');">Delete</a>
            </p>
        </div>

        <?php   // this will output all the data from the array
                // echo '<pre>'; var_dump($row); 
        ?>

        <?php
        }; // close the foreach
        ?>

        <div class="row">
            <!-- scroll to top button -->
            <a class="top" href="#top">
                <i class="fas fa-chevron-circle-up"></i>
            </a>
        </div>

    </div>

</section>

<?php include "templates/footer.php"; ?>