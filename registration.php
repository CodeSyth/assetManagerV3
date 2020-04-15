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
         or empty($_POST['dob'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "Ensure all fields are entered properly.");
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

        $UUID = getUUID();
        $errors_array[] = array("status" => "DATA", "ID" => $UUID);

        $sql = sprintf("INSERT INTO am_user(user_id, first_name, last_name, email, phone, dob) VALUES(%s,'%s','%s','%s','%s','%s')"
                     , $UUID
                     , $_POST['firstName']
                     , $_POST['lastName']
                     , $_POST['email']
                     , $_POST['phone']
                     , $_POST['dob']
                     );

        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "Everything posted!");

        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }
        $conn->close();
        
        echo json_encode($errors_array);
        exit;
    }




    



    // if (isset($_POST['username']) && isset($_POST['password'])) {
        
    //     if (empty($_POST['username']) or empty($_POST['password']) or empty($_POST['passwordConfirm'])) {
    //         $errors_array[] = array("status" => "FAIL", "message" => "Ensure all fields are entered properly.");
    //         echo json_encode($errors_array);
    //         exit;
    //     }



        
    //     if (!empty($_POST['username']) && !empty($_POST['password'])) {

    //         $link = mysqli_connect("127.0.0.1", "root", "", "asset_management");
    //         if (!$link) {
    //             echo "Error: Unable to connect to MySQL." . PHP_EOL;
    //             echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    //             echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    //             exit;
    //         }
    
    //         $un=$_POST['username'];
    //         $pw=$_POST['password'];
        
    //         $sql = mysqli_query($link, "SELECT * FROM am_user_cred WHERE username = '"+$un+"' AND password = '"+$pw+"';");
    //         $row = mysqli_num_rows($sql);
            
    //         if($row==1){
    //           echo $errors_array[] = array("status" => "SUCCESS", "message" => "Login Successful");
    //           exit();
    //         } else {
    //           echo $errors_array[] = array("status" => "FAIL", "message" => "Login Failure");
    //         }
    
            
    //     } else if (empty($_POST['username']) &&  empty($_POST['password'])) {
    //         $errors_array[] = array("status" => "FAIL", "message" => "Username cannot be blank!");
    //         $errors_array[] = array("status" => "FAIL", "message" => "Password cannot be blank!");
    //         echo json_encode($errors_array);
    //         exit;
    //     } else if (!empty($_POST['username']) &&  empty($_POST['password'])) {
    //         $errors_array[] = array("status" => "FAIL", "message" => "Password cannot be blank!");
    //         echo json_encode($errors_array);
    //         exit;
    //     } else if (empty($_POST['username']) &&  !empty($_POST['password'])) {
    //         // username not set
    //         $errors_array[] = array("status" => "FAIL", "message" => "Username cannot be blank!");
    //         echo json_encode($errors_array);
    //         exit;
    //     } else {
    //         $errors_array[] = array("status" => "FAIL", "message" => "Not Caught");
    //         echo json_encode($errors_array);
    //         exit;
    //     }           
    // }

?>
