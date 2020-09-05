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

    <div class="pageHeader">
        <h2><?php echo htmlspecialchars($_SESSION["username"]); ?>'s account</h2>
    </div>
    <div class="centre">
        <a href="reset-password.php" class="resBtn">
            <i class="fas fa-wrench"></i> Reset password
        </a>
        <a href="logout.php" class="outBtn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
    
</div>

<?php include "templates/footer.php"; ?>