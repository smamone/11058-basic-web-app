<?php

//session_start();
// this code will only execute after the submit button is clicked in the search field
if (isset($_POST['search']) or isset($_POST['submit'])) {
	
    // include the config file that we created before
    require "../config.php";
    
    // to escape the search term
	require "common.php";
    
    // this is called a try/catch statement 
	try {
        // FIRST: Connect to the database
        $connection = new PDO($dsn, $username, $password, $options);
		
        // SECOND: Create the SQL 
//        $sql = "SELECT * FROM dvds"; // dvds table
        if(isset($_POST['search'])){ // search through results
//			$userid = $_SESSION['id'];
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
}
?>

<?php include "templates/header.php"; ?>

<section class="section">
<div class="container">

<?php  
    if (isset($_POST['search']) or isset($_POST['submit'])) {
        // if there are some results
        if ($result && $statement->rowCount() > 0) { ?>
    
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
            if( $row["image"] !== NULL && 
               $row["image"] !== "" ){
                echo "<img src='uploads/" . 
                    $row["image"] . "' alt='" . 
                    $row['title'] .", season " . 
                    $row['season'] . "'>";
            }
            else
            {
                echo "<p class='noImage'>No image available.</p>";
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
                    <?php echo $row['tv']; ?>
                </p>

                <p class="season">
                    <h6 class="labelResult">Season:</h6>
                    <?php echo $row['season']; ?>
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
    </div>

    <?php } //close the foreach
    }else{
        if(isset($_POST['search'])){
            echo "<p class='noResult'>No results matched your search of '<span>" . $query . "</span>'.
            <br>
            Please try a different search term.</p>";
        }else{
            echo "<p class='noResult'>There are currently no DVDs in your collection.</p>";
        }
    }
    ?>

<?php   // this will output all the data from the array
        // echo '<pre>'; var_dump($row);
?>

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