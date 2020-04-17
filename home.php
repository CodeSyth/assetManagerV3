<?php
include './main.php';
    

    //Recent Activity
    if (isset($_POST['isRecentActivity'])) {
        
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        if ($_POST['timeSpan'] == "yesterday"){
            $sql = "Select a.asset_id, a.a_name, a.status, a.a_type, a.create_date, a.modify_date"
                    ." From am_asset a"
                    ." WHERE A.create_date > NOW() - INTERVAL 1 DAY"
                    ." ORDER BY A.a_type;";

        } else if ($_POST['timeSpan'] == "lastWeek"){
            $sql = "Select a.asset_id, a.a_name, a.status, a.a_type, a.create_date, a.modify_date"
                    ." From am_asset a"
                    ." WHERE A.create_date > NOW() - INTERVAL 1 WEEK"
                    ." ORDER BY A.a_type;";

        } else if ($_POST['timeSpan'] == "lastMonth"){
            $sql = "Select a.asset_id, a.a_name, a.status, a.a_type, a.create_date, a.modify_date"
                    ." From am_asset a"
                    ." WHERE A.create_date > NOW() - INTERVAL 1 MONTH"
                    ." ORDER BY A.a_type;";
        }
        
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



    


    //Dashboard Data
    if (isset($_POST['isDashboard'])) {
        
        $conn = mysqli_connect("127.0.0.1", "root", "", "asset_management");
        if (!$conn) {
            $errors_array[] = array("status" => "FAIL", "message" => "Error: Unable to connect to MySQL." . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging errno: " . mysqli_connect_errno() . PHP_EOL);
            $errors_array[] = array("status" => "FAIL", "message" => "Debugging error: " . mysqli_connect_error() . PHP_EOL);
            echo json_encode($errors_array);
            exit;
        }
        
        if ($_POST['option'] == "status"){
            $sql = sprintf("SELECT month(A.create_date)-1 AS create_Month, COUNT(a.Status) AS TotalCount, LOWER(A.status) as status"
                         . " FROM  am_asset a "
                         . " GROUP BY MONTH(A.create_date), A.status "
                         . " ORDER by create_Month desc; ");

            $result =$conn->query($sql);


            $rows = array();
            $rows['active'][] = array_fill(0, 12, 0);
            $rows['broken'][] = array_fill(0, 12, 0);
            $rows['disabled'][] = array_fill(0, 12, 0);
            $rows['other'][] = array_fill(0, 12, 0);
           
        

            while($row = $result->fetch_assoc()) {


                if ($row['status'] == 'active') {
                    $rows['active'][0][$row['create_Month']] += $row['TotalCount'];
                } elseif ($row['status'] == 'broken') {
                    $rows['broken'][0][$row['create_Month']] += $row['TotalCount'];
                } elseif ($row['status'] == 'disabled') {
                    $rows['disabled'][0][$row['create_Month']] += $row['TotalCount'];
                } else {
                    $rows['other'][0][$row['create_Month']] += $row['TotalCount'];
                }   
                
            }

        } else {

            $sql = sprintf("SELECT month(A.create_date)-1 AS create_Month, COUNT(a.Status) AS TotalCount, LOWER(A.a_type) as a_type"
            . " FROM  am_asset a "
            . " GROUP BY MONTH(A.create_date), A.a_type "
            . " ORDER by create_Month desc; ");

            $result =$conn->query($sql);


            $rows = array();
            $rows['hardware'][] = array_fill(0, 12, 0);
            $rows['software'][] = array_fill(0, 12, 0);

            while($row = $result->fetch_assoc()) {

                if ($row['a_type'] == 'hardware') {
                    $rows['hardware'][0][$row['create_Month']] += $row['TotalCount'];
                } elseif ($row['a_type'] == 'software') {
                    $rows['software'][0][$row['create_Month']] += $row['TotalCount'];
                }   
            
            }



        }
       
        
        echo json_encode($rows);
        $conn->close();
        exit;
    }


?>
