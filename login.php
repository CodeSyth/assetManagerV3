<?php

    $errors_array = array();

    if (isset($_POST['username']) &&  isset($_POST['password'])) {
        
        
        if (!empty($_POST['userName']) && !empty($_POST['password'])) {

            $link = mysqli_connect("127.0.0.1", "root", "", "asset_management");
            if (!$link) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
    
            $errors_array[] = array("status" => "SUCCESS", "message" => "Success: A proper connection to MySQL was made! The my_db database is great. Host information: ". mysqli_get_host_info($link));
    
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
            $errors_array[] = array("status" => "FAIL", "message" => "Username cannot be blank! 2");
            echo json_encode($errors_array);
            exit;
        }            
    }

?>
