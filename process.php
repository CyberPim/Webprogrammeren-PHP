<?php

//Include files
require_once "config.php";

// Set variables
$username_err = $username = '';

    //Check if delete button is pressed
    if (isset($_GET['delete'])){
        $id = $_GET['delete'];
        
        //Prepare sql statement
        $sql = "DELETE FROM users WHERE id= ?";
        if($stmt = $mysqli->prepare($sql)){
            
            $stmt->bind_param("i", $param_id);
            $param_id = $id;
    
            $stmt->execute() or die($mysqli->error());

            // Redirect user to welcome page
            header("location: welcome.php");
        }
        else{
            echo "Something went wrong. Please try again later.";
        }
    }

    //Check if edit button is pressed
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        
        //Prepare sql statement
        $sql = "SELECT username FROM users WHERE id= ?";
        if($stmt = $mysqli->prepare($sql)){
            
            $stmt->bind_param("i", $param_id);
            $param_id = $id;
    
            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $stmt->bind_result($username);
                    $stmt->fetch();
                }
                else{
                    echo "Something went wrong. Please try again later.";
                }
            }
            else{
                echo "Something went wrong. Please try again later.";
            }
            
        }
       
    }

    //Check if update button is pressed
    if(isset($_POST['update'])){

        $id = $_POST['id'];

        if(!empty(trim($_POST['username']))){
            $username = $_POST['username'];

            //Prepare sql statement
            $sql = "UPDATE users SET username= ? WHERE id= ?";
            if($stmt = $mysqli->prepare($sql)){
                
                $stmt->bind_param("si",$param_username, $param_id);
                $param_username = $username;
                $param_id = $id;
        
                $stmt->execute() or die($mysqli->error());

                // Redirect user to welcome page
                header("location: welcome.php");
            }
            else{
                echo "Something went wrong. Please try again later.";
            }
        }
        else{
            header("location: welcome.php");
        }
    }
?>