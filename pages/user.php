<?php
include './../main.php';
    

    //User Search
    if (isset($_POST['isSearch'])) {
        
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        $sql = "SELECT * FROM am_user ";
        $isFirst = true;

        if (!empty($_POST['firstName'])){
            if ($isFirst) {
                $sql = $sql . sprintf(" WHERE first_name LIKE '%s'", $_POST['firstName']); 
                $isFirst = false;   
            }
        } 

        if (!empty($_POST['lastName'])){
            if ($isFirst) {
                $sql = $sql . sprintf("  WHERE last_name LIKE '%s'", $_POST['lastName']);    
                $isFirst = false;   
            } else {
                $sql = $sql . sprintf("  AND last_name LIKE '%s'", $_POST['lastName']);    
            }
        } 

        if (!empty($_POST['email'])){
            if ($isFirst) {
                $sql = $sql . sprintf("  WHERE email LIKE '%s'", $_POST['email']);    
                $isFirst = false;   
            } else {
                $sql = $sql . sprintf("  AND email LIKE '%s'", $_POST['email']);    
            }
        } 

        $sql = $sql . sprintf(";");
        // echo $sql . "\n";    
        $result = $conn->query($sql);


        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        echo json_encode($rows);
        $conn->close();
        exit;
    }


    //Load User
    if (isset($_POST['loadUserID'])){
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        if (!empty($_POST['loadUserID'])){
            $t = $_POST['loadUserID'];
            $sql = sprintf("SELECT * FROM am_user WHERE user_id = '%s';"
                , $t
                );

            $result =$conn->query($sql);
        } else {
            $result =$conn->query("SELECT * FROM am_user");
        }

        $rows = array();
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
       
        echo json_encode($rows);
        $conn->close();
        exit;
    }

    //Save Company
    if (isset($_POST['isSave'])){
        $errors_array = array();

        if (empty($_POST['firstName']) 
        or empty($_POST['lastName'])) {
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

        if (empty($_POST['userID'])){
            //Insert
            $userID = getUUID($conn);
            $sql = sprintf("INSERT INTO am_user(user_id, first_name, last_name, email, phone, dob) VALUES('%s','%s','%s','%s','%s','%s')"
            , $userID
            , $_POST['firstName']
            , $_POST['lastName']
            , $_POST['email']
            , $_POST['phone']
            , $_POST['dob']
            );
        } else {
            //Edit
            $userID = $_POST['userID'];
            $sql = sprintf("UPDATE am_user SET first_name='%s',last_name='%s', email='%s', phone='%s', dob='%s' WHERE user_id = '%s';"
                , $_POST['firstName']
                , $_POST['lastName']
                , $_POST['email']
                , $_POST['phone']
                , $_POST['dob']
                , $userID
                );
        }

        $errors_array[] = array("status" => "DATA", "userID" => $userID);

        //Execute SQL
        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "User Saved!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }


        $conn->close();
        echo json_encode($errors_array);
        exit;
    }

    //Delete Company
    if (isset($_POST['isDelete'])){
        $errors_array = array();

        if (empty($_POST['userID'])) {
            $errors_array[] = array("status" => "FAIL", "message" => "No user is selected for delete.");
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

        //Delete
        $companyID = $_POST['userID'];
        $sql = sprintf("DELETE FROM am_user WHERE user_id = '%s';"
            , $companyID
            );

        //Execute SQL
        if (mysqli_query($conn, $sql)) {
            //success
            $errors_array[] = array("status" => "SUCCESS", "message" => "User Deleted!");
        } else {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: " . $sql . "" . mysqli_error($conn));
        }


        $conn->close();
        echo json_encode($errors_array);
        exit;
    }



    



?>
