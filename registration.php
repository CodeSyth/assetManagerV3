<?php
//check passwords are the same
//hash them 
//save the hash, username, dob, etc.

include 'main.php';


    $errors_array = array();

    //Registration ot add am_user record.
    if (isset($_POST['firstName'])) {

        if (empty($_POST['firstName']) 
         or empty($_POST['lastName']) 
         or empty($_POST['email']) 
         or empty($_POST['phone']) 
         or empty($_POST['dob'])
         or empty($_POST['username']) 
         or empty($_POST['password']) 
         or empty($_POST['passwordConfirm'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "Ensure all fields are entered properly.");
            echo json_encode($errors_array);
            exit;
        }

        if ($_POST['password'] != $_POST['passwordConfirm']) {
            $errors_array[] = array("status" => "FAIL", "message" => "Passwords don't match!");
            echo json_encode($errors_array);
            exit;
        }

        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }

        $userID = getUUID($conn);
        $errors_array[] = array("status" => "DATA", "userID" => $userID);

        $sql = sprintf("INSERT INTO am_user(user_id, first_name, last_name, email, phone, dob) VALUES('%s','%s','%s','%s','%s','%s')"
                     , $userID
                     , $_POST['firstName']
                     , $_POST['lastName']
                     , $_POST['email']
                     , $_POST['phone']
                     , $_POST['dob']
                     );

        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "User Posted Properly!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }

        $userCredID = getUUID($conn);
        $errors_array[] = array("status" => "DATA", "userCredID" => $userCredID);

        //Based upon https://stackoverflow.com/questions/1581610/how-can-i-store-my-users-passwords-safely

        // $hash is what you would store in your database
//        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
        $hash = $_POST['password'];

        $sql = sprintf("INSERT INTO am_user_cred(user_id, user_cred_id, username, password) VALUES('%s','%s','%s','%s')"
                     , $userID
                     , $userCredID
                     , $_POST['username']
                     , $hash
                     );

        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "User Credentials Posted Properly!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }

        $conn->close();
        
        echo json_encode($errors_array);
        exit;
    }

?>
