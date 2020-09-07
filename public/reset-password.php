<?php

// Initialize/resume the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    }else if(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have at least 6 characters.";
    }else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    }else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Passwords do not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        
        // Prepare an update statement
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        
        if($stmt = $pdo_connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                
                // Show registration confirmation
                echo "<p class='alert'>New password saved successfully. You will automatically be redirected to the log in page.</p>
                <p>If you are not redirected in 5 seconds, <a href='login.php'>click here</a>.</p>";
                
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                    
                // Redirect to log in page after 3 seconds
                header("refresh: 5; url=login.php");
                exit();
                
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo_connection);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
    
<body>
    <div class="container">
        
        <h2>Reset Password</h2>
        
        <div class="content">
            <p>Please complete this form to reset your password.</p>
            
            <hr>
        
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="field <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                    <p class="control">
                        <label>New password</label>
                        <input type="password" name="new_password" placeholder="New password" class="field" value="<?php echo $new_password; ?>">
                        <span class="help"><?php echo $new_password_err; ?></span>
                    </p>
                </div>
                <div class="field <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <p class="control">
                        <label>Confirm password</label>
                        <input type="password" name="confirm_password" placeholder="Confirm password" class="field">
                        <span class="help"><?php echo $confirm_password_err; ?></span>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="submit" class="subBtn" value="Submit">
                        <a class="canBtn" href="welcome.php">Cancel</a>
                    </p>
                </div>

            </form>
        </div>
        
    </div>

<?php include "templates/footer.php"; ?>