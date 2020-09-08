<?php include "templates/header.php"; ?>

<?php
// this code will only execute after the submit button is clicked
if(isset($_POST['submit'])){

    // include the config file
    require "../config.php";
    include "templates/upload.php";
    
    // if upload is empty and there are no other errors detected, submit form
	if(empty($input_err) && 
       empty($upload_err)){
    
        // try/catch statement
        try{

            // FIRST: Connect to the database
            $connection = new PDO($dsn, $username, $password, $options);

            // SECOND: Get the contents of the form and store it in an array
            $newDvd = array( 
                "title"       => $_POST['title'],
                "image"       => $imgid,
                "director"    => $_POST['director'],
                "starring"    => $_POST['starring'],
                "genre"       => $_POST['genre'],
                "tv"          => $_POST['tv'],
                "season"      => $_POST['season'],
                "releasedate" => $_POST['releasedate'],
            );

            // THIRD: Turn the array into a SQL statement
            $sql = "INSERT INTO dvds (
                title,
                image,
                director,
                starring,
                genre,
                tv,
                season,
                releasedate
            ) VALUES (
                :title,
                :image,
                :director,
                :starring,
                :genre,
                :tv,
                :season,
                :releasedate
            )";

            // FOURTH: Now write the SQL to the database
            $statement = $connection->prepare($sql);
            $statement->execute($newDvd);

        }catch (PDOException $error){    
            // if there is an error, tell us what it is
            echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
        }
    }
}?>

<div class="container">
        
    <div class="content">

        <h2>Add a DVD</h2>
        
        <p class="note">Fields marked with an <span class="req">*</span> are required.</p>

        <?php 
        // show confirmation message on successful form submission
        if(isset($_POST['submit']) && $statement && $uploadOk == 1){
            echo "<p class='alert create'>DVD successfully added.</p>";
        } ?>

        <!--form to collect data for each DVD-->
        <form id="createRecord" method="post" enctype="multipart/form-data">

            <ul class="addRecord">

                <li class="label">
                    <label for="title">Title<span class="req">*</span></label> 
                    <input type="text" name="title" id="title" required>
                </li>

                <li class="label">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image">
                </li>

                <li class="label">
                    <label for="director">Director</label>
                    <input type="text" name="director" id="director">
                </li>

                <li class="label">
                    <label for="starring">Starring</label>
                    <input type="text" name="starring" id="starring">
                </li>

                <li class="label">
                    <label for="genre">Genre</label>
                    <input type="text" name="genre" id="genre">
                </li>

                <li class="label">
                    <label for="tv" class="label checkbox">TV Series</label>
                    <input class="checkbox" type="checkbox" name="tv" id="tv" value="Yes">
                </li>
                
                <li class="label">
                    <label for="season">Season</label>
                    <input type="number" name="season" id="season">
                </li>

                <li class="label">
                    <label for="releasedate">Release Date</label>
                    <input type="number" name="releasedate" id="releasedate">
                </li>

                <p class="field control">
                    <input class="addBtn" type="submit" name="submit" value="Add">
                    <input type="reset" class="resBtn" value="Reset">
                    <a class="canBtn" href="welcome.php">Cancel</a>
                </p>

            </ul>

        </form>
        
    </div>
    
</div>

<?php include "templates/footer.php"; ?>