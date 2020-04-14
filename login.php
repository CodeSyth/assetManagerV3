<?php

    $errors_array = array();

    if (isset($_POST['username']) &&  isset($_POST['password'])) {
        
        
        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $link = mysqli_connect("127.0.0.1", "root", "", "asset_management");
            if (!$link) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
    
            $un=$_POST['username'];
            $pw=$_POST['password'];
        
            $sql = mysqli_query($link, "SELECT * FROM am_user_cred WHERE username = '"+$un+"' AND password = '"+$pw+"';");
            $row = mysqli_num_rows($sql);
            
            if($row==1){
              echo $errors_array[] = array("status" => "SUCCESS", "message" => "Login Successful");
              exit();
            } else {
              echo $errors_array[] = array("status" => "FAIL", "message" => "Login Failure");
            }
    
            echo json_encode($errors_array);
            exit;
        } else if (empty($_POST['username']) &&  empty($_POST['password'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "Username cannot be blank!");
            $errors_array[] = array("status" => "FAIL", "message" => "Password cannot be blank!");
            echo json_encode($errors_array);
            exit;
        } else if (!empty($_POST['username']) &&  empty($_POST['password'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "Password cannot be blank!");
            echo json_encode($errors_array);
            exit;
        } else if (empty($_POST['username']) &&  !empty($_POST['password'])) {
            // username not set
            $errors_array[] = array("status" => "FAIL", "message" => "Username cannot be blank!");
            echo json_encode($errors_array);
            exit;
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Not Caught");
            echo json_encode($errors_array);
            exit;
        }           
    }

?>
