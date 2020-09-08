<?php
	
// include the config file that we created before
require "../config.php";

// to escape the search term
require "common.php";

// This code will only run if the delete button is clicked
if (isset($_GET["id"])){

    // try/catch statement 
    try{

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

    }catch(PDOException $error){
        // if there is an error, tell us what it is
        echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }
};

// This code runs on page load
include "templates/search.php";
include "templates/header.php";
include "templates/submenu.php";
            
// if there are some results
if($result && $statement->rowCount() > 0){

    // Loop through each result in the array and display the following html
    foreach($result as $row){
    ?>

        <div class="dvdRecord">

            <p class="id">
                <?php echo $row["id"]; ?>
            </p>

            <h4 class="title">
                <?php echo $row['title']; ?>
            </h4>

            <?php
            // if tv series is not NULL, display tv tag
            if($row["tv"] !== NULL){ ?>
                <p class="tv tvTag">TV</p>
            <?php } ?>

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
                // if image does not exist, display "No image available"
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
                } ?>
            </p>

            <p class="starring">
                <?php
                // if starring is not empty, display info
                if($row["starring"] !== ""){
                ?>
                    <h6 class="labelResult">Starring:</h6>
                    <?php echo $row['starring']; ?>
                <?php
                } ?>
            </p>

            <p class="genre">
                <?php
                // if genre is not empty, display info
                if($row["genre"] !== ""){
                ?>
                    <h6 class="labelResult">Genre:</h6>
                    <?php echo $row['genre']; ?>
                <?php
                } ?>
            </p>

            <?php
            // if tv series is not NULL, display season info
            if($row["tv"] !== NULL){
            ?>
                <p class="season">
                    <h6 class="labelResult">Season:</h6>
                    <?php
                    // if season was not entered by user
                    if($row["season"] == 0){
                        echo "Not specified";
                    // if season was entered by user
                    }else{
                        echo $row['season'];
                    }
            } ?>

            <p class="release">
                <?php
                // if releasedate is left blank, display info
                if($row["releasedate"] !== "0000"){
                ?>
                    <h6 class="labelResult">Release date:</h6>
                    <?php echo $row['releasedate'];
                } ?>
            </p>

            <!-- confirm user wants to delete -->
            <p class="right">
                <a href='delete.php?id=<?php echo $row['id']; ?>' class="delBtn" onclick="return confirm('You are about to delete this record. This action cannot be undone. Are you sure you want to proceed?');">Delete</a>
            </p>
        </div>

        <?php }; //close the foreach
        }else{
            if(isset($_POST['search'])){
                echo "<p class='noResult'>No results matched your search of '<span>" . $query . "</span>'.
                <br>
                Please try a different search term.</p>";
            }else{
                echo "<p class='noResult'><b>There are currently no DVDs in your collection.</b><br>
                To add to your database, use the ADD button above.</p>";
            }
        }

include "templates/scroll-top.php";
include "templates/footer.php";
?>