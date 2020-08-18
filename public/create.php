<?php
// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {

// include the config file that we created before
require "../config.php";
//include "templates/header.php";
    
// this is called a try/catch statement
try {
    
    // FIRST: Connect to the database
    $connection = new PDO($dsn, $username, $password, $options);
    
    // SECOND: Get the contents of the form and store it in an array
    $newDvd = array( 
        "title"       => $_POST['title'], 
        "image"       => $_POST['image'],
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

    <h2>Add a DVD</h2>

    <?php if (isset($_POST['submit']) && $statement) { ?>

        <p>DVD successfully added.</p>

<?php } ?>

<!--form to collect data for each DVD-->
<form id="createRecord" method="post">
    
    <ul class="addRecord">
    
        <li class="label">
            <label for="title">Title</label> 
            <input type="text" name="title" id="title">
        </li>

        <li class="label">
            <label for="image">Image</label> 
            <input type="image" name="image" id="image">
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
            <input class="checkbox" type="checkbox" name="tv" id="tv">
        </li>

        <li class="label">
            <label for="season">Season</label>
            <input type="number" name="season" id="season">
        </li>

        <li class="label">
            <label for="releasedate">Release Date</label>
            <input type="number" name="releasedate" id="releasedate">
        </li>

        <p class="field">
            <input class="addBtn notification is-primary" type="submit" name="submit" value="Add">
        </p>
    
    </ul>
    
</form>
    
</div>

<?php include "templates/footer.php"; ?>