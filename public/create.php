<?php
// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {

    // include the config file
    require "../config.php";

    // upload image files to uploads folder
    $target_dir = "uploads/"; // file storage - folder location
    $target_file = $target_dir . basename($_FILES["image"]["name"]); // file path to upload
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // file extension type

    // valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // check file is an image
    if(isset($_POST["submit"]) && (empty($_POST))) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
    //    echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        } else {
        echo "File is not an image. Please select a different file.";
        $uploadOk = 0;
        }
    }

    // if image with the same file name already exists in database and field is not empty**
    if(file_exists($target_file)) {
        echo "A file with this name already exists. Please specify another file name.";
        $uploadOk = 0;
    }

    // if the file size is over 500KB
    if($_FILES["image"]["size"] > 500000) {
        echo "Your file is too large. Please choose a smaller file.";
        $uploadOk = 0;
    }

    // if image does not match the following formats and is not empty**
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
        echo "Only JPG, JPEG, PNG and GIF files are accepted. Please choose another file type.";
        $uploadOk = 0;
    }

    // check if $uploadOk is set to 0 by an error and field is not empty**
    if($uploadOk == 0 && (!empty($_POST))) {
        echo "Something went wrong. Your file was not uploaded.";
    // if everything is ok, try to upload file
    }else{
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    //    echo basename( $_FILES["image"]["name"]). " was successfully uploaded.";
        }else{
        echo "Something went wrong. There was an error uploading your file.";
        }
    }
    
// this is called a try/catch statement
try {
    
    // FIRST: Connect to the database
    $connection = new PDO($dsn, $username, $password, $options);
    
    // SECOND: Get the contents of the form and store it in an array
    $newDvd = array( 
        "title"       => $_POST['title'],
        "image"       => basename($_FILES["image"]["name"]),
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

} catch (PDOException $error) {
    
    // if there is an error, tell us what it is
    echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }
}
?>

<?php include "templates/header.php"; ?>

<div class="container">
        
    <div class="content">

        <h2>Add a DVD</h2>

        <?php 
        // show confirmation message on successful form submission
        if (isset($_POST['submit']) && $statement) {

            echo "<p class='alert'>DVD successfully added.</p>";

        } ?>
        
        <p class="note">Fields marked with an <span class="req">*</span> are required.</p>

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
                    <label for="tv" class="checkbox">TV Series</label>
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