<?php
//include files
require_once "config.php";
include "process.php";

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Main page</h2>
            <a class="btn btn-primary" href="logout.php">Logout</a>
            <a class="btn btn-primary" href="create.php">Create user</a>
            <a class="btn btn-primary" href="reset-password.php">Reset password</a>

            <?php  $sql = "SELECT * FROM users ORDER BY id";

            $result = $mysqli->query($sql)
            ?>

            <div> 
                <table class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Created at</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <?php 
                        while ($row = $result->fetch_assoc()): 
                    ?>

                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <a href="welcome.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                                <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>

                        <?php endwhile; ?>

                </table>
            </div>

            <form action="process.php" method="POST">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>"></input>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                
                <div class="form-group">
                    <?php if(!isset($_GET['edit'])): ?>
                        <button type="submit" class="btn btn-primary" name="update" disabled>Update</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <?php endif; ?>    
                </div>
            </form> 

        </div>    
    </body>
</html>