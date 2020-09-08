<?php include "templates/header.php"; ?>

<?php 

// include the config and common files
require "../config.php";
require "common.php";

// run when submit button is clicked
if(isset($_POST['submit'])){
        
    if(!empty($_FILES["image"]["name"])){
        include "templates/upload.php";
    }else{
        $imgid = $_POST["image"];
    }

    try{
        $connection = new PDO($dsn, $username, $password, $options);

        // grab elements from form and set as variable
        $film =[
          "id"          => $_POST['id'],
          "title"       => $_POST['title'],
          "image"       => $imgid,
          "director"    => $_POST['director'],
          "starring"    => $_POST['starring'],
          "genre"       => $_POST['genre'],
          "tv"          => $_POST['tv'],
          "season"      => $_POST['season'],
          "releasedate" => $_POST['releasedate'],
          "date"        => $_POST['date']
        ];

        // create SQL statement
        $sql = "UPDATE `dvds` 
                SET title = :title,
                    image = :image,
                    director = :director, 
                    starring = :starring, 
                    genre = :genre, 
                    tv = :tv, 
                    season = :season,
                    releasedate = :releasedate,
                    date = :date
                WHERE id = :id";

        //prepare sql statement
        $statement = $connection->prepare($sql);

        //execute sql statement
        $statement->execute($film);

        // show confirmation message on successful form submission
        if (isset($_POST['submit']) && 
            $statement && 
            empty($input_err) && 
            empty($upload_err)) { ?>

            <p class='alert'>Record successfully updated.<br><a class="return" href="read.php">Return to collection.</a></p>

        <?php }

    }catch(PDOException $error){
        echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }

}
    

// Get data from database
// simple if/else statement to check if the id is available
if(isset($_GET['id'])){
    
    // yes the id exists
    try{
        // standard db connection
        $connection = new PDO($dsn, $username, $password, $options);

        // set if as variable
        $id = $_GET['id'];

        // select statement to get the right data
        $sql = "SELECT * FROM dvds WHERE id = :id"; // dvds table

        // prepare the connection
        $statement = $connection->prepare($sql);

        // bind the id to the PDO id
        $statement->bindValue(':id', $id);

        // now execute the statement
        $statement->execute();

        // attach the sql statement to the new film variable so we can access it in the form
        $film = $statement->fetch(PDO::FETCH_ASSOC);

    }catch(PDOExcpetion $error){
        echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }

}else{
    // no id, show error
    echo "No id. Something went wrong";
    // exit;
} ?>

<div class="container">
    
    <div class="content">
    
        <h2>Edit DVD</h2>
        
        <p class="note">Fields marked with an <span class="req">*</span> are required.</p>

        <?php 
        // show confirmation message on successful form submission
        if(isset($_POST['submit']) && $statement && $uploadOk == 1){ ?>

            <p class='alert'>Record successfully updated.<br><a class="return" href="update.php">Return to collection.</a></p>

        <?php } ?>
        
        <!--form to edit data for each DVD-->
        <form id="createRecord" method="post" enctype="multipart/form-data">
            
            <!-- hidden input for existing image -->
            <input readonly type="hidden" name="image" id="image" value="<?php echo escape($film['image']); ?>" >

            <ul class="addRecord">

                <!-- populate with existing data from database -->
                <!-- hide ID field so it can't be edited -->
                <li class="label">
<!--                    <label for="id">ID</label>-->
                    <input type="hidden" name="id" id="id" value="<?php echo escape($film['id']); ?>" >
                </li>

                <li class="label">
                    <label for="title">Title<span class="req">*</span></label>
                    <input type="text" name="title" id="title" value="<?php echo escape($film['title']); ?>">
                </li>

                <li class="label">
                    <label for="image">Image</label>
                    <?php 
                    // if record had image attached when added, keep image attached
                    if($film['image'] !== NULL && $film["image"] !== ""){ 
                        echo "<img class='thumb' src='uploads/" . $film["image"] . "' alt='" . $film['title'] ."'>";
                    }; ?>
                    
                    <input type="file" name="image" id="image">
                </li>

                <li class="label">
                    <label for="director">Director</label>
                    <input type="text" name="director" id="director" value="<?php echo escape($film['director']); ?>">
                </li>

                <li class="label">
                    <label for="starring">Starring</label>
                    <input type="text" name="starring" id="starring" value="<?php echo escape($film['starring']); ?>">
                </li>

                <li class="label">
                    <label for="genre">Genre</label>
                    <input type="text" name="genre" id="genre" value="<?php echo escape($film['genre']); ?>">
                </li>

                <li class="label">
                    <label for="tv">TV Series</label>
                    <?php 
                    // if record was added as a tv series, keep checkbox checked
                    if(escape($film['tv']) == "Yes"){ ?>
                        <input type="checkbox" name="tv" id="tv" value="Yes" checked onchange="check()">
                    <?php 
                    }else{ ?>
                        <input type="checkbox" name="tv" id="tv" value="Yes">
                    <?php }; ?>
                </li>
                
                <li class="label">
                    <label for="season">Season</label>
                    <input type="number" name="season" id="season" value="<?php echo escape($film['season']); ?>">
                </li>

                <li class="label">
                    <label for="releasedate">Release Date</label>
                    <input type="number" name="releasedate" id="releasedate" value="<?php echo escape($film['releasedate']); ?>">
                </li>

                <p class="field control">
                    <input class="subBtn" type="submit" name="submit" value="Save">
                    <a class="canBtn" href="update.php" onclick="return confirm('Are you sure you want to leave this page? Any unsaved changes will be lost.')";>Cancel</a>
                </p>

            </ul>
        </form>
        
    </div>
    
</div>

<?php include "templates/footer.php"; ?>