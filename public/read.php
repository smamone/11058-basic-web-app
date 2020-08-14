<?php 

// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {
	
    // include the config file that we created before
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
}
?>

<?php include "templates/header.php"; ?>

<?php  
    if (isset($_POST['submit'])) {
        //if there are some results
        if ($result && $statement->rowCount() > 0) { ?>
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
            </p>

<?php   // this will output all the data from the array
        // echo '<pre>'; var_dump($row); 
?>

<hr>
<?php }; // close the foreach
        }; 
    }; 
?>

<form method="post">
    <input type="submit" name="submit" value="View all DVDs">
</form>

<?php include "templates/footer.php"; ?>