<?php
// Include config file
require_once "config.php";
 
// Variables
$msg = '';
$username = $password = "";
$username_err = $password_err = "";

// Check if POST data is not empty
    if (!empty($_POST)) {

        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else{
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";
            
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_username);
                
                // Set parameters
                $param_username = trim($_POST["username"]);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // store result
                    $stmt->store_result();
                    
                    if($stmt->num_rows == 1){
                        $username_err = "This username is already taken.";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    $msg = "Something went wrong. Please try again later.";
                }

                // Close statement
                $stmt->close();
            }
        }

    // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST["password"]);
        }
    
        if($stmt = $mysqli->prepare($sql)){
            //Prepared statement 
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $mysqli->prepare($sql);
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $msg = "Created Successfully!";
            } else{
                $msg = "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }

    $mysqli->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create user</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
    <div class="content update">
	<h2>Create user</h2>
    <form action="create.php" method="post">

    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>   
        
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
        
        <input class="btn btn-primary" type="submit" value="Create">
        <a class="btn btn-primary" href="welcome.php">Homepage</a>

    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>
    </div>    
</body>
</html>