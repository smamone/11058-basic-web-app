<?php

// this code will only execute after the submit button is clicked in the search field
if(isset($_POST['search']) or isset($_POST['submit'])){
	
    // include the config file that we created before
    require "../config.php";
    
    // to escape the search term
	require "common.php";
    
    // try/catch statement 
	try{
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
			tv LIKE '%" . $query . "%'
				OR
			season LIKE '%" . $query . "%'
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

	}catch(PDOException $error){
        // if there is an error, tell us what it is
		echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }
}

include "templates/header.php"; ?>

<section class="section">
    <div class="container">

    <?php  
        if(isset($_POST['search']) or isset($_POST['submit'])){
            // if there are some results
            if($result && $statement->rowCount() > 0){ ?>

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

        <?php // loop through each result in the array and output as html
        foreach($result as $row) {
        ?>

        <div class="dvdRecord"> 
    <!--
             style="
                <?php 
                // if record image exists, use it as background image for dvdRecord
                //if($row["image"] !== NULL 
                //   && $row["image"] !== ""){
                //    echo 
                //        "background-color: #EEE;
                //        background-repeat: none; 
                //        background-size: cover;
                //        background-position: top;
                //        background-image: url('uploads/"
                //        . $row["image"];
                //        "');"
                ;?>
            ');">
    -->

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
                if($row["image"] !== NULL 
                   && $row["image"] !== "" 
                   && $row["tv"] == "Yes" ){
                    echo "<img src='uploads/" . 
                        $row["image"] . "' alt='" . 
                        $row['title'] .", season " . 
                        $row['season'] . "'>";
                // if image exists and record is not a tv series, add alt tag using title only
                }else if($row["image"] !== NULL 
                 && $row["image"] !== "" 
                 && $row["tv"] !== "Yes" ){
                    echo "<img src='uploads/" . 
                        $row["image"] . "' alt='" . 
                        $row['title'] ."'>";
                // if image does not exist, display "no image available"
                }else{
                    echo "<p class='noImage'>No image available</p>";
                } ?>
            </p>

            <p class="director">
                <?php
                // if director is not empty, display info
                if($row["director"] !== ""){
                ?>
                    <h6 class="labelResult">Director:</h6>
                    <?php echo $row['director']; 
                } ?>
            </p>

            <p class="starring">
                <?php
                // if starring is not empty, display info
                if($row["starring"] !== ""){
                ?>
                    <h6 class="labelResult">Starring:</h6>
                    <?php echo $row['starring'];
                } ?>
            </p>

            <p class="genre">
                <?php
                // if genre is not empty, display info
                if($row["genre"] !== ""){
                ?>
                    <h6 class="labelResult">Genre:</h6>
                    <?php echo $row['genre'];
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
        </div>

        <?php } //close the foreach
        }else{
            if(isset($_POST['search'])){
                echo "<p class='noResult'>No results matched your search of '<span>" . $query . "</span>'.
                <br>
                Please try a different search term.</p>";
            }else{
                echo "<p class='noResult'><b>There are currently no DVDs in your collection.</b><br>
                To add to your database, use the ADD button above.</p>";
            }
        } ?>

    <?php }; // close the foreach 

    ?>

        <div class="row">
            <form class="formBtn" method="post">
                <input class="viewBtn" type="submit" name="submit" value="View all DVDs">
            </form>

            <!-- scroll to top button -->
            <a class="top" href="#top">
                <i class="fas fa-chevron-circle-up"></i>
            </a>
        </div>

    </div>
</section>


<?php include "templates/footer.php"; ?>