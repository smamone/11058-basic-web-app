<?php
    
// Initialize/resume the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<?php include "templates/header.php"; ?>

<div class="container">

    <div class="page-header">
        <h1><?php echo htmlspecialchars($_SESSION["username"]); ?>'s DVD tracker</h1>
    </div>
    <div class="centre">
        <a href="reset-password.php" class="resBtn notification is-danger">
            <i class="fas fa-wrench"></i> Reset password
        </a>
        <a href="logout.php" class="outBtn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
    
</div>

<?php include "templates/footer.php"; ?>