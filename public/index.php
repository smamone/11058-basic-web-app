<?php
// if user is not logged in, redirect them to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} ?>

<?php include "templates/header.php"; ?>

<body>
</body>

<?php include "templates/footer.php"; ?>