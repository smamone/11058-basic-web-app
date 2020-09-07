<?php

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

?>