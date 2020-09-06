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
                    <p class="">Displaying <b>
                    <?php
                    // display total number of DVDs showing
                    printf($statement->rowCount());
                    ?>
                    </b> results</p>
                </li>

                <li class="col query">
                    <form method="post">
                        <input type="search" id="search" name="query" placeholder="Search for a DVD">
                        <button type="submit" class="goBtn" name="search">
                            <i class="fas fa-search"></i>
                        </button>
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
                // if image exists and record is a tv series, add alt tag using title and season
                if( $row["image"] !== NULL 
                   && $row["image"] !== "" 
                   && $row["tv"] == "Yes" ){
                    echo "<img src='uploads/" . 
                        $row["image"] . "' alt='" . 
                        $row['title'] .", season " . 
                        $row['season'] . "'>";
                // if image exists and record is not a tv series, add alt tag using title only
                }else if( $row["image"] !== NULL 
                 && $row["image"] !== "" 
                 && $row["tv"] !== "Yes" ){
                    echo "<img src='uploads/" . 
                        $row["image"] . "' alt='" . 
                        $row['title'] ."'>";
                // if image does not exist, display "no image available"
                }else{
                    echo "<p class='noImage'>No image available</p>";
                }
                ?>
            </p>

            <p class="director">
                <?php
                // if director is not empty, display info
                if($row["director"] !== ""){
                ?>
                    <h6 class="labelResult">Director:</h6>
                    <?php echo $row['director']; ?>
                <?php
                }
                ?>
            </p>

            <p class="starring">
                <?php
                // if starring is not empty, display info
                if($row["starring"] !== ""){
                ?>
                    <h6 class="labelResult">Starring:</h6>
                    <?php echo $row['starring']; ?>
                <?php
                }
                ?>
            </p>

            <p class="genre">
                <?php
                // if genre is not empty, display info
                if($row["genre"] !== ""){
                ?>
                    <h6 class="labelResult">Genre:</h6>
                    <?php echo $row['genre']; ?>
                <?php
                }
                ?>
            </p>

            <p class="tv">
                <?php
                // if tv series is not NULL, display tv and season info
                if($row["tv"] !== NULL){
                ?>
                        <h6 class="labelResult">TV Series:</h6>
                        <?php echo "Yes"; ?>
                    </p>

                    <p class="season">
                        <h6 class="labelResult">Season:</h6>
                        <?php

                        // if season  was entered by user
                        if($row["season"] !== 0){
                            echo "Not specified";
                        // if season was not entered by user
                        }else{
                            echo $row['season'];
                        }
                        ?>
                <?php
                }
                ?>
            </p>

            <p class="release">
                <?php
                // if releasedate is left blank, display info
                if($row["releasedate"] !== "0000"){
                ?>
                    <h6 class="labelResult">Release date:</h6>
                    <?php echo $row['releasedate']; ?>
                <?php
                }
                ?>
            </p>

            <!-- confirm user wants to delete -->
            <p class="right">
                <a href='delete.php?id=<?php echo $row['id']; ?>' class="delBtn" onclick="return confirm('Are you sure you want to delete this record? This cannot be undone.');">Delete</a>
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