<?php

    $errors_array = array();

    if (isset($_POST['username']) &&  isset($_POST['password'])) {
        
        
        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
            if (!$conn) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
    

            $result = $conn->query(sprintf("SELECT * FROM am_user_cred WHERE username = '%s';",$_POST['username']));
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $checked = ($_POST['password'] == $row["password"]);
                    if ($checked) {
                        $errors_array[] = array("status" => "SUCCESS", "message" => "Login Success");
                        echo json_encode($errors_array);
                        exit;
                    } else {
                        $errors_array[] = array("status" => "FAIL", "message" => "Password Incorrect");
                        echo json_encode($errors_array);
                        exit;
                    }
                }
            } else {
                echo "Failed to return records for username.";
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
