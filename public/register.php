<?php

// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    }else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
		
        if($stmt = $pdo_connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
			
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                }else{
                    $username = trim($_POST["username"]);
                }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password."; 
    }elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must contain at least 6 characters.";
    }else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    }else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords do not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
		
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
        if($stmt = $pdo_connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            }else{
                echo "Oh no! Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
	<link rel="stylesheet" href="assets/css/style.css">	
</head>

<body>
    <div class="container">
        <h2>Sign Up</h2>
        
        <div class="content">
            <p>Please fill this form to create an account.</p>
            
            <hr>
		
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="field <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <p class="control has-icons-left has-icons-right">
                        <label>
                            <i class="fas fa-user"></i>
                            Username
                        </label>
                        <input type="text" name="username" class="input is-focused is-success" placeholder="Username" value="<?php echo $username; ?>">
                        <span class="help icon is-small is-left">
                            <?php echo $username_err; ?>
                        </span>
                    </p>
                </div>    

                <div class="field <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <p class="control has-icons-left">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>">
                        <span class="help"><?php echo $password_err; ?></span>
                    </p>
                </div>

                <div class="field <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <p class="control has-icons-left">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="Confirm password" class="form-control" value="<?php echo $confirm_password; ?>">
                        <span class="help"><?php echo $confirm_password_err; ?></span>
                    </p>
                </div>

                <div class="field">
                    <input type="submit" class="subBtn" value="Submit">
                    <input type="reset" class="resBtn" value="Reset">
                </div>
                
                <p class="spacer"></p>

                <p class="other">Already have an account? <a class="btn" href="login.php">Login here</a></p>
                
            </form>
        </div>
		
    </div>
</body>
</html>

<?php include "templates/footer.php"; ?>