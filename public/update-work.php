<?php include "templates/header.php"; ?>

<?php 

// include the config and common files
require "../config.php";
require "common.php";

// run when submit button is clicked
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);  

        } catch(PDOException $error) {
        echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }        

    // grab elements from form and set as varaible
    $film =[
      "id"          => $_POST['id'],
      "title"       => $_POST['title'],
      "image"       => $_POST['image'],
      "director"    => $_POST['director'],
      "starring"    => $_POST['starring'],
      "genre"       => $_POST['genre'],
      "tv"          => $_POST['tv'],
      "season"      => $_POST['season'],
      "releasedate" => $_POST['releasedate'],
      "date"        => $_POST['date'],
    ];

    // create SQL statement
    $sql = "UPDATE `dvds` 
            SET id = :id, 
                title = :title, 
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
    $statement->execute($film); // $work

    // update confirmation
    echo "<p>Changes saved.</p>";

}

// simple if/else statement to check if the id is available
if (isset($_GET['id'])) {
//        // yes the id exists
//        
//        // quickly show the id on the page
//        echo $_GET['id'];

    try {
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
        $film = $statement->fetch(PDO::FETCH_ASSOC); // $work

    } catch(PDOExcpetion $error) {
        echo "<p>" . $sql . "<br>" . $error->getMessage() . "</p>";
    }

} else {

    // no id, show error
    echo "No id - something went wrong";
    // exit;
}
?>

<div class="container">

<!--form to edit data for each DVD-->
<form id="createRecord" method="post">
    
    <ul class="addRecord">
        
        <!-- populate with existing data from database -->    
<!--
        <li class="label">
            <label for="id">ID</label>
            <input type="text" name="id" id="id" value="<?php echo escape($film['id']); ?>" >
        </li>
-->

        <li class="label">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo escape($film['title']); ?>">
        </li>

        <li class="label">
            <label for="image">Image</label>
            <input type="image" name="image" id="image" value="<?php echo escape($film['image']); ?>">
            <input type="file" name="image" id="image" value="<?php echo escape($film['image']); ?>">
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
            <input type="checkbox" name="tv" id="tv" value="<?php echo escape($film['tv']); ?>">
        </li>

        <li class="label">
            <label for="season">Season</label>
            <input type="number" name="season" id="season" value="<?php echo escape($film['season']); ?>">
        </li>

        <li class="label">
            <label for="releasedate">Release Date</label>
            <input type="number" name="releasedate" id="releasedate" value="<?php echo escape($film['releasedate']); ?>">
        </li>
        
        <p class="field">
            <input class="subBtn notification is-primary" type="submit" name="submit" value="Save">
        </p>
    
    </ul>
    
</form>
    
</div>

<?php include "templates/footer.php"; ?>